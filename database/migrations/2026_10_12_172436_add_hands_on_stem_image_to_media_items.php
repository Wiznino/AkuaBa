<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $filePath = 'images/akuaba-hands-on-stem.png';

        if (DB::table('media_items')->where('file_path', $filePath)->exists()) {
            return;
        }

        DB::table('media_items')->insert([
            'created_by' => null,
            'title' => 'Hands-on STEM learning',
            'file_path' => $filePath,
            'mime_type' => 'image/png',
            'media_type' => 'image',
            'caption' => 'Students explore a hands-on STEM activity together.',
            'is_published' => true,
            'sort_order' => min((int) (DB::table('media_items')->max('sort_order') ?? 0) + 10, 65535),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('media_items')
            ->whereNull('created_by')
            ->where('title', 'Hands-on STEM learning')
            ->where('file_path', 'images/akuaba-hands-on-stem.png')
            ->where('mime_type', 'image/png')
            ->where('media_type', 'image')
            ->where('caption', 'Students explore a hands-on STEM activity together.')
            ->where('is_published', true)
            ->delete();
    }
};
