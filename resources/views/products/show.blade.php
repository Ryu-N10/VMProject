@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品詳細画面</h1>

    <div class="card mb-4">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">商品情報ID</dt>
                <dd class="col-sm-9">{{ $product->id }}</dd>

                <dt class="col-sm-3">商品画像</dt>
                <dd class="col-sm-9">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" style="max-width: 200px;">
                    @else
                        <span class="text-muted">画像なし</span>
                    @endif
                </dd>

                <dt class="col-sm-3">商品名</dt>
                <dd class="col-sm-9">{{ $product->product_name }}</dd>

                <dt class="col-sm-3">メーカー名</dt>
                <dd class="col-sm-9">{{ $product->company_name }}</dd>

                <dt class="col-sm-3">価格</dt>
                <dd class="col-sm-9">{{ $product->price }}円</dd>

                <dt class="col-sm-3">在庫数</dt>
                <dd class="col-sm-9">{{ $product->stock }}個</dd>

                <dt class="col-sm-3">詳細・コメント</dt>
                <dd class="col-sm-9">{{ $product->comment ?? 'コメントはありません。' }}</dd>
            </dl>
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    <a href="{{ url('/products/' . $product->id . '/edit') }}" class="btn btn-warning">編集</a>
</div>
@endsection