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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'inquiry_received', 'inquiry_responded', etc.
            $table->string('title');
            $table->text('message');
            $table->unsignedBigInteger('user_id')->nullable(); // For user-specific notifications
            $table->string('email')->nullable(); // For customer notifications
            $table->unsignedBigInteger('inquiry_id')->nullable(); // Related inquiry
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable(); // Additional data
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['email', 'is_read']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
