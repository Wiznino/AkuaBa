<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $slides = [
            ['title' => 'Inspire through science', 'path' => 'images/work-inspire.png', 'caption' => 'Explore. Discover. Imagine.'],
            ['title' => 'Experiment and create', 'path' => 'images/work-experiment.png', 'caption' => 'Learn by trying things out.'],
            ['title' => 'Design and build', 'path' => 'images/work-design.png', 'caption' => 'Turn ideas into working projects.'],
        ];
        $sortOrder = (int) (DB::table('media_items')->max('sort_order') ?? 0);

        foreach ($slides as $slide) {
            if (DB::table('media_items')->where('file_path', $slide['path'])->exists()) {
                continue;
            }

            $sortOrder = min($sortOrder + 10, 65535);

            DB::table('media_items')->insert([
                'created_by' => null,
                'title' => $slide['title'],
                'file_path' => $slide['path'],
                'mime_type' => 'image/png',
                'media_type' => 'image',
                'caption' => $slide['caption'],
                'is_published' => true,
                'sort_order' => $sortOrder,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $slides = [
            ['title' => 'Inspire through science', 'path' => 'images/work-inspire.png', 'caption' => 'Explore. Discover. Imagine.'],
            ['title' => 'Experiment and create', 'path' => 'images/work-experiment.png', 'caption' => 'Learn by trying things out.'],
            ['title' => 'Design and build', 'path' => 'images/work-design.png', 'caption' => 'Turn ideas into working projects.'],
        ];

        foreach ($slides as $slide) {
            DB::table('media_items')
                ->whereNull('created_by')
                ->where('title', $slide['title'])
                ->where('file_path', $slide['path'])
                ->where('mime_type', 'image/png')
                ->where('media_type', 'image')
                ->where('caption', $slide['caption'])
                ->where('is_published', true)
                ->delete();
        }
    }
};
