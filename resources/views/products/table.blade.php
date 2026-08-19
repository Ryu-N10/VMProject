<table class="table table-striped" id="sort-table">
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
                <td>{{ $product->company->company_name }}</td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">詳細</a>

                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $product->id }}">削除</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>