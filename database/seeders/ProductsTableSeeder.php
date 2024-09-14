<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 10, 1000),
                'category_id' => $faker->numberBetween(1, 10),
                'brand_id' => $faker->numberBetween(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
