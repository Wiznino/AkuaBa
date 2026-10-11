<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VolunteerRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VolunteerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_volunteer_page_displays_registration_form(): void
    {
        $response = $this->get(route('information.show', 'volunteer'));

        $response->assertOk()
            ->assertSee('Volunteer registration')
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="phone"', false)
            ->assertSee('name="consent"', false);
    }

    public function test_volunteer_can_register_and_admin_can_contact_them(): void
    {
        $response = $this->post(route('volunteer.register'), [
            'name' => 'Ama Mensah',
            'email' => 'Ama.Mensah@example.com',
            'phone' => '+233 20 123 4567',
            'interests' => 'STEM mentoring',
            'availability' => 'Weekends',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('information.show', 'volunteer'))
            ->assertSessionHas('status', 'Thank you for registering your interest in volunteering with AkuaBa.');
        $this->assertDatabaseHas('volunteer_registrations', [
            'name' => 'Ama Mensah',
            'email' => 'ama.mensah@example.com',
            'phone' => '+233 20 123 4567',
            'interests' => 'STEM mentoring',
            'availability' => 'Weekends',
        ]);

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Interested volunteers')
            ->assertSee('1')
            ->assertSee('Ama Mensah')
            ->assertSee('mailto:ama.mensah@example.com', false)
            ->assertSee('tel:+233201234567', false)
            ->assertSee('action="'.route('admin.volunteers.destroy', VolunteerRegistration::where('email', 'ama.mensah@example.com')->first()).'"', false)
            ->assertSee('Remove')
            ->assertSee('STEM mentoring');
    }

    public function test_volunteer_contact_list_is_not_available_to_guests(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_remove_a_volunteer_registration(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $volunteer = VolunteerRegistration::create([
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'consented_at' => now(),
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.volunteers.destroy', $volunteer));

        $response->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('status', 'The volunteer registration has been removed.');
        $this->assertDatabaseMissing('volunteer_registrations', ['id' => $volunteer->id]);
    }

    public function test_guests_cannot_remove_volunteer_registrations(): void
    {
        $volunteer = VolunteerRegistration::create([
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'consented_at' => now(),
        ]);

        $response = $this->delete(route('admin.volunteers.destroy', $volunteer));

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseHas('volunteer_registrations', ['id' => $volunteer->id]);
    }

    public function test_non_admin_users_cannot_remove_volunteer_registrations(): void
    {
        $volunteer = VolunteerRegistration::create([
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'consented_at' => now(),
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->delete(route('admin.volunteers.destroy', $volunteer));

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseHas('volunteer_registrations', ['id' => $volunteer->id]);
    }

    public function test_registering_again_updates_the_existing_volunteer_record(): void
    {
        $registration = VolunteerRegistration::create([
            'name' => 'Ama Mensah',
            'email' => 'ama@example.com',
            'phone' => '020 111 2222',
            'consented_at' => now(),
        ]);

        $response = $this->post(route('volunteer.register'), [
            'name' => 'Ama Mensah-Boateng',
            'email' => 'AMA@example.com',
            'phone' => '020 333 4444',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('information.show', 'volunteer'));
        $this->assertDatabaseCount('volunteer_registrations', 1);
        $this->assertDatabaseHas('volunteer_registrations', [
            'id' => $registration->id,
            'name' => 'Ama Mensah-Boateng',
            'email' => 'ama@example.com',
            'phone' => '020 333 4444',
        ]);
    }

    public function test_volunteer_registration_requires_contact_consent(): void
    {
        $response = $this->from(route('information.show', 'volunteer'))
            ->post(route('volunteer.register'), [
                'name' => 'Ama Mensah',
                'email' => 'ama@example.com',
                'phone' => '020 111 2222',
            ]);

        $response->assertRedirect(route('information.show', 'volunteer'))
            ->assertSessionHasErrors('consent');
        $this->assertDatabaseCount('volunteer_registrations', 0);
    }
}
