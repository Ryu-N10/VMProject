<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * 商品一覧画面を表示する
     */
    public function index()
    {
        // productsテーブルにcompaniesテーブルを合体（結合）させてデータを取ってくる
        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->get();

        // 画面にデータを送る
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
    public function store(Request $request)
    {
        // 入力チェック（バリデーション）：空っぽのまま登録されるのを防ぐルールです！
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            // 画像は今回は一旦nullable（空でもOK）にしておきます
        ]);

        // データベースに新しい商品データを保存する
        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 保存が終わったら、商品一覧画面（products.index）に戻る
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
    public function update(Request $request, $id)
    {
        // 入力チェック
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
        ]);

        // データベースのデータを上書き（update）する
        DB::table('products')
            ->where('id', '=', $id)
            ->update([
                'product_name' => $request->product_name,
                'company_id' => $request->company_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'comment' => $request->comment,
                'updated_at' => now(),
            ]);

        // 更新が終わったら詳細画面に戻る（または一覧でもOKですが、今回は一覧に戻します）
        return redirect()->route('products.index');
    }
}