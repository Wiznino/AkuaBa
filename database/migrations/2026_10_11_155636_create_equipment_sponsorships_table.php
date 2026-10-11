<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment_sponsorships', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name', 150);
            $table->string('email', 254);
            $table->string('phone', 40);
            $table->string('equipment', 180);
            $table->text('message')->nullable();
            $table->timestamp('consented_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_sponsorships');
    }
};
