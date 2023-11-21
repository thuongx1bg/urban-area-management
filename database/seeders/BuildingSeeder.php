<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i =1;$i<=8;$i++){
            DB::table('buildings')->insert([
                    ['name'=>'Phòng '.$i.'01 ','address'=>'Phòng '.$i.'01, 420 khương đình, thành xuân, hà nội'],
                    ['name'=>'Phòng '.$i.'02 ','address'=>'Phòng '.$i.'02, 420 khương đình, thành xuân, hà nội'],
                    ['name'=>'Phòng '.$i.'03 ','address'=>'Phòng '.$i.'03, 420 khương đình, thành xuân, hà nội'],
                    ['name'=>'Phòng '.$i.'04 ','address'=>'Phòng '.$i.'04, 420 khương đình, thành xuân, hà nội'],
            ]);
        };

    }
}
