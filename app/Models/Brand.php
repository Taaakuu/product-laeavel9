<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // 允许批量赋值的字段
    protected $fillable = [
        'name',
    ];

    /**
     * 定义品牌与商品的关系
     * 一个品牌下有多个商品
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
