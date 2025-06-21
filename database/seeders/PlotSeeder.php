<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $locations = [
            'Riverside Gardens', 'Sunset Hills', 'Green Valley Estate', 'Palm Springs',
            'Ocean View Heights', 'Mountain Ridge', 'Crystal Lake', 'Cedar Park',
            'Golden Meadows', 'Silver Oaks', 'Maple Grove', 'Pine Valley',
            'Rose Garden Estate', 'Oak Hill', 'Willow Creek', 'Cherry Blossom'
        ];

        $statuses = ['available', 'sold', 'reserved'];
        
        $plotTypes = [
            ['min_area' => 300, 'max_area' => 500, 'min_price' => 50000, 'max_price' => 120000],
            ['min_area' => 500, 'max_area' => 800, 'min_price' => 120000, 'max_price' => 200000],
            ['min_area' => 800, 'max_area' => 1200, 'min_price' => 200000, 'max_price' => 350000],
            ['min_area' => 1200, 'max_area' => 2000, 'min_price' => 350000, 'max_price' => 600000],
        ];

        for ($i = 1; $i <= 50; $i++) {
            $plotType = $faker->randomElement($plotTypes);
            $area = $faker->numberBetween($plotType['min_area'], $plotType['max_area']);
            $basePrice = $faker->numberBetween($plotType['min_price'], $plotType['max_price']);
            
            // Add some variation to pricing
            $priceVariation = $faker->numberBetween(-10, 15); // -10% to +15%
            $finalPrice = $basePrice + ($basePrice * $priceVariation / 100);
            
            $status = $faker->randomElement($statuses);
            $location = $faker->randomElement($locations);
            
            // Generate plot number/title
            $plotNumber = str_pad($i, 3, '0', STR_PAD_LEFT);
            $title = "Plot {$plotNumber} - {$location}";
            
            // Generate description based on plot characteristics
            $descriptions = [
                "Prime residential plot with excellent road access and utilities connection.",
                "Spacious plot perfect for building your dream home with garden space.",
                "Well-located plot in a developing neighborhood with good infrastructure.",
                "Corner plot with dual road access and great investment potential.",
                "Peaceful plot surrounded by nature, ideal for family residence.",
                "Modern residential plot with all amenities nearby including schools and shopping.",
                "Elevated plot with scenic views and excellent drainage system.",
                "Rectangular plot with proper boundary marking and clear title.",
                "Premium plot in gated community with 24/7 security and maintenance.",
                "Investment opportunity in rapidly developing area with high appreciation potential."
            ];
            
            DB::table('plots')->insert([
                'title' => $title,
                'description' => $faker->randomElement($descriptions) . " Area: {$area} sqm. " . $faker->sentence(10),
                'price' => round($finalPrice, 2),
                'area_sqm' => $area,
                'location' => $location,
                'status' => $status,
                'is_new_listing' => $faker->boolean(30), // 30% chance of being new listing
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
        
        // Add some premium plots
        for ($i = 51; $i <= 60; $i++) {
            $area = $faker->numberBetween(2000, 5000);
            $pricePerSqm = $faker->numberBetween(400, 800);
            $totalPrice = $area * $pricePerSqm;
            
            $plotNumber = str_pad($i, 3, '0', STR_PAD_LEFT);
            $premiumLocations = ['Luxury Heights', 'Executive Gardens', 'VIP Estate', 'Premium Ridge'];
            $location = $faker->randomElement($premiumLocations);
            
            DB::table('plots')->insert([
                'title' => "Premium Plot {$plotNumber} - {$location}",
                'description' => "Exclusive premium plot in luxury development. Features include landscaped surroundings, underground utilities, wide roads, and exclusive club access. Perfect for luxury home construction with ample space for gardens and recreational facilities.",
                'price' => $totalPrice,
                'area_sqm' => $area,
                'location' => $location,
                'status' => $faker->randomElement(['available', 'reserved']),
                'is_new_listing' => $faker->boolean(50),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 week', 'now'),
            ]);
        }
    }
}