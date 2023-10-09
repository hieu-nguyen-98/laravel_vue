<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name_app' => 'E-mart Online Shopping',
            // 'meta_description' => 'E-mart Online Shopping',
            // 'meta_keywords' => 'E-mart, Online Shopping, E-commerce Website',
            'logo' => '',
            // 'favicon' => '',
            'address' => 'Phuc Yen, Vinh Phuc',
            'email' => 'info@emart.com',
            'phone_1' => '0352621297',
            'phone_2' => '0352621297',
            // 'fax' => '0152 21540 154',
            // 'footer' => 'Hieu Nguyen',
            'facebook' =>'',
            'instagram' =>'',
            'linked' =>'',
            'youtube' =>'',
        ]); 
    }
}
