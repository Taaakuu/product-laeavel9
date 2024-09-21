<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    //商品列表页面
    Route::get('index', [ProductController::class, 'index'])->name('product.index');
    // 显示创建商品的表单
    Route::get('create', [ProductController::class, 'create'])->name('product.create');
    // 处理商品创建请求
    Route::post('create', [ProductController::class, 'store'])->name('product.store');
    // 商品详情页面
    Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
    // 编辑商品
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    // 处理编辑商品更新的请求
    Route::put('edit/{id}', [ProductController::class, 'update'])->name('product.update');
    // 删除商品
    Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');


    // 搜索商品
    Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
    // 筛选商品
    Route::get('/product/filters', [ProductController::class, 'filter'])->name('product.filter');
