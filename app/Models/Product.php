<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 允许批量赋值的字段
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'brand_id',
    ];

    /**
     * 定义商品与分类的关系
     * 一个商品属于一个分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 定义商品与品牌的关系
     * 一个商品属于一个品牌
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * 定义商品与库存的关系
     * 一个商品有一个库存
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * 定义商品与图片的关系
     * 一个商品有多张图片
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
