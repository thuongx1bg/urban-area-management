<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        [$privateKey, $publicKey] = createKey("admin");

         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'test@example.com',
             'username'=>"admin",
             'password' => bcrypt('123456'),
             'status' => 1,
             'building_id'=> 1,
             'own_id'=> 0,
             'private_key'=>$privateKey,
             'public_key'=>$publicKey
         ]);


         $this->call([RoleSeeder::class, BuildingSeeder::class,PermissionSeeder::class,AddNewPermissionSeeder::class]);

    }
}
