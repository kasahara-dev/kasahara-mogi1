<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '1',
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '1',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '2',
            'name' => 'HDD',
            'brand' => '西芝',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '1',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => '3',
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '4',
            'name' => '革靴',
            'brand' => '',
            'detail' => 'クラシックなデザインの革靴',
            'price' => 4000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '1',
            'name' => 'ノートPC',
            'brand' => '',
            'detail' => '高性能なノートパソコン',
            'price' => 45000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '2',
            'name' => 'マイク',
            'brand' => 'なし',
            'detail' => '高音質のレコーディング用マイク',
            'price' => 8000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => '3',
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '4',
            'name' => 'タンブラー',
            'brand' => 'なし',
            'detail' => '使いやすいタンブラー',
            'price' => 500,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '1',
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'detail' => '使いやすいタンブラー',
            'price' => 4000,
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '2',
            'name' => 'メイクセット',
            'brand' => '',
            'detail' => '便利なメイクアップセット',
            'price' => 2500,
        ];
        DB::table('items')->insert($param);
    }
}
