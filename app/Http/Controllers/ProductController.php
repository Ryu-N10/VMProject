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
        $search = $request->input('search');

        $query = Product::with('company');

        if (!empty($search)) {
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        $products = $query->get();

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
        return redirect()->route('products.index');
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