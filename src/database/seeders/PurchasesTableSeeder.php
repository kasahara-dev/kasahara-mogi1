<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => '1',
            'user_id' => '3',
            'payment' => '1',
            'address_id' => '1',
        ];
        DB::table('purchases')->insert($param);
        $param = [
            'item_id' => '8',
            'user_id' => '1',
            'payment' => '2',
            'address_id' => '2',
        ];
        DB::table('purchases')->insert($param);
    }
}
