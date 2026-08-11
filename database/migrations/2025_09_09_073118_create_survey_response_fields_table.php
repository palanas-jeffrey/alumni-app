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
        Schema::create('survey_response_fields', function (Blueprint $table) {
            $table->id();
            $table->text('value')->nullable();
            $table->foreignId('response_id')->constrained('survey_responses')->onDelete('cascade'); 
            $table->foreignId('field_id')->constrained('survey_section_fields')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('survey_sections')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_response_fields');
    }
};
