<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 允许批量赋值的字段
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * 定义分类与商品的关系
     * 一个分类下有多个商品
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * 定义分类的父子关系
     * 一个分类可以有一个父分类
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * 定义分类的子分类
     * 一个分类可以有多个子分类
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
