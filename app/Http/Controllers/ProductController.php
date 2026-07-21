<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // 1. 検索キーワードを取得
        $search = $request->input('search');

        // 2. Productモデルを使って、メーカー情報（company）も一緒に準備する
        $query = Product::with('company');

        // 3. 検索欄に文字が入っていたら、商品名で絞り込む
        if (!empty($search)) {
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        // 4. データを取得
        $products = $query->get();

        // 5. 画面に渡す
        return view('products.index', compact('products'));
    }

    /**
     * 商品詳細画面を表示する
     */
    public function show($id)
    {
        // 指定されたIDの商品を、メーカー名付きで1件だけ取得する
        $product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->where('products.id', '=', $id)
            ->first(); // 1件だけ取得

        // もし商品が見つからなかったら、一覧画面に戻す
        if (!$product) {
            return redirect()->route('products.index');
        }

        // 詳細画面（show）にデータを持たせて表示する
        return view('products.show', compact('product'));
    }

    /**
     * 商品新規登録画面を表示する
     */
    public function create()
    {
        // セレクトボックスでメーカーを選べるように、すべてのメーカーデータを取得する
        $companies = DB::table('companies')->get();

        // 新規登録画面（create）にメーカーデータを持たせて表示する
        return view('products.create', compact('companies'));
    }

    /**
     * 新規登録された商品を保存する
     */
    public function store(ProductRequest $request)
    {
        // 画像が選択されているか確認
        $imagePath = null;
        if ($request->hasFile('image')) {
            // storage/app/public/products フォルダに画像を保存し、そのパスを取得
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // データベースに保存
        Product::create([
            'product_name' => $request->product_name,
            'company_id'   => $request->company_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'comment'      => $request->comment,
            'image_path'   => $imagePath, // 👈 画像の保存場所を記録！
        ]);

        return redirect()->route('products.index');
    }

    /**
     * 商品を削除する
     */
    public function destroy($id)
    {
        // 指定されたIDの商品をデータベースから削除する
        DB::table('products')->where('id', '=', $id)->delete();

        // 削除が終わったら、商品一覧画面（products.index）に戻る
        return redirect()->route('products.index');
    }

    /**
     * 商品編集画面を表示する
     */
    public function edit($id)
    {
        // 編集したい商品をデータベースから1件取得
        $product = DB::table('products')->where('id', '=', $id)->first();

        // 商品がなければ一覧に戻す
        if (!$product) {
            return redirect()->route('products.index');
        }

        // セレクトボックス用にメーカー全取得
        $companies = DB::table('companies')->get();

        // 編集画面にデータを持たせて表示
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報を上書き更新する
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // 画像が新たに選択された場合は、新しい画像を保存して更新
        $imagePath = $product->image_path; // 基本は今の画像パスをキープ
        if ($request->hasFile('image')) {
            // 新しい画像を保存
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'product_name' => $request->product_name,
            'company_id'   => $request->company_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'comment'      => $request->comment,
            'image_path'   => $imagePath, // 👈 画像パスを更新！
        ]);

        return redirect()->route('products.index');
    }
}