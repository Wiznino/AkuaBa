<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

#[Fillable(['created_by', 'title', 'file_path', 'youtube_video_id', 'mime_type', 'media_type', 'caption', 'is_published', 'sort_order'])]
class MediaItem extends Model
{
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
