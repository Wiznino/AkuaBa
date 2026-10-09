@extends('admin.layout')

@section('title', 'Manage media')

@section('content')
    <section class="dashboard-heading">
        <div><p class="admin-kicker">AKUABA STEM GIRLS · WEBSITE CONTENT</p><h1>Manage your media</h1><p>Published images appear in the homepage slideshow. Uploaded or YouTube linked videos appear in the video album. Documents appear in the community resources section.</p></div>
        <div class="published-stat"><strong>{{ $publishedCount }}</strong><span>published items</span></div>
    </section>

    <section class="admin-panel upload-panel" aria-labelledby="upload-heading">
        <div class="panel-heading"><div><p class="admin-kicker">ADD SOMETHING NEW</p><h2 id="upload-heading">Upload media</h2></div><span class="panel-number">01</span></div>
        <form action="{{ route('admin.media.store') }}" method="post" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="form-grid">
                <div class="field"><label for="title">Title</label><input id="title" name="title" value="{{ old('title') }}" maxlength="120" placeholder="e.g. Girls building a robot" required>@error('title')<span class="field-error">{{ $message }}</span>@enderror</div>
                <div class="field"><label for="file">Choose an image, video, or document</label><input id="file" name="file" type="file" accept=".jpg,.jpeg,.png,.webp,.gif,.mp4,.webm,.mov,.mp3,.wav,.ogg,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip">@error('file')<span class="field-error">{{ $message }}</span>@enderror</div>
                <div class="field"><label for="youtube_url">Or add a YouTube video URL</label><input id="youtube_url" name="youtube_url" type="url" value="{{ old('youtube_url') }}" maxlength="2048" placeholder="https://www.youtube.com/watch?v=..."><span class="field-hint">Use a video link. Videos play directly from YouTube on the site.</span>@error('youtube_url')<span class="field-error">{{ $message }}</span>@enderror</div>
                <div class="field field-wide"><label for="caption">Caption <span>optional</span></label><textarea id="caption" name="caption" rows="3" maxlength="500" placeholder="A short description shown with the slideshow item">{{ old('caption') }}</textarea>@error('caption')<span class="field-error">{{ $message }}</span>@enderror</div>
                <div class="field"><label for="sort_order">Display order</label><input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', 0) }}"><span class="field-hint">Lower numbers appear first.</span>@error('sort_order')<span class="field-error">{{ $message }}</span>@enderror</div>
                <label class="publish-toggle"><input type="checkbox" name="is_published" value="1" checked><span><strong>Publish after upload</strong><small>Show this item on the public website.</small></span></label>
            </div>
            <div class="upload-footer"><p>Choose a file or provide a YouTube video URL. Uploaded files can be up to 1 GB.</p><button class="primary-button" type="submit">Add to AkuaBa <span aria-hidden="true">&#8594;</span></button></div>
        </form>
    </section>

    <section class="media-section" aria-labelledby="media-heading">
        <div class="media-heading"><div><p class="admin-kicker">YOUR LIBRARY</p><h2 id="media-heading">Published & saved items</h2></div><span>{{ $items->count() }} total</span></div>
        @if ($items->isEmpty())
            <div class="empty-state"><span aria-hidden="true">&#10038;</span><h3>Your media library is ready.</h3><p>Upload images for the homepage slideshow or publish videos to the separate video album.</p></div>
        @else
            <div class="media-list">
                @foreach ($items as $item)
                    <article class="media-card">
                        <div class="media-preview">
                            @if ($item->media_type === 'image')<img src="{{ asset($item->file_path) }}" alt="Preview: {{ $item->title }}" loading="lazy">
                            @elseif ($item->media_type === 'video')
                                @if ($item->youtube_video_id)<iframe src="https://www.youtube-nocookie.com/embed/{{ $item->youtube_video_id }}" title="{{ $item->title }}" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                @else<video src="{{ asset($item->file_path) }}" controls preload="metadata"></video>@endif
                            @else<div class="document-preview"><span>{{ strtoupper(pathinfo($item->file_path, PATHINFO_EXTENSION)) }}</span><small>DOCUMENT</small></div>@endif
                        </div>
                        <div class="media-details"><div class="media-meta"><span class="type-pill type-{{ $item->media_type }}">{{ ucfirst($item->media_type) }}</span><span class="publish-state {{ $item->is_published ? 'is-live' : '' }}">{{ $item->is_published ? 'Published' : 'Hidden' }}</span></div>
                            <form method="post" action="{{ route('admin.media.update', $item) }}" class="item-edit-form">@csrf @method('PATCH')
                                <label class="visually-hidden" for="title-{{ $item->id }}">Title</label><input id="title-{{ $item->id }}" name="title" value="{{ $item->title }}" maxlength="120" required>
                                <label class="visually-hidden" for="caption-{{ $item->id }}">Caption</label><textarea id="caption-{{ $item->id }}" name="caption" rows="2" maxlength="500" placeholder="Add a caption">{{ $item->caption }}</textarea>
                                @if ($item->media_type === 'video')<label class="youtube-edit-field" for="youtube-url-{{ $item->id }}">YouTube video URL <span>optional; enter to play this item from YouTube</span><input id="youtube-url-{{ $item->id }}" type="url" name="youtube_url" value="{{ $item->youtube_video_id ? 'https://www.youtube.com/watch?v='.$item->youtube_video_id : '' }}" maxlength="2048" placeholder="https://www.youtube.com/watch?v=...">@error('youtube_url')<span class="field-error">{{ $message }}</span>@enderror</label>@endif
                                <div class="item-actions"><label class="compact-field">Order <input type="number" name="sort_order" min="0" max="65535" value="{{ $item->sort_order }}" required></label><label class="inline-check"><input type="checkbox" name="is_published" value="1" @checked($item->is_published)> Published</label><button type="submit" class="secondary-button">Save</button></div>
                            </form>
                            <form method="post" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Remove this upload from the website?')">@csrf @method('DELETE')<button class="delete-button" type="submit">Delete item</button></form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
