<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * 商品一覧画面を表示する
     */
    public function index(Request $request)
    {
        // 画面からの入力データを受け取る 📩
        $search = $request->input('search');
        $min_price = $request->input('min_price'); // 価格下限
        $max_price = $request->input('max_price'); // 価格上限
        $min_stock = $request->input('min_stock'); // 在庫下限
        $max_stock = $request->input('max_stock'); // 在庫上限

        $query = Product::with('company');

        // キーワード検索 🔍
        if (!empty($search)) {
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        // 価格（下限）で絞り込み 💰
        if (!empty($min_price)) {
            $query->where('price', '>=', $min_price);
        }

        // 価格（上限）で絞り込み 💰
        if (!empty($max_price)) {
            $query->where('price', '<=', $max_price);
        }

        // 在庫数（下限）で絞り込み 📦
        if (!empty($min_stock)) {
            $query->where('stock', '>=', $min_stock);
        }

        // 在庫数（上限）で絞り込み 📦
        if (!empty($max_stock)) {
            $query->where('stock', '<=', $max_stock);
        }

        $products = $query->get();

        // Ajax通信の場合は、テーブル部品だけを返却する ⚡
        if ($request->ajax()) {
            return view('products.table', compact('products'));
        }

        // 通常のアクセス時は画面全体を返却する 📄
        return view('products.index', compact('products'));
    }

    /**
     * 商品詳細画面を表示する
     */
    public function show($id)
    {
        // 1件取得（見つからなければ自動で404エラー画面にする）
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 商品新規登録画面を表示する
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 新規登録された商品を保存する
     */
    public function store(ProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'product_name' => $request->product_name,
            'company_id'   => $request->company_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'comment'      => $request->comment,
            'image_path'   => $imagePath,
        ]);

        return redirect()->route('products.index');
    }

    /**
     * 商品を削除する
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // ⚡ Ajax通信への返事として成功メッセージ（JSON）を返す
        return response()->json(['success' => '商品を削除しました']);
    }

    /**
     * 商品編集画面を表示する
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報を上書き更新する
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'product_name' => $request->product_name,
            'company_id'   => $request->company_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'comment'      => $request->comment,
            'image_path'   => $imagePath,
        ]);

        return redirect()->route('products.index');
    }
}