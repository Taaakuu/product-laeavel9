<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;      // 导入 Product 模型
use App\Models\ProductImage; // 导入 ProductImage 模型
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductImagesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 假设已经有一些商品生成，给每个商品添加图片
        $products = Product::all();

        foreach ($products as $product) {
            // 生成一张随机图片
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $faker->imageUrl(640, 480, 'business'), // 使用 Faker 生成随机图片
            ]);
        }
    }
}
