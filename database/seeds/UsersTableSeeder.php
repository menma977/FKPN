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
            'position' => 0
        ]);
    }
}
