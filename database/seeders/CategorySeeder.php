<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Parent Categories
        $tshirts = Category::create([
            'name' => 'T-Shirts',
            'slug' => 't-shirts',
            'description' => 'Comfortable cotton tees with witty Bengali humor and street-smart designs',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $hoodies = Category::create([
            'name' => 'Hoodies',
            'slug' => 'hoodies',
            'description' => 'Premium hoodies for Dhaka winter and AC rooms',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $jackets = Category::create([
            'name' => 'Jackets',
            'slug' => 'jackets',
            'description' => 'Light jackets for those 3 days of Dhaka winter',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $socks = Category::create([
            'name' => 'Socks',
            'slug' => 'socks',
            'description' => 'Because your feet deserve humor too',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $accessories = Category::create([
            'name' => 'Accessories',
            'slug' => 'accessories',
            'description' => 'Caps, bags, and other essentials for the streets',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        // Child Categories (under T-Shirts)
        Category::create([
            'name' => 'Oversized Tees',
            'slug' => 'oversized-tees',
            'description' => 'Extra roomy, extra comfy oversized t-shirts',
            'parent_id' => $tshirts->id,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Graphic Tees',
            'slug' => 'graphic-tees',
            'description' => 'Bold graphics with bolder statements',
            'parent_id' => $tshirts->id,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Basic Tees',
            'slug' => 'basic-tees',
            'description' => 'Simple, solid colors - timeless classics',
            'parent_id' => $tshirts->id,
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
