<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // データベースに保存していい項目（書き込み許可リスト）を指定する
    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'image_path', // 画像カラムの追加
    ];

    // 商品（Product）は、1つのメーカー（Company）に所属するという関係（リレーション）
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}