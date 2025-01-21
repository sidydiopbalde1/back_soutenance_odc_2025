<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'create-campagnes',
            'view-campagnes',
            'edit-campagnes',
            'delete-campagnes',
            'create-users',
            'view-users',
            'edit-users',
            'delete-users',
            'create-role',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['libelle' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['libelle' => 'Administrateur']);
        $adminRole->permissions()->sync(Permission::all());
    }
}


