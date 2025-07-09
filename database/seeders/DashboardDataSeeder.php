<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plot;

class DashboardDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample plots for the dashboard
        $plots = [
            [
                'title' => 'Luxury Residential Plot',
                'description' => 'Beautiful residential plot in a prime location with excellent infrastructure and amenities.',
                'price' => 45000.00,
                'area_sqm' => 250.00,
                'location' => 'Lilongwe, Area 47',
                'status' => 'available',
                'category' => 'residential',
                'is_new_listing' => true,
                'views' => 156,
                'created_at' => now()->subDays(2),
            ],
            [
                'title' => 'Commercial Development Land',
                'description' => 'Prime commercial land perfect for business development with high foot traffic.',
                'price' => 120000.00,
                'area_sqm' => 500.00,
                'location' => 'Blantyre, CBD',
                'status' => 'available',
                'category' => 'commercial',
                'is_new_listing' => true,
                'views' => 89,
                'created_at' => now()->subDays(1),
            ],
            [
                'title' => 'Agricultural Land',
                'description' => 'Fertile agricultural land suitable for farming and livestock.',
                'price' => 28000.00,
                'area_sqm' => 1000.00,
                'location' => 'Mzuzu, Rural',
                'status' => 'available',
                'category' => 'residential',
                'is_new_listing' => false,
                'views' => 234,
                'created_at' => now()->subDays(15),
            ],
            [
                'title' => 'Investment Property',
                'description' => 'High-yield investment property with excellent rental potential.',
                'price' => 75000.00,
                'area_sqm' => 300.00,
                'location' => 'Lilongwe, Area 10',
                'status' => 'available',
                'category' => 'residential',
                'is_new_listing' => false,
                'views' => 189,
                'created_at' => now()->subDays(30),
            ],
            [
                'title' => 'Industrial Zone Land',
                'description' => 'Industrial land with easy access to major highways and utilities.',
                'price' => 95000.00,
                'area_sqm' => 800.00,
                'location' => 'Blantyre, Industrial Area',
                'status' => 'available',
                'category' => 'industrial',
                'is_new_listing' => true,
                'views' => 67,
                'created_at' => now()->subDays(3),
            ],
            [
                'title' => 'Suburban Family Plot',
                'description' => 'Perfect family plot in a quiet suburban neighborhood.',
                'price' => 35000.00,
                'area_sqm' => 200.00,
                'location' => 'Lilongwe, Area 25',
                'status' => 'available',
                'category' => 'residential',
                'is_new_listing' => false,
                'views' => 145,
                'created_at' => now()->subDays(45),
            ],
        ];

        foreach ($plots as $plotData) {
            Plot::create($plotData);
        }

        $this->command->info('Dashboard sample data seeded successfully!');
    }
}
