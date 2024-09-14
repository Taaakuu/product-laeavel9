<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('商品名称')->nullable(false);
            $table->text('description')->comment('商品描述')->nullable(false);
            $table->decimal('price',10,2)->comment('商品价格')->nullable(false);
            $table->foreignId('category_id' )->comment('分类ID')->nullable()->onDelete('set null');;
            $table->foreignId('brand_id')->comment('品牌ID')->nullable()->onDelete('set null'); ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
