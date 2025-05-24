<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (optional, but good for repeatable seeding)
        DB::table('categories')->truncate();

        $categories = [
            'CPU',
            'Motherboard',
            'RAM',
            'GPU',
            'HDD - Storage',
            'SSD - Storage',
            'Power Supply',
            'PC Case',
        ];

        // Prepare data for insertion with timestamps
        $data = [];
        $now = Carbon::now(); // Get current timestamp once for efficiency

        foreach ($categories as $categoryName) {
            $data[] = [
                'id' => Str::uuid()->toString(), // Generate a UUID
                'name' => $categoryName,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert the data into the 'categories' table
        DB::table('categories')->insert($data);

        $this->command->info('Categories seeded successfully!');
    }
}