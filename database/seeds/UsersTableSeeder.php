<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'password_x' => bcrypt('adminadmin'),
            'rule' => '0',
            'ktp_img' => '',
            'ktp_img_user' => '',
            'ktp_number' => '0',
            'phone' => '0',
            'image' => '',
            'province' => '',
            'district' => '',
            'sub_district' => '',
            'village' => '',
            'number_address' => 0,
            'description_address' => '',
            'premium' => 1,
            'status' => 1,
        ]);

        DB::table('binaries')->insert([
            'sponsor' => '1',
            'up_line' => '1',
            'user' => '1',
            'position' => '3',
            'invest' => '1',
        ]);

        DB::table('investments')->insert([
            'user' => '1',
            'reinvest' => '1',
            'join' => '500000',
            'package' => '1500000',
            'profit' => '0',
            'status' => '2',
        ]);

        DB::table('bonuses')->insert([
            'user' => '1',
            'invest_id' => '1',
            'description' => 'Bonus Sponsor',
            'debit' => '0',
            'credit' => '75000',
        ]);

        DB::table('vocer_points')->insert([
            'user' => '1',
            'bonus_id' => '1',
            'description' => 'Reinvest Limit',
            'debit' => '0',
            'credit' => '1500000',
        ]);
    }
}
