<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userName = User::find('3')->name;
        $param = [
            'item_id' => '1',
            'user_id' => '3',
            'user_name' => $userName,
            'payment' => '1',
            'post_number' => '123-4567',
            'address' => '東京都新宿区',
            'building' => '新宿ビル',
        ];
        DB::table('purchases')->insert($param);
        $userName = User::find('1')->name;
        $param = [
            'item_id' => '8',
            'user_id' => '1',
            'user_name' => $userName,
            'payment' => '2',
            'post_number' => '111-1111',
            'address' => '北海道',
            'building' => '北海ビル',
        ];
        DB::table('purchases')->insert($param);
    }
}
