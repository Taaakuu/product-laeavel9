<!-- index.blade.php -->
@extends('layouts.app')

@section('content')
    <form action="{{ route('products.index') }}" method="GET">
        <select name="category_id">
            <option value="">所有分类</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="brand_id">
            <option value="">所有品牌</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>

        <input type="text" name="name" placeholder="商品名称" value="{{ request('name') }}">
        <input type="number" name="min_price" placeholder="最低价格" value="{{ request('min_price') }}">
        <input type="number" name="max_price" placeholder="最高价格" value="{{ request('max_price') }}">

        <button type="submit">筛选</button>
    </form>

    @foreach ($products as $product)
        <div>{{ $product->name }}</div>
        <div>{{ $product->price }}</div>
        <div>{{ $product->category->name ?? '未分类' }}</div>
        <div>{{ $product->brand->name ?? '无品牌' }}</div>
        <div>{{ $product->stock->quantity }}</div>
        <a href="{{ route('products.edit', $product->id) }}">编辑</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">删除</button>
        </form>
    @endforeach

    {{ $products->links() }}
@endsection

