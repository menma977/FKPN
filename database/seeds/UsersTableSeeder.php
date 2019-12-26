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
            'status' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'member',
            'username' => 'member',
            'email' => 'member@gmail.com',
            'password' => bcrypt('member'),
            'rule' => '1',
            'ktp_img' => '',
            'ktp_img_user' => '',
            'ktp_number' => '1',
            'phone' => '1',
            'image' => '',
            'province' => '',
            'district' => '',
            'sub_district' => '',
            'village' => '',
            'number_address' => 0,
            'description_address' => '',
            'status' => 1,
        ]);

        DB::table('binaries')->insert([
            'sponsor' => '1',
            'user' => '2',
            'position' => 0,
            'invest' => 1
        ]);

        DB::table('investments')->insert([
            'user' => '1',
            'reinvest' => '1',
            'join' => '500000',
            'package' => '1500000',
            'profit' => '0',
        ]);

        DB::table('investments')->insert([
            'user' => '2',
            'reinvest' => '1',
            'join' => '500000',
            'package' => '1500000',
            'profit' => '0',
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
            'description' => 'Bonus Sponsor',
            'debit' => '75000',
            'credit' => '0',
        ]);
    }
}
