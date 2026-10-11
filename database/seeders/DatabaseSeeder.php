<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create your 3 User Roles
        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'Staff'],
            ['name' => 'Customer'],
        ]);

        // 2. Create some Equipment Categories
        DB::table('categories')->insert([
            ['name' => 'Cameras', 'description' => 'Photography and video equipment'],
            ['name' => 'Power Tools', 'description' => 'Construction and DIY tools'],
        ]);

        // 3. Create some Rental Items
        DB::table('items')->insert([
            ['category_id' => 1, 'name' => 'Canon DSLR Camera', 'stock' => 5, 'price_per_day' => 50.00],
            ['category_id' => 2, 'name' => 'Electric Cordless Drill', 'stock' => 10, 'price_per_day' => 15.00],
        ]);
    }
}