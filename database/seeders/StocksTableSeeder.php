<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StocksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('stocks')->insert([
                'product_id' => $faker->numberBetween(1, 50), // 确保 product_id 在有效范围内
                'quantity' => $faker->numberBetween(0, 100),
                'warehouse_location' => $faker->word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
