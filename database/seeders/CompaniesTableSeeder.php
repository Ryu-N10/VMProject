<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->truncate();

        DB::table('companies')->insert([
            [
                'id' => 1,
                'company_name' => 'コカ・コーラ',
                'street_address' => '東京都渋谷区',
                'representative_name' => '山田太郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'company_name' => 'サントリー',
                'street_address' => '東京都港区',
                'representative_name' => '佐藤次郎',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'company_name' => 'キリン',
                'street_address' => '東京都中野区',
                'representative_name' => '鈴木花子',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
