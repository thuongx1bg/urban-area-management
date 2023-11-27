<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            // Buildings
            ['name'=>'Buildings','display_name'=>'Buildings','parent_id'=>0,'key_code'=>''],
            ['name'=>'List Buildings','display_name'=>'List Buildings','parent_id'=>1,'key_code'=>'list_building'],
            ['name'=>'Create Building','display_name'=>'Create Buildings','parent_id'=>1,'key_code'=>'create_building'],
            ['name'=>'Update Building','display_name'=>'Update Buildings','parent_id'=>1,'key_code'=>'update_building'],
            ['name'=>'Delete Building','display_name'=>'Delete Buildings','parent_id'=>1,'key_code'=>'delete_building'],

            // Users
            ['name'=>'Users','display_name'=>'Users','parent_id'=>0,'key_code'=>''],
            ['name'=>'List Users','display_name'=>'List Users','parent_id'=>6,'key_code'=>'list_user'],
            ['name'=>'Create Users','display_name'=>'Create Users','parent_id'=>6,'key_code'=>'create_user'],
            ['name'=>'Update Users','display_name'=>'Update Users','parent_id'=>6,'key_code'=>'update_user'],
            ['name'=>'Delete Users','display_name'=>'Delete Users','parent_id'=>6,'key_code'=>'delete_user'],

            // QrCodes
            ['name'=>'QrCodes','display_name'=>'QrCodes','parent_id'=>0,'key_code'=>''],
            ['name'=>'List QrCodes','display_name'=>'List QrCodes','parent_id'=>11,'key_code'=>'list_qrcode'],
            ['name'=>'Create QrCodes','display_name'=>'Create QrCodes','parent_id'=>11,'key_code'=>'create_qrcode'],
            ['name'=>'Update QrCodes','display_name'=>'Update QrCodes','parent_id'=>11,'key_code'=>'update_qrcode'],
            ['name'=>'Delete QrCodes','display_name'=>'Delete QrCodes','parent_id'=>11,'key_code'=>'delete_qrcode'],
            ['name'=>'Check QrCodes','display_name'=>'Check QrCodes','parent_id'=>11,'key_code'=>'check_qrcode'],

            //Roles
            ['name'=>'Roles','display_name'=>'Roles','parent_id'=>0,'key_code'=>''],
            ['name'=>'List Roles','display_name'=>'List Roles','parent_id'=>17,'key_code'=>'list_role'],
            ['name'=>'Create Roles','display_name'=>'Create Roles','parent_id'=>17,'key_code'=>'create_role'],
            ['name'=>'Update Roles','display_name'=>'Update Roles','parent_id'=>17,'key_code'=>'update_role'],
            ['name'=>'Delete Roles','display_name'=>'Delete Roles','parent_id'=>17,'key_code'=>'delete_role'],

        ]);
    }
}
