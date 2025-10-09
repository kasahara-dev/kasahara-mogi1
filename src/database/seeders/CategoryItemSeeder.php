<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_item')->insert(
            [
                'category_id' => '1',
                'item_id' => '1',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '5',
                'item_id' => '1',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '2',
                'item_id' => '2',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '11',
                'item_id' => '3',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '5',
                'item_id' => '4',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '1',
                'item_id' => '4',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '2',
                'item_id' => '5',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '2',
                'item_id' => '6',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '1',
                'item_id' => '7',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '4',
                'item_id' => '7',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '10',
                'item_id' => '8',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '10',
                'item_id' => '9',
            ]
        );
        DB::table('category_item')->insert(
            [
                'category_id' => '6',
                'item_id' => '10',
            ]
        );
    }
}
