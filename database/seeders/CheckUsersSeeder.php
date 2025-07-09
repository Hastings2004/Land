<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CheckUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        echo "Total users: " . $users->count() . "\n";
        
        foreach ($users as $user) {
            echo "Email: " . $user->email . " | Role: " . $user->role . "\n";
        }
    }
}
