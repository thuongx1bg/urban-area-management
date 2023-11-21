<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name'=>'admin','display_name'=>'Administrator'],
            ['name'=>'guest','display_name'=>'Resident'],
            ['name'=>'security','display_name'=>'Security Guard']
        ]);
    }
}
