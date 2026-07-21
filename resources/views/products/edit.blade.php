@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報編集画面</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">商品情報ID</label>
            <input type="text" class="form-control" value="{{ $product->id }}" disabled>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">商品名</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー名</label>
            <select class="form-select" id="company_id" name="company_id" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">詳細・コメント</label>
            <textarea class="form-control" id="comment" name="comment" rows="3">{{ old('comment', $product->comment) }}</textarea>
        </div>

        <!-- 🖼️ 画像編集フォームを追加 -->
        <div class="mb-3">
            <label for="image" class="form-label">商品画像</label>
            
            <!-- もし既に画像が登録されていたら、現在の画像を表示する -->
            @if ($product->image_path)
                <div class="mb-2">
                    <p class="mb-1 text-muted" style="font-size: 0.9rem;">現在の画像:</p>
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" style="max-width: 150px; height: auto;">
                </div>
            @endif

            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection