<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * このリクエストを使用する権限があるかどうか
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 入力チェックのルール（持ち物検査の基準）
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|integer',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 👈 このあと使う画像チェックも先に入れておきます！
        ];
    }

    /**
     * エラーメッセージの日本語化（親切な表示用）
     */
    public function messages(): array
    {
        return [
            'product_name.required' => '商品名は必須項目です。',
            'company_id.required'   => 'メーカーを選択してください。',
            'price.required'        => '価格は必須項目です。',
            'stock.required'        => '在庫数は必須項目です。',
            'image.image'           => '画像ファイルを選択してください。',
        ];
    }
}