<?php

namespace Tests\Feature;

use App\Mail\OutreachUpdateMail;
use App\Models\OutreachSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminOutreachBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_queues_a_separate_email_for_each_subscriber(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        OutreachSubscriber::create([
            'first_name' => 'Ama',
            'last_name' => 'Mensah',
            'email' => 'ama@example.com',
        ]);
        OutreachSubscriber::create([
            'first_name' => 'Kojo',
            'last_name' => 'Owusu',
            'email' => 'kojo@example.com',
        ]);

        Mail::fake();

        $response = $this->actingAs($admin)->post(route('admin.outreach.broadcast'), [
            'subject' => 'Upcoming STEM outreach',
            'body' => 'Join us for our next workshop.',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('status', 'Your update has been queued for 2 opted-in subscribers.');
        Mail::assertQueuedCount(2);
        Mail::assertQueued(OutreachUpdateMail::class, fn (OutreachUpdateMail $mail): bool => $mail->hasTo('ama@example.com')
            && $mail->emailSubject === 'Upcoming STEM outreach'
            && $mail->body === 'Join us for our next workshop.');
        Mail::assertQueued(OutreachUpdateMail::class, fn (OutreachUpdateMail $mail): bool => $mail->hasTo('kojo@example.com')
            && $mail->emailSubject === 'Upcoming STEM outreach'
            && $mail->body === 'Join us for our next workshop.');
    }

    public function test_guests_cannot_send_outreach_broadcasts(): void
    {
        Mail::fake();

        $response = $this->post(route('admin.outreach.broadcast'), [
            'subject' => 'Upcoming STEM outreach',
            'body' => 'Join us for our next workshop.',
        ]);

        $response->assertRedirect(route('admin.login'));
        Mail::assertNothingOutgoing();
    }

    public function test_non_admin_users_cannot_send_outreach_broadcasts(): void
    {
        Mail::fake();

        $response = $this->actingAs(User::factory()->create())->post(route('admin.outreach.broadcast'), [
            'subject' => 'Upcoming STEM outreach',
            'body' => 'Join us for our next workshop.',
        ]);

        $response->assertRedirect(route('admin.login'));
        Mail::assertNothingOutgoing();
    }

    public function test_broadcast_email_content_escapes_html(): void
    {
        $mail = new OutreachUpdateMail(
            'Update <script>alert(1)</script>',
            'Hello <script>alert(1)</script>',
        );

        $rendered = $mail->render();

        $this->assertStringContainsString('&lt;script&gt;', $rendered);
        $this->assertStringNotContainsString('<script>', $rendered);
    }
}
