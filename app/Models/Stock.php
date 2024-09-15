<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'warehouse_location'];

    // 关联到商品模型
    public function product()
    {
        return $this->belongsTo(Product::class,'quantity');
    }
}

