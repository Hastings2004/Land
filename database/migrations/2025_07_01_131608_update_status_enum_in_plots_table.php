<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'pending' and 'rejected' to the status enum
        DB::statement("ALTER TABLE plots MODIFY COLUMN status ENUM('available', 'sold', 'reserved', 'pending', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE plots MODIFY COLUMN status ENUM('available', 'sold', 'reserved') DEFAULT 'available'");
    }
};
