<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 插入根分类
        foreach (range(1, 5) as $index) {
            DB::table('categories')->insert([
                'name' => $faker->word,
                'parent_id' => null, // 根分类没有 parent_id
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 获取插入的根分类ID
        $parentIds = DB::table('categories')->pluck('id');

        // 插入子分类
        foreach (range(1, 10) as $index) {
            DB::table('categories')->insert([
                'name' => $faker->word,
                'parent_id' => $faker->randomElement($parentIds), // 随机分配一个根分类的ID作为parent_id
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
