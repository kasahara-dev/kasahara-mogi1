<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'img_path' => 'img/item/Armani+Mens+Clock.jpg',
            'condition' => '1',
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '1',
            'img_path' => 'img/item/HDD+Hard+Disk.jpg',
            'condition' => '2',
            'name' => 'HDD',
            'brand' => '西芝',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '1',
            'img_path' => 'img/item/iLoveIMG+d.jpg',
            'condition' => '3',
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'img/item/Leather+Shoes+Product+Photo.jpg',
            'condition' => '4',
            'name' => '革靴',
            'brand' => '',
            'detail' => 'クラシックなデザインの革靴',
            'price' => 4000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'img/item/Living+Room+Laptop.jpg',
            'condition' => '1',
            'name' => 'ノートPC',
            'brand' => '',
            'detail' => '高性能なノートパソコン',
            'price' => 45000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'img/item/Music+Mic+4632231.jpg',
            'condition' => '2',
            'name' => 'マイク',
            'brand' => 'なし',
            'detail' => '高音質のレコーディング用マイク',
            'price' => 8000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'img/item/Purse+fashion+pocket.jpg',
            'condition' => '3',
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'img_path' => 'img/item/Tumbler+souvenir.jpg',
            'condition' => '4',
            'name' => 'タンブラー',
            'brand' => 'なし',
            'detail' => '使いやすいタンブラー',
            'price' => 500,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'img_path' => 'img/item/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '1',
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'detail' => '手動のコーヒーミル',
            'price' => 4000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'img_path' => 'img/item/外出メイクアップセット.jpg',
            'condition' => '2',
            'name' => 'メイクセット',
            'brand' => '',
            'detail' => '便利なメイクアップセット',
            'price' => 2500,
        ];
        DB::table('items')->insert($param);
    }
}
