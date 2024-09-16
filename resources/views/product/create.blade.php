@extends('layout')

@section('title', '创建商品')

@section('content')
    <div class="card mt-5">
        <div class="card-body">
            <h1><span class="badge bg-secondary">创建商品</span></h1>
            <hr>
            <form action="{{ route('product.create') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label"><span class="badge text-bg-primary">名称</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入商品名称">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label"><span class="badge text-bg-primary">分类</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入商品名称">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label"><span class="badge text-bg-primary">品牌</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入商品名称">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label"><span class="badge text-bg-info">描述</span></label>
                    <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label"><span class="badge text-bg-warning">价钱</span></label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="请输入商品单价">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label"><span class="badge text-bg-success">库存</span></label>
                    <input type="number" class="form-control" name="stock" id="stock" placeholder="请输入商品库存">
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Images</label>
                    <input type="file" name="images[]" class="form-control" id="images" multiple>
                </div>
                <button type="submit" class="btn btn-primary">添加商品</button>
            </form>
        </div>
    </div>
@endsection
