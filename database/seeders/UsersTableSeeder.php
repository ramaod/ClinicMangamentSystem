<?php

namespace Database\Seeders;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'super_admin',
            'email' => 'superAdmin@app.com',
            'password' => bcrypt(value:'123456789'),
            'phone' => '0963258741',
        ]);
        $user -> attachRole('super_Admin');
    }   
}
