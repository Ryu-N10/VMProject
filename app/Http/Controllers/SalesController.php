<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    // 購入処理を行うメソッド 
    public function buy(Request $request)
    {
        // 1. 送られてきたリクエストから商品ID（product_id）を取得 
        $productId = $request->input('product_id');

        // データベースのトランザクションを開始（途中で失敗したら元に戻す安全装置） 
        DB::beginTransaction();

        try {
            // 2. 該当の商品データを取得 
            $product = Product::find($productId);

            // 商品が存在しない、または在庫が0以下の場合はエラーを返す 
            if (!$product || $product->stock <= 0) {
                return response()->json(['message' => '商品が存在しないか、在庫がありません。'], 400);
            }

            // 3. 在庫を1つ減らして保存 
            $product->stock -= 1;
            $product->save();

            // 4. sales テーブルに売上記録を追加 
            $sale = new Sale();
            $sale->product_id = $productId;
            $sale->save();

            // ここまでの処理を確定する 
            DB::commit();

            // 成功メッセージを返答する 
            return response()->json(['message' => '購入が完了しました。'], 200);

        } catch (\Exception $e) {
            // エラーが起きた場合は処理を取り消す 
            DB::rollBack();
            return response()->json(['message' => '購入処理に失敗しました。'], 500);
        }
    }
}