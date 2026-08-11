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
        Schema::create('event_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_event_id')->constrained('ua_events')->onDelete('cascade'); // Explicitly reference the parent table
            $table->string('photo_path')->comment('Event photo URL');
            $table->string('image_type')->comment('Type of image (e.g. thumbnail, original)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_photos');
    }
};
