<?php

namespace App\Http\Controllers;

use App\Models\MediaItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMediaController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'items' => MediaItem::orderBy('sort_order')->orderByDesc('created_at')->get(),
            'publishedCount' => MediaItem::published()->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'caption' => ['nullable', 'string', 'max:500'],
            'file' => ['nullable', 'required_without:youtube_url', 'prohibited_with:youtube_url', 'file', 'max:1048576', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm,mov,mp3,wav,ogg,pdf,doc,docx,ppt,pptx,xls,xlsx,zip'],
            'youtube_url' => ['nullable', 'required_without:file', 'prohibited_with:file', 'string', 'max:2048', function (string $attribute, mixed $value, \Closure $fail): void {
                if ($value !== null && $this->youtubeVideoId($value) === null) {
                    $fail('Enter a valid YouTube video URL.');
                }
            }],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $youtubeVideoId = $this->youtubeVideoId($data['youtube_url'] ?? null);
        $filePath = null;
        $mimeType = null;
        $mediaType = 'video';

        if ($youtubeVideoId === null) {
            $file = $data['file'];
            $mimeType = $file->getMimeType() ?: 'application/octet-stream';
            $mediaType = match (true) {
                Str::startsWith($mimeType, 'image/') => 'image',
                Str::startsWith($mimeType, 'video/') => 'video',
                default => 'document',
            };

            File::ensureDirectoryExists(public_path('uploads'));
            $filename = Str::uuid().'.'.$file->guessExtension();
            $file->move(public_path('uploads'), $filename);
            $filePath = 'uploads/'.$filename;
        }

        MediaItem::create([
            'created_by' => $request->user()->id,
            'title' => $data['title'],
            'caption' => $data['caption'] ?? null,
            'file_path' => $filePath,
            'youtube_video_id' => $youtubeVideoId,
            'mime_type' => $mimeType,
            'media_type' => $mediaType,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'Your upload has been added.');
    }

    public function update(Request $request, MediaItem $mediaItem): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'caption' => ['nullable', 'string', 'max:500'],
            'youtube_url' => ['nullable', 'string', 'max:2048', function (string $attribute, mixed $value, \Closure $fail) use ($mediaItem): void {
                if ($value !== null && ($mediaItem->media_type !== 'video' || $this->youtubeVideoId($value) === null)) {
                    $fail('Enter a valid YouTube video URL for a video item.');
                }
            }],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $youtubeVideoId = $this->youtubeVideoId($data['youtube_url'] ?? null);
        $previousFilePath = $mediaItem->file_path;

        $mediaItem->update([
            'title' => $data['title'],
            'caption' => $data['caption'] ?? null,
            'sort_order' => $data['sort_order'],
            'is_published' => $request->boolean('is_published'),
            ...($youtubeVideoId === null ? [] : [
                'file_path' => null,
                'youtube_video_id' => $youtubeVideoId,
                'mime_type' => null,
            ]),
        ]);

        if ($youtubeVideoId !== null && $previousFilePath !== null && Str::startsWith($previousFilePath, 'uploads/')) {
            File::delete(public_path($previousFilePath));
        }

        return redirect()->route('admin.dashboard')->with('status', 'Media details have been updated.');
    }

    public function destroy(MediaItem $mediaItem): RedirectResponse
    {
        if ($mediaItem->file_path !== null && Str::startsWith($mediaItem->file_path, 'uploads/')) {
            File::delete(public_path($mediaItem->file_path));
        }

        $mediaItem->delete();

        return redirect()->route('admin.dashboard')->with('status', 'The upload has been removed.');
    }

    private function youtubeVideoId(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        $parts = parse_url($url);
        if (! is_array($parts) || ! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)) {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $videoId = explode('/', $path)[0] ?? null;
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
            parse_str($parts['query'] ?? '', $query);
            $videoId = ($path === 'watch')
                ? ($query['v'] ?? null)
                : (preg_match('#^(?:embed|shorts)/([A-Za-z0-9_-]+)$#', $path, $matches) ? $matches[1] : null);
        }

        return is_string($videoId) && preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)
            ? $videoId
            : null;
    }
}
