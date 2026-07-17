@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="mb-3">
        <a href="{{ url('/products/create') }}" class="btn btn-success">新規登録</a>
    </div>

    <form class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="検索キーワード">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-secondary w-100">検索</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}円</td>
                    <td>{{ $product->stock }}個</td>
                    <td>{{ $product->company_name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">詳細</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection