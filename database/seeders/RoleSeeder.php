<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating Roles
        Role::create(['name' => \App\Models\User::ROLE_USER]);
        Role::create(['name' => \App\Models\User::ROLE_ADMIN]);
    }
}
