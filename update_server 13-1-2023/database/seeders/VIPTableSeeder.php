<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VIPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('vips')->insert([
            'name' => 'VIP1',
            'tag' => "VIP1",
            'price' => '1000',
            "icon" => "",
            "motion_icon" => ""
        ]);
        DB::table('vips')->insert([
            'name' => 'VIP2',
            'tag' => "VIP2",
            'price' => '2000',
            "icon" => "",
            "motion_icon" => ""
        ]);
        DB::table('vips')->insert([
            'name' => 'VIP3',
            'tag' => "VIP3",
            'price' => '3000',
            "icon" => "",
            "motion_icon" => ""
        ]);
        DB::table('vips')->insert([
            'name' => 'VIP4',
            'tag' => "VIP4",
            'price' => '4000',
            "icon" => "",
            "motion_icon" => ""
        ]);
        DB::table('vips')->insert([
            'name' => 'VIP5',
            'tag' => "VIP5",
            'price' => '5000',
            "icon" => "",
            "motion_icon" => ""
        ]);


    }
}
