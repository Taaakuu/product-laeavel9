@extends('layouts.app')

@section('title','编辑商品')

@section('content')
    <div class="card mt-5">
        <div class="card-body">
            <h2>更新商品</h2>
            <hr>
            <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- 商品名称 -->
                <div class="mb-3">
                    <label for="name" class="form-label">名称</label>
                    <input type="text" class="form-control" name="name" id="name"
                           value="{{ $product->name }}" placeholder="请输入商品名称">
                </div>

                <!-- 商品描述 -->
                <div class="mb-3">
                    <label for="description" class="form-label">描述</label>
                    <textarea class="form-control" id="description" name="description"
                              rows="5">{{ $product->description }}</textarea>
                </div>

                <!-- 商品价格 -->
                <div class="mb-3">
                    <label for="price" class="form-label">价钱</label>
                    <input type="number" class="form-control" name="price" id="price" value="{{ $product->price }}"
                           placeholder="请输入商品单价">
                </div>

                <!-- 商品库存 -->
                <div class="mb-3">
                    <label for="stock" class="form-label">库存</label>
                    <input type="number" class="form-control" name="stock" id="stock"
                           value="{{ $product->stock->quantity ?? 0  }}"
                           placeholder="请输入商品库存">
                </div>

                <!-- 已有图片展示 -->
                @if(count($product->images) > 0)
                    @foreach($product->images as $image)
                        @if (str_contains($image->image_url, 'http'))
                            <!-- 外部链接图片 -->
                            <img src="{{ $image->image_url }}" alt="{{ $product->name }}" style="max-width: 400px; height: auto;">
                        @else
                            <!-- 本地存储图片 -->
                            <img src="{{ Storage::url($image->image_url) }}" alt="{{ $product->name }}" style="max-width: 400px; height: auto;">
                        @endif
                    @endforeach
                @endif
                <!-- 上传新图片 -->
                <div class="mb-3">
                    <label for="images" class="form-label">图片</label>
                    <input type="file" name="images[]" class="form-control" id="images" multiple>
                </div>

                <!-- 更新按钮 -->
                <button type="submit" class="btn btn-primary">更新商品</button>

                <!-- 错误信息 -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </form>
        </div>
    </div>
@endsection
