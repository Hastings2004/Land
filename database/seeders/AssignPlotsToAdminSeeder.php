<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plot;
use App\Models\User;

class AssignPlotsToAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            echo "No admin user found. Please create an admin user first.\n";
            return;
        }
        
        // Get all plots that don't have a user_id assigned
        $plots = Plot::whereNull('user_id')->get();
        
        echo "Found " . $plots->count() . " plots without user_id\n";
        
        // Assign all plots to the admin user
        foreach ($plots as $plot) {
            $plot->update(['user_id' => $admin->id]);
        }
        
        echo "Successfully assigned " . $plots->count() . " plots to admin user: " . $admin->email . "\n";
    }
}
