<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    // 允许批量赋值的字段
    protected $fillable = [
        'product_id',
        'quantity',
        'warehouse_location',
    ];

    /**
     * 定义库存与商品的关系
     * 一个库存记录属于一个商品
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
