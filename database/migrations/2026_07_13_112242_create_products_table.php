<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->comment('メーカーID');
            $table->string('product_name')->comment('商品名');
            $table->integer('price')->comment('価格');
            $table->integer('stock')->comment('在庫数');
            $table->text('comment')->nullable()->comment('詳細・コメント');
            $table->string('image_path')->nullable()->comment('画像パス');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
