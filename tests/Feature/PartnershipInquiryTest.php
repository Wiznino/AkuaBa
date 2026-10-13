<?php

namespace Tests\Feature;

use App\Models\PartnershipInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnershipInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_recognizes_the_confirmed_bokuruwa_school_host_and_offers_contact_options(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Bokuruwa D/A Junior High School, Kwahu')
            ->assertSee('School outreach host')
            ->assertSee('src="'.asset('uploads/akuaba-bokuruwa-school-sign.jpg').'"', false)
            ->assertSee('href="'.route('information.show', 'partner').'"', false)
            ->assertSee('href="tel:0207495972"', false);
    }

    public function test_partner_page_displays_partnership_inquiry_form(): void
    {
        $response = $this->get(route('information.show', 'partner'));

        $response->assertOk()
            ->assertSee('Partnership inquiry')
            ->assertSee('name="organization"', false)
            ->assertSee('name="contact_name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="phone"', false)
            ->assertSee('name="proposal"', false)
            ->assertSee('name="consent"', false);
    }

    public function test_organization_can_submit_an_inquiry_visible_to_admin(): void
    {
        $response = $this->post(route('partnership-inquiries.store'), [
            'organization' => 'Accra Community School',
            'contact_name' => 'Ama Mensah',
            'email' => 'Ama.Mensah@example.com',
            'phone' => '+233 20 123 4567',
            'proposal' => 'Host a STEM workshop for students.',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('information.show', 'partner'))
            ->assertSessionHas('status', 'Thank you for your partnership inquiry. The AkuaBa team will follow up with you.');
        $this->assertDatabaseHas('partnership_inquiries', [
            'organization' => 'Accra Community School',
            'contact_name' => 'Ama Mensah',
            'email' => 'ama.mensah@example.com',
            'phone' => '+233 20 123 4567',
            'proposal' => 'Host a STEM workshop for students.',
        ]);

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Interested partners')
            ->assertSee('1')
            ->assertSee('Accra Community School')
            ->assertSee('Ama Mensah')
            ->assertSee('mailto:ama.mensah@example.com', false)
            ->assertSee('tel:+233201234567', false)
            ->assertSee('Host a STEM workshop for students.')
            ->assertSee('action="'.route('admin.partnership-inquiries.destroy', PartnershipInquiry::where('email', 'ama.mensah@example.com')->first()).'"', false)
            ->assertSee('Remove');
    }

    public function test_admin_can_remove_a_partnership_inquiry(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $inquiry = PartnershipInquiry::create([
            'organization' => 'Accra Community School',
            'contact_name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'proposal' => 'Host a STEM workshop.',
            'consented_at' => now(),
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.partnership-inquiries.destroy', $inquiry));

        $response->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('status', 'The partnership inquiry has been removed.');
        $this->assertDatabaseMissing('partnership_inquiries', ['id' => $inquiry->id]);
    }

    public function test_guests_cannot_remove_partnership_inquiries(): void
    {
        $inquiry = PartnershipInquiry::create([
            'organization' => 'Accra Community School',
            'contact_name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'proposal' => 'Host a STEM workshop.',
            'consented_at' => now(),
        ]);

        $response = $this->delete(route('admin.partnership-inquiries.destroy', $inquiry));

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseHas('partnership_inquiries', ['id' => $inquiry->id]);
    }

    public function test_submitting_again_updates_the_inquiry_for_the_same_email(): void
    {
        $inquiry = PartnershipInquiry::create([
            'organization' => 'Accra Community School',
            'contact_name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'proposal' => 'Initial proposal.',
            'consented_at' => now(),
        ]);

        $response = $this->post(route('partnership-inquiries.store'), [
            'organization' => 'Accra STEM Academy',
            'contact_name' => 'Ama Mensah',
            'email' => 'AMA@example.com',
            'phone' => '020 333 4444',
            'proposal' => 'Updated proposal.',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('information.show', 'partner'));
        $this->assertDatabaseCount('partnership_inquiries', 1);
        $this->assertDatabaseHas('partnership_inquiries', [
            'id' => $inquiry->id,
            'organization' => 'Accra STEM Academy',
            'email' => 'ama@example.com',
            'phone' => '020 333 4444',
            'proposal' => 'Updated proposal.',
        ]);
    }

    public function test_partnership_inquiry_requires_contact_consent(): void
    {
        $response = $this->from(route('information.show', 'partner'))
            ->post(route('partnership-inquiries.store'), [
                'organization' => 'Accra Community School',
                'contact_name' => 'Ama Mensah',
                'email' => 'ama@example.com',
                'phone' => '020 111 2222',
                'proposal' => 'Host a STEM workshop.',
            ]);

        $response->assertRedirect(route('information.show', 'partner'))
            ->assertSessionHasErrors('consent');
        $this->assertDatabaseCount('partnership_inquiries', 0);
    }

    public function test_partnership_inquiry_contact_list_is_not_available_to_guests(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }
}
