@extends('layout')

@section('title', '搜索结果')

@section('content')
    <div class="card mt-5">
        <div class="card-body">
            <h2>搜索结果</h2>
            <p>关键词: {{ $query }}</p>
            <hr>
            @if($products->isEmpty())
                <p>没有找到相关的商品。</p>
            @else
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">商品名称</th>
                        <th scope="col">分类</th>
                        <th scope="col">品牌</th>
                        <th scope="col">商品描述</th>
                        <th scope="col">单价</th>
                        <th scope="col">库存</th>
                        <th scope="col">创建时间</th>
                        <th scope="col">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category_id }}</td>
                            <td>{{ $product->brand_id }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock->quantity ?? 0}}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm">详情</a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">编辑</a>
                                <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger btn-sm">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

