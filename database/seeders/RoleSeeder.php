<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['Administrateur','Marketeur', 'Superviseur', 'Manager'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['libelle' => $role]);
        }
    }
}

