<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionSeeder extends Seeder
{
    public function run()
    {

        $permissons = [
            [
                'name' => 'CheckController@index',
                'display_name' => 'Index',
                'description' => 'Check'
            ],
            [
                'name' => 'CheckController@create',
                'display_name' => 'Create',
                'description' => 'Check'
            ],
        ];

        foreach ($permissons as $key => $value) {

            $permission = Permission::create([
                            'name' => $value['name'],
                            'display_name' => $value['display_name'],
                            'description' => $value['description']
                        ]);

            $permission -> bootLaratrustPermissionTrait('permission');
        }
    }
}