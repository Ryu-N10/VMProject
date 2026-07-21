@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品新規登録画面</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <div class="mb-3">
            <label for="product_name" class="form-label">商品名 <span class="text-danger">*必須</span></label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー名 <span class="text-danger">*必須</span></label>
            <select class="form-select" id="company_id" name="company_id" required>
                <option value="">メーカーを選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格 <span class="text-danger">*必須</span></label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数 <span class="text-danger">*必須</span></label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">詳細・コメント</label>
            <textarea class="form-control" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
        </div>

        <!-- 画像選択フォームを追加 -->
        <div class="mb-3">
            <label for="image" class="form-label">商品画像</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection