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
        $plots = [
            [
                'title' => 'Oceanview Residential Plot',
                'price' => 350000.00,
                'area_sqm' => 1200.50, // size in sqm
                'location' => 'Malibu Coastal Area',
                'status' => 'available',
                'description' => 'Premium beachfront property with stunning ocean views, perfect for luxury villa construction. Includes all utilities connections.'
            ],
            [
                'title' => 'Downtown Commercial Plot',
                'price' => 1200000.00,
                'area_sqm' => 2500.75,
                'location' => 'Manhattan Business District',
                'status' => 'reserved',
                'description' => 'Prime commercial space in heart of financial district. Zoned for high-rise office buildings with excellent transport links.'
            ],
            [
                'title' => 'Suburban Family Plot',
                'price' => 185000.00,
                'area_sqm' => 800.00,
                'location' => 'Springfield Suburbs',
                'status' => 'available',
                'description' => 'Quiet neighborhood plot with good schools nearby. Ideal for family home with garden space. Water and electricity already connected.'
            ],
            [
                'title' => 'Mountain Retreat Land',
                'price' => 275000.00,
                'area_sqm' => 5000.25,
                'location' => 'Rocky Mountain Range',
                'status' => 'available',
                'description' => 'Secluded mountain property with breathtaking views. Perfect for vacation home or eco-retreat. Access via private road.'
            ],
            [
                'title' => 'Agricultural Farmland',
                'price' => 150000.00,
                'area_sqm' => 10000.00,
                'location' => 'Central Valley',
                'status' => 'sold',
                'description' => 'Fertile agricultural land with irrigation system. Suitable for crops or livestock. Includes small farmhouse.'
            ],
            [
                'title' => 'Lakefront Cottage Plot',
                'price' => 220000.00,
                'area_sqm' => 1500.50,
                'location' => 'Crystal Lake',
                'status' => 'available',
                'description' => 'Charming lakeside property with private dock. Includes fishing rights and mature trees. Perfect for weekend getaway.'
            ],
            [
                'title' => 'Urban Redevelopment Plot',
                'price' => 750000.00,
                'area_sqm' => 1800.00,
                'location' => 'Brooklyn Industrial Zone',
                'status' => 'available',
                'description' => 'Former industrial site ready for redevelopment. Approved for mixed residential/commercial use. Excellent investment opportunity.'
            ],
            [
                'title' => 'Gated Community Plot',
                'price' => 320000.00,
                'area_sqm' => 950.75,
                'location' => 'Palm Springs Estates',
                'status' => 'reserved',
                'description' => 'Premium plot in secure gated community. Includes access to shared amenities: pool, gym, and clubhouse.'
            ],
            [
                'title' => 'Hillside View Property',
                'price' => 195000.00,
                'area_sqm' => 2200.25,
                'location' => 'Hollywood Hills',
                'status' => 'available',
                'description' => 'Sloping plot with panoramic city views. Architectural plans available. Challenging build but rewarding location.'
            ],
            [
                'title' => 'Desert Oasis Plot',
                'price' => 125000.00,
                'area_sqm' => 3000.00,
                'location' => 'Mojave Desert',
                'status' => 'available',
                'description' => 'Unique off-grid property with natural spring. Ideal for sustainable living experiment or artist retreat.'
            ]
        ];

        foreach ($plots as $plot) {
            \App\Models\Plot::create($plot);
        }
    }
}