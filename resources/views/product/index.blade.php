@extends('layout')

@section('title', '商品列表')

@section('content')
    <div class="card mt-5">
        <div class="card-body">
            <h2>商品列表</h2>
            <hr>
            <!-- 搜索表单 -->
            <form action="{{ route('product.search') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="搜索商品" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">搜索</button>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">商品名称</th>
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
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
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
