<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddNewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
        ['name'=>'Notifications','display_name'=>'Notifications','parent_id'=>0,'key_code'=>''],
            ['name'=>'List Notifications','display_name'=>'List Notifications','parent_id'=>22,'key_code'=>'list_notification'],
            ['name'=>'Create Notifications','display_name'=>'Create Notifications','parent_id'=>22,'key_code'=>'create_notification'],
            ['name'=>'Update Notifications','display_name'=>'Update Notifications','parent_id'=>22,'key_code'=>'update_notification'],
            ['name'=>'Delete Notifications','display_name'=>'Delete Notifications','parent_id'=>22,'key_code'=>'delete_notification']
        ]);
    }
}
