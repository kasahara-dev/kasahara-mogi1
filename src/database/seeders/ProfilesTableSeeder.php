<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Address;
use Illuminate\Support\Facades\DB;


class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->all();
        $addresses = Address::pluck('id')->all();
        foreach ($users as $user) {
            $param = [
                'user_id' => $user,
                'address_id' => $addresses[array_rand($addresses)],
            ];
            DB::table('profiles')->insert($param);
        }
    }
}
