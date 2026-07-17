<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. 初期ルートと認証ルート
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// 2. 商品管理システム（自販機）のルート群

// ① 新規登録画面（表示）
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// ② 新規登録処理（保存）
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

// ③ 編集画面（表示）
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// ④ 編集処理（上書き保存）
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');

// ⑤ 詳細画面（表示）
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ⑥ 削除処理
Route::post('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// ⑦ 一覧画面（表示）
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
