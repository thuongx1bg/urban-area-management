<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'username'=>"admin",
             'password' => bcrypt('123456'),
             'status' => 1,
             'building_id'=> 1

         ]);

         $this->call([RoleSeeder::class, BuildingSeeder::class]);

    }
}
