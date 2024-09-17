@extends('layout')

@section('title', '商品详情')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>商品详情</h2>
            <hr>
        </div>
        <div class="card-body">
            <h5 class="card-title">商品名称：{{ $product->name }}</h5>
            <p class="card-text">描述：{{ $product->description }}</p>
            @if(count($product->images) > 0)
                @foreach($product->images as $image)
                    <img src="{{ $image->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                @endforeach
            @endif
            <p class="card-text">单价：{{ $product->price }}</p>
            <p class="card-text">库存：{{ $product->stock->quantity ?? 0 }}</p>
            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">编辑</a>
        </div>
    </div>
@endsection

