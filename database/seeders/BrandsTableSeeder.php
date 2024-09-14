<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('brands')->insert([
                'name' => $faker->word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
