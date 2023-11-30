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
        DB::table('buildings')->insert([
            ['name'=> "Management",'address'=>'Management'],
        ]);
        $buildings = [
            "Bằng Lăng","Hoa Sữa","Hoa Phượng","Hoa Lan","Hoa Anh Đào"
        ];

        foreach ($buildings as $building){
            for($i =1;$i<=100;$i++){
                DB::table('buildings')->insert([
                    ['name'=> $building .' - '.$i,'address'=>'nhà số '.$i.' đường '.$building.'.'],
                ]);
            };
        }
    }
}
