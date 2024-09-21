@extends('layouts.app')

@section('title', '商品列表')

@section('content')
    <div class="card mt-5">
        <div class="card-body">
            <!-- 筛选表单 -->
            <form action="{{ route('product.filter') }}" method="GET" class="mb-3">
                <div class="row">
                    <!-- 商品分类筛选 -->
                    <div class="col-md-3">
                        <label for="category" class="form-label">分类</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">全部分类</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 品牌筛选 -->
                    <div class="col-md-3">
                        <label for="brand" class="form-label">品牌</label>
                        <select name="brand" id="brand" class="form-select">
                            <option value="">全部品牌</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 价格区间筛选 -->
                    <div class="col-md-3">
                        <label for="min_price" class="form-label">最低价格</label>
                        <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3">
                        <label for="max_price" class="form-label">最高价格</label>
                        <input type="number" name="max_price" id="max_price" class="form-control" placeholder="不限" min="0">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">商品名称</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="输入商品名称">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary mt-4">筛选</button>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary mt-4">重置筛选</a>
                    </div>
                </div>
            </form>




            <!-- 商品块显示 -->
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if(count($product->images) > 0)
                                @foreach($product->images as $image)
                                    @if (str_contains($image->image_url, 'http'))
                                        <!-- 外部链接图片 -->
                                        <img src="{{ $image->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="max-width: 200px; height: auto;">
                                    @else
                                        <!-- 本地存储图片 -->
                                        <img src="{{ Storage::url($image->image_url) }}" class="card-img-top" alt="{{ $product->name }}" style="max-width: 200px; height: auto;">
                                    @endif
                                @endforeach
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">分类: {{ $product->category_id }}</p>
                                <p class="card-text">品牌: {{ $product->brand_id }}</p>
                                <p class="card-text">价格: {{ $product->price }} 元</p>
                                <p class="card-text">库存: {{ $product->stock->quantity ?? 0 }}</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm">详情</a>
                                <a href="{{ route('product.edit', $product->id) }}"
                                   class="btn btn-primary btn-sm">编辑</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">删除</button>
                                </form>
                                <script>
                                    function confirmDelete() {
                                        return confirm('您确定要删除这个商品吗？');
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 分页 -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($products->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($products->links()->elements as $element)
                        <!-- Make three dots (...) -->
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        <!-- Array Of Links -->
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $products->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($products->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>

        </div>
    </div>
@endsection





