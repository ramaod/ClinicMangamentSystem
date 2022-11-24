<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = \App\Models\Role::create([
            'name' => 'super_Admin',
            'display_name' => 'super Admin',
            'description' => 'can do anything un the app'
        ]);

        $user = \App\Models\Role::create([
            'name' => 'user',
            'display_name' => 'user',
            'description' => 'can do limited thing in the app'
        ]);
    }
}
