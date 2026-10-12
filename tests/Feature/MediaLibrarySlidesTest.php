<?php

namespace Tests\Feature;

use App\Models\MediaItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MediaLibrarySlidesTest extends TestCase
{
    use RefreshDatabase;

    public function test_work_illustrations_appear_once_in_the_homepage_slideshow(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();

        foreach ([
            'images/work-inspire.png',
            'images/work-experiment.png',
            'images/work-design.png',
        ] as $path) {
            $this->assertDatabaseHas('media_items', [
                'file_path' => $path,
                'media_type' => 'image',
                'is_published' => true,
            ]);
            $this->assertSame(1, substr_count((string) $response->getContent(), 'src="'.asset($path).'"'));
        }
    }

    public function test_hands_on_stem_image_and_caption_appear_in_the_slideshow_and_admin_library(): void
    {
        $filePath = 'images/akuaba-hands-on-stem.png';
        $caption = 'Students explore a hands-on STEM activity together.';

        $homeResponse = $this->get(route('home'));

        $homeResponse->assertOk()
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee($caption);
        $this->assertDatabaseHas('media_items', [
            'title' => 'Hands-on STEM learning',
            'file_path' => $filePath,
            'media_type' => 'image',
            'caption' => $caption,
            'is_published' => true,
        ]);
        $this->assertFileExists(public_path($filePath));

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $mediaItem = MediaItem::where('file_path', $filePath)->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Hands-on STEM learning')
            ->assertSee($caption)
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee('action="'.route('admin.media.update', $mediaItem).'"', false);
    }

    public function test_student_outreach_image_and_caption_appear_in_the_slideshow_and_admin_library(): void
    {
        $filePath = 'images/akuaba-student-outreach.png';
        $caption = 'A student shares her ideas during an interactive STEM outreach session.';

        $homeResponse = $this->get(route('home'));

        $homeResponse->assertOk()
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee($caption);
        $this->assertDatabaseHas('media_items', [
            'title' => 'Student voices at STEM outreach',
            'file_path' => $filePath,
            'media_type' => 'image',
            'caption' => $caption,
            'is_published' => true,
        ]);
        $this->assertFileExists(public_path($filePath));

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $mediaItem = MediaItem::where('file_path', $filePath)->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Student voices at STEM outreach')
            ->assertSee($caption)
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee('action="'.route('admin.media.update', $mediaItem).'"', false);
    }

    public function test_facilitator_outreach_image_and_caption_appear_in_the_slideshow_and_admin_library(): void
    {
        $filePath = 'images/akuaba-facilitator-outreach.png';
        $caption = 'An AkuaBa facilitator leads an engaging outreach session with students.';

        $homeResponse = $this->get(route('home'));

        $homeResponse->assertOk()
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee($caption);
        $this->assertDatabaseHas('media_items', [
            'title' => 'Facilitator leading school outreach',
            'file_path' => $filePath,
            'media_type' => 'image',
            'caption' => $caption,
            'is_published' => true,
        ]);
        $this->assertFileExists(public_path($filePath));

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $mediaItem = MediaItem::where('file_path', $filePath)->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Facilitator leading school outreach')
            ->assertSee($caption)
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee('action="'.route('admin.media.update', $mediaItem).'"', false);
    }

    public function test_stem_experiment_image_and_caption_appear_in_the_slideshow_and_admin_library(): void
    {
        $filePath = 'images/akuaba-stem-experiment.png';
        $caption = 'Students take part in a practical STEM experiment during AkuaBa outreach.';

        $homeResponse = $this->get(route('home'));

        $homeResponse->assertOk()
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee($caption);
        $this->assertDatabaseHas('media_items', [
            'title' => 'Students explore a STEM experiment',
            'file_path' => $filePath,
            'media_type' => 'image',
            'caption' => $caption,
            'is_published' => true,
        ]);
        $this->assertFileExists(public_path($filePath));

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $mediaItem = MediaItem::where('file_path', $filePath)->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Students explore a STEM experiment')
            ->assertSee($caption)
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee('action="'.route('admin.media.update', $mediaItem).'"', false);
    }

    public function test_student_teamwork_image_and_caption_appear_in_the_slideshow_and_admin_library(): void
    {
        $filePath = 'images/akuaba-student-teamwork-stem.png';
        $caption = 'Students work together on a hands-on STEM activity.';

        $homeResponse = $this->get(route('home'));

        $homeResponse->assertOk()
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee($caption);
        $this->assertDatabaseHas('media_items', [
            'title' => 'Students collaborating on STEM',
            'file_path' => $filePath,
            'media_type' => 'image',
            'caption' => $caption,
            'is_published' => true,
        ]);
        $this->assertFileExists(public_path($filePath));

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $mediaItem = MediaItem::where('file_path', $filePath)->firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Students collaborating on STEM')
            ->assertSee($caption)
            ->assertSee('src="'.asset($filePath).'"', false)
            ->assertSee('action="'.route('admin.media.update', $mediaItem).'"', false);
    }

    public function test_admin_can_see_and_manage_the_work_illustrations_in_the_media_library(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();

        foreach ([
            ['title' => 'Inspire through science', 'path' => 'images/work-inspire.png'],
            ['title' => 'Experiment and create', 'path' => 'images/work-experiment.png'],
            ['title' => 'Design and build', 'path' => 'images/work-design.png'],
        ] as $slide) {
            $mediaItem = MediaItem::where('file_path', $slide['path'])->firstOrFail();

            $response->assertSee($slide['title'])
                ->assertSee('src="'.asset($slide['path']).'"', false)
                ->assertSee('action="'.route('admin.media.update', $mediaItem).'"', false);
        }
    }

    public function test_admin_can_upload_an_image_larger_than_the_php_default_limit(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $response = $this->actingAs($admin)->post(route('admin.media.store'), [
            'title' => 'New outreach photo',
            'file' => UploadedFile::fake()->create('outreach.jpg', 3072, 'image/jpeg'),
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('status', 'Your upload has been added.');

        $mediaItem = MediaItem::where('title', 'New outreach photo')->firstOrFail();
        $this->assertSame('image', $mediaItem->media_type);
        $this->assertFileExists(public_path($mediaItem->file_path));

        File::delete(public_path($mediaItem->file_path));
    }

    public function test_admin_upload_rejects_files_over_32_megabytes(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $response = $this->actingAs($admin)->post(route('admin.media.store'), [
            'title' => 'Oversized outreach photo',
            'file' => UploadedFile::fake()->create('outreach.jpg', 32769, 'image/jpeg'),
            'is_published' => '1',
        ]);

        $response->assertSessionHasErrors('file');
        $this->assertDatabaseMissing('media_items', ['title' => 'Oversized outreach photo']);
    }

    public function test_admin_upload_rejects_a_file_and_youtube_url_together(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $response = $this->actingAs($admin)->post(route('admin.media.store'), [
            'title' => 'Conflicting media upload',
            'file' => UploadedFile::fake()->create('outreach.jpg', 10, 'image/jpeg'),
            'youtube_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
            'is_published' => '1',
        ]);

        $response->assertSessionHasErrors(['file', 'youtube_url']);
        $this->assertDatabaseMissing('media_items', ['title' => 'Conflicting media upload']);
    }
}
