<?php

namespace Tests\Feature;

use App\Mail\OutreachUpdateMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OutreachSignupTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_subscriber_is_stored_and_sent_a_welcome_email(): void
    {
        Mail::fake();

        $response = $this->post(route('outreach.subscribe'), [
            'first_name' => 'Ama',
            'last_name' => 'Mensah',
            'email' => 'Ama.Mensah@example.com',
            'consent' => '1',
        ]);

        $response->assertRedirect(route('outreach.signup'));
        $response->assertSessionHas('status', 'Thanks for signing up. A welcome email has been sent to your inbox.');
        $this->assertDatabaseHas('outreach_subscribers', [
            'first_name' => 'Ama',
            'last_name' => 'Mensah',
            'email' => 'ama.mensah@example.com',
        ]);

        Mail::assertSent(OutreachUpdateMail::class, function (OutreachUpdateMail $mail): bool {
            return $mail->hasTo('ama.mensah@example.com')
                && $mail->emailSubject === 'Welcome to AkuaBa outreach updates'
                && str_contains($mail->body, 'Hello Ama');
        });
    }

    public function test_existing_subscriber_is_not_sent_another_welcome_email(): void
    {
        Mail::fake();

        $this->post(route('outreach.subscribe'), [
            'first_name' => 'Ama',
            'last_name' => 'Mensah',
            'email' => 'ama@example.com',
            'consent' => '1',
        ])->assertRedirect(route('outreach.signup'));

        $this->post(route('outreach.subscribe'), [
            'first_name' => 'Ama',
            'last_name' => 'Mensah',
            'email' => 'ama@example.com',
            'consent' => '1',
        ])->assertSessionHas('status', 'You are already signed up for AkuaBa outreach updates.');

        $this->assertDatabaseCount('outreach_subscribers', 1);
        Mail::assertSentTimes(OutreachUpdateMail::class, 1);
    }

    public function test_signup_requires_email_consent(): void
    {
        Mail::fake();

        $response = $this->from(route('outreach.signup'))->post(route('outreach.subscribe'), [
            'first_name' => 'Ama',
            'last_name' => 'Mensah',
            'email' => 'ama@example.com',
        ]);

        $response->assertRedirect(route('outreach.signup'));
        $response->assertSessionHasErrors('consent');
        $this->assertDatabaseCount('outreach_subscribers', 0);
        Mail::assertNothingOutgoing();
    }
}
