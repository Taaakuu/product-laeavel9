@extends('layout')

@section('title', '商品筛选')

@section('content')
    <div class="container">
        <h1>筛选结果</h1>

        <!-- 筛选条件 -->
        <form action="{{ route('product.filter') }}" method="GET">
            @if($type === 'category')
                <label for="category">选择分类</label>
                <select id="category" class="form-select" name="category">
                    <option value="">所有分类</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            @elseif($type === 'brand')
                <label for="brand">选择品牌</label>
                <select id="brand" class="form-select" name="brand">
                    <option value="">所有品牌</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            @elseif($type === 'price')
                <label for="min_price">最低价格</label>
                <input type="number" id="min_price" class="form-control" name="min_price">
                <label for="max_price">最高价格</label>
                <input type="number" id="max_price" class="form-control" name="max_price">
            @elseif($type === 'name')
                <label for="name">商品名称</label>
                <input type="text" id="name" class="form-control" name="name">
            @endif
            <button class="btn btn-primary mt-3" type="submit">筛选</button>
        </form>

        <!-- 显示筛选结果 -->
        @if(isset($product))
            <h2 class="mt-5">筛选结果</h2>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $products->name }}</h5>
                                <p class="card-text">{{ $products->description }}</p>
                                <p class="card-text"><strong>价格:</strong> ¥{{ $products->price }}</p>
                                <p class="card-text"><strong>分类:</strong> {{ $products->category->name }}</p>
                                <p class="card-text"><strong>品牌:</strong> {{ $products->brand->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- 分页 -->
            {{ $products->links() }}
        @endif
    </div>
@endsection
