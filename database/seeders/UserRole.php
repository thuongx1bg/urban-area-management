<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permissions::where('parent_id','!=',0)->get()->pluck('id');
        foreach ($permission as $p){
            DB::table('permission_role')->insert([
                [
                    'role_id'=>1,
                    'permission_id'=>$p
                ]
            ]);
        }

    }
}
