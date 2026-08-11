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
        Schema::create('account_activations', function (Blueprint $table) {
            $table->id('activation_id'); // Activation ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('token', 100)->unique(); // Unique activation token
            $table->timestamp('created_at')->useCurrent(); // Token creation time
            $table->timestamp('expired_at')->nullable(); // Token expiration time
            $table->boolean('is_activated')->default(false); // Activation status
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_activations');
    }
};
