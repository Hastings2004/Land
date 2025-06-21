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
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('price', 12, 2);
            $table->decimal('area_sqm', 10, 2);
            $table->string('location');
            $table->enum('status', ['available', 'sold', 'reserved'])->default('available');
            $table->boolean('is_new_listing')->default(true);
            $table->string('image_path')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
