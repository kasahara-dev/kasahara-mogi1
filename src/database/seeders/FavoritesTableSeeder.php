<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->insert(
            [
                'user_id' => '1',
                'item_id' => '4',
            ]
        );
        DB::table('favorites')->insert(
            [
                'user_id' => '4',
                'item_id' => '4',
            ]
        );
        DB::table('favorites')->insert(
            [
                'user_id' => '5',
                'item_id' => '4',
            ]
        );
        DB::table('favorites')->insert(
            [
                'user_id' => '1',
                'item_id' => '7',
            ]
        );
        DB::table('favorites')->insert(
            [
                'user_id' => '1',
                'item_id' => '9',
            ]
        );
    }
}
