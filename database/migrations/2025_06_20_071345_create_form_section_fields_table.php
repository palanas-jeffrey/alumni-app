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
        Schema::create('form_section_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_label');
            $table->text('type')
                ->check("type IN ('input-text', 'number', 'radio', 'checkbox', 'select', 'textarea')");
            $table->string('choices')->nullable();
            $table->boolean('required')->default(false);
            $table->unsignedInteger('order')->nullable();
            $table->foreignId('section_id')->constrained('form_sections');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_section_fields');
    }
};
