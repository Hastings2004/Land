<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Attempt to fix plot_images with null plot_id
        $images = DB::table('plot_images')->whereNull('plot_id')->get();
        foreach ($images as $image) {
            // Try to match by image_path to a plot's image_path (if used as primary)
            $plot = DB::table('plots')->where('image_path', $image->image_path)->first();
            if ($plot) {
                DB::table('plot_images')->where('id', $image->id)->update(['plot_id' => $plot->id]);
            } else {
                // If no match, leave as null for manual review
                // Optionally, set to a default plot_id (e.g., 1) if you want
                // DB::table('plot_images')->where('id', $image->id)->update(['plot_id' => 1]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed
    }
}; 