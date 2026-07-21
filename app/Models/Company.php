<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // メーカーは、たくさんの商品を持っているという関係
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}