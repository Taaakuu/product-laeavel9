<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    // 允许批量赋值的字段
    protected $fillable = [
        'product_id',
        'image_url',
    ];

    /**
     * 定义商品图片与商品的关系
     * 一个商品图片属于一个商品
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
