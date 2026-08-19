@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="mb-3">
        <a href="{{ url('/products/create') }}" class="btn btn-success">新規登録</a>
    </div>

    <!-- 検索フォーム -->
    <form action="{{ route('products.index') }}" method="GET" id="search-form" class="row g-3 mb-4">
        <!-- キーワード検索 -->
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
        </div>

        <!-- 価格（下限〜上限） -->
        <div class="col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="価格（下限）" value="{{ request('min_price') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="価格（上限）" value="{{ request('max_price') }}">
        </div>

        <!-- 在庫数（下限〜上限） -->
        <div class="col-md-2">
            <input type="number" name="min_stock" class="form-control" placeholder="在庫数（下限）" value="{{ request('min_stock') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_stock" class="form-control" placeholder="在庫数（上限）" value="{{ request('max_stock') }}">
        </div>

        <!-- 検索ボタン -->
        <div class="col-md-1">
            <button type="submit" class="btn btn-outline-secondary w-100">検索</button>
        </div>
    </form>

    <!-- 一覧表示部分（Ajaxでここだけ差し替えます） -->
    <div id="product-table">
        @include('products.table')
    </div>
</div>

<!-- tablesorterの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>

<script>
$(document).ready(function() {

    // 🎯 表をソートできるようにする関数
    function initTablesorter() {
        $('#sort-table').tablesorter({
            sortList: [[0, 1]] 
        });
    }

    // 1. 最初（画面を開いたとき）にソート機能を準備する
    initTablesorter();

    // 2. 検索ボタンが押されたときの非同期処理（Ajax）
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // リロードをキャンセル

        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('products.index') }}",
            type: "GET",
            data: formData,
            dataType: "html",
            success: function(data) {
                $('#product-table').html(data);
                initTablesorter(); // 表が更新されたのでソートを再セット
            },
            error: function(xhr) {
                alert('検索処理に失敗しました。');
            }
        });
    });

    // 3. 🗑️ 削除ボタンが押されたときの非同期処理（外に出しました！）
    $(document).on('click', '.btn-delete', function() {
        var clickBtn = $(this); // 押されたボタン
        var productId = clickBtn.data('id'); // 商品IDを取得

        if (!confirm('本当に削除しますか？')) {
            return; // キャンセルされたら処理を中断
        }

        $.ajax({
            url: "{{ route('products.index') }}/" + productId, // 削除処理のURL
            type: 'POST',
            data: {
                '_method': 'DELETE', // LaravelでDELETE通信にする設定
                '_token': '{{ csrf_token() }}' // セキュリティトークン
            },
            success: function(response) {
                // 成功したら、その商品がある行（<tr>）だけを画面からサッと消す！
                clickBtn.closest('tr').fadeOut(300, function() {
                    $(this).remove();
                });
            },
            error: function(xhr) {
                alert('削除処理に失敗しました。');
            }
        });
    });

});
</script>
@endsection