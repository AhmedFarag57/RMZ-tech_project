<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

            $this->call(RolesAndPermissionsSeeder::class);

            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('123456789'),
                'created_at' => date("Y-m-d H:i:s")
            ]);

            $admin->assignRole('Admin');
    }
}
