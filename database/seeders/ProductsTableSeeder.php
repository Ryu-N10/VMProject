<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();

        DB::table('products')->insert([
            [
                'company_id' => 1, // コカ・コーラのID
                'product_name' => 'コカ・コーラ 500ml',
                'price' => 160,
                'stock' => 50,
                'comment' => '定番の炭酸飲料です。',
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2, // サントリーのID
                'product_name' => '伊右衛門 500ml',
                'price' => 150,
                'stock' => 30,
                'comment' => '香り豊かなお茶です。',
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 3, // キリンのID
                'product_name' => '生茶 500ml',
                'price' => 150,
                'stock' => 45,
                'comment' => 'まろやかな味わいのお茶です。',
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
