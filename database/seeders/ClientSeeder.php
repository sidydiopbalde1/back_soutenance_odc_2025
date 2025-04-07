<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert(
            [
                'msisdn' => '771234566',
                'solde' => 5000,
                'email' => 'client1@gmail.com',
                'user_first_name' => 'Baba',
                'user_last_name' => 'Ndiaye',
                'sex' => 'M',
            ]
        );
    }
}
