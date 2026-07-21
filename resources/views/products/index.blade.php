@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="mb-3">
        <a href="{{ url('/products/create') }}" class="btn btn-success">新規登録</a>
    </div>

    <!-- 検索フォーム -->
    <form action="{{ route('products.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <!-- name="search" を追加して、入力した文字を送れるようにする -->
            <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <!-- type="submit" に変えて、ボタンを押したら送信されるようにする -->
            <button type="submit" class="btn btn-outline-secondary w-100">検索</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
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

                    <!-- 🖼️ 画像表示欄を追加！ -->
                    <td>
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <span class="text-muted" style="font-size: 0.8rem;">画像なし</span>
                        @endif
                    </td>

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