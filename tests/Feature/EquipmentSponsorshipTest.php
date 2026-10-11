<?php

namespace Tests\Feature;

use App\Models\EquipmentSponsorship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentSponsorshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_equipment_sponsorship_page_displays_registration_form_and_equipment_options(): void
    {
        $response = $this->get(route('information.show', 'sponsor-equipment'));

        $response->assertOk()
            ->assertSee('Equipment sponsorship inquiry')
            ->assertSee('name="equipment"', false)
            ->assertSee('Projector and screen')
            ->assertSee('3.0 kW inverter generator')
            ->assertSee('name="consent"', false);
    }

    public function test_person_can_submit_an_equipment_sponsorship_inquiry_visible_to_admin(): void
    {
        $response = $this->post(route('equipment-sponsorships.store'), [
            'contact_name' => 'Ama Mensah',
            'email' => 'Ama.Mensah@example.com',
            'phone' => '+233 20 123 4567',
            'equipment' => 'Projector and screen',
            'message' => 'I can sponsor the projector.',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('information.show', 'sponsor-equipment'))
            ->assertSessionHas('status', 'Thank you for your equipment sponsorship interest. The AkuaBa team will follow up with you.');
        $this->assertDatabaseHas('equipment_sponsorships', [
            'contact_name' => 'Ama Mensah',
            'email' => 'ama.mensah@example.com',
            'phone' => '+233 20 123 4567',
            'equipment' => 'Projector and screen',
            'message' => 'I can sponsor the projector.',
        ]);

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $sponsorship = EquipmentSponsorship::where('email', 'ama.mensah@example.com')->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Interested equipment sponsors')
            ->assertSee('Ama Mensah')
            ->assertSee('mailto:ama.mensah@example.com', false)
            ->assertSee('tel:+233201234567', false)
            ->assertSee('Projector and screen')
            ->assertSee('I can sponsor the projector.')
            ->assertSee('action="'.route('admin.equipment-sponsorships.destroy', $sponsorship).'"', false);
    }

    public function test_equipment_sponsorship_rejects_an_item_outside_the_list(): void
    {
        $response = $this->from(route('information.show', 'sponsor-equipment'))
            ->post(route('equipment-sponsorships.store'), [
                'contact_name' => 'Ama Mensah',
                'email' => 'ama@example.com',
                'phone' => '020 111 2222',
                'equipment' => 'Laptop',
                'consent' => '1',
            ]);

        $response->assertRedirect(route('information.show', 'sponsor-equipment'))
            ->assertSessionHasErrors('equipment');
        $this->assertDatabaseCount('equipment_sponsorships', 0);
    }

    public function test_admin_can_remove_an_equipment_sponsorship_inquiry(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $sponsorship = EquipmentSponsorship::create([
            'contact_name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'equipment' => 'Projector and screen',
            'consented_at' => now(),
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.equipment-sponsorships.destroy', $sponsorship));

        $response->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('status', 'The equipment sponsorship inquiry has been removed.');
        $this->assertDatabaseMissing('equipment_sponsorships', ['id' => $sponsorship->id]);
    }

    public function test_guests_cannot_remove_equipment_sponsorship_inquiries(): void
    {
        $sponsorship = EquipmentSponsorship::create([
            'contact_name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'equipment' => 'Projector and screen',
            'consented_at' => now(),
        ]);

        $response = $this->delete(route('admin.equipment-sponsorships.destroy', $sponsorship));

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseHas('equipment_sponsorships', ['id' => $sponsorship->id]);
    }

    public function test_each_submission_is_kept_as_a_separate_sponsorship_inquiry(): void
    {
        $payload = [
            'contact_name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'equipment' => 'Projector and screen',
            'consent' => '1',
        ];

        $this->post(route('equipment-sponsorships.store'), $payload);
        $payload['equipment'] = 'Rechargeable PA system';
        $this->post(route('equipment-sponsorships.store'), $payload);

        $this->assertDatabaseCount('equipment_sponsorships', 2);
        $this->assertDatabaseHas('equipment_sponsorships', ['equipment' => 'Projector and screen']);
        $this->assertDatabaseHas('equipment_sponsorships', ['equipment' => 'Rechargeable PA system']);
    }
}
