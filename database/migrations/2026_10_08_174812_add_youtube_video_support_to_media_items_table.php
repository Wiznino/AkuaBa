<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media_items', function (Blueprint $table): void {
            $table->string('youtube_video_id', 11)->nullable()->after('file_path');
            $table->string('file_path')->nullable()->change();
            $table->string('mime_type', 120)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('media_items')->whereNotNull('youtube_video_id')->exists()) {
            throw new \RuntimeException('YouTube media items must be removed before rolling back YouTube video support.');
        }

        Schema::table('media_items', function (Blueprint $table): void {
            $table->string('file_path')->nullable(false)->change();
            $table->string('mime_type', 120)->nullable(false)->change();
            $table->dropColumn('youtube_video_id');
        });
    }
};
