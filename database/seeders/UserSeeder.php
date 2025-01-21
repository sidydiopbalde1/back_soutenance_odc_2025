<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nom' => 'Balde',
                'prenom' => 'Sidy Diop',
                'telephone' => '784316538',
                 'Matricule' => 'stg_balde87194',
                'login' => 'stg_balde87194@orange-sonatel.com',
                'password' => Hash::make('passer123'),
                'role_id' => 1,
                'email' => 'sididiop53@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Moussa',
                'prenom' => 'Diop',
                'telephone' => '784536578',
                'Matricule' => 'moussadiop028043',
                'login' => 'moussadiop028043@orange-sonatel.com',
                'password' => Hash::make('passer123'),
                'role_id' => 4,
                'email' => 'moussadiop@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Hadiyatou',
                'prenom' => 'Ba',
                'telephone' => '772097867',
                'Matricule' => 'stg_ba',
                'login' => 'stg_ba@orange-sonatel.com',
                'password' => Hash::make('passer123'),
                'role_id' => 2,
                'email' => 'neneba@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Sow',
                'prenom' => 'Bobo',
                'telephone' => '772097860',
                'Matricule' => 'stg_sow123',
                'login' => 'stg_sow123@orange-sonatel.com',
                'password' => Hash::make('passer123'),
                'role_id' => 3,
                'email' => 'sow_bobo@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
