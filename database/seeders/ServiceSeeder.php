<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'code' => 'BILL',
                'description' => 'Payement facture',
                'cibles' => 'C',
            ],
            [
                'code' => 'DON',
                'description' => 'Don collecte',
                'cibles' => 'C',
            ],
            [
                'code' => 'IRT_OUT',
                'description' => 'Envoi international sous région',
                'cibles' => 'C',
            ],
            [
                'code' => 'RINT',
                'description' => 'Réception international',
                'cibles' => 'C',
            ],
            [
                'code' => 'IRT_IN',
                'description' => 'Réception international sous région',
                'cibles' => 'C',
            ],
            [
                'code' => 'API',
                'description' => 'API',
                'cibles' => 'All',
            ],
            [
                'code' => 'WELLI',
                'description' => 'WELLI',
                'cibles' => 'C',
            ],
            [
                'code' => 'MERCHANT',
                'description' => 'Payement marchand',
                'cibles' => 'All',
            ],
            [
                'code' => 'CASHOUT_DISTANT',
                'description' => 'Retrait distant',
                'cibles' => 'All',
            ],
            [
                'code' => 'ECOMMERCE',
                'description' => 'ECOMMERCE',
                'cibles' => 'All',
            ],
            [
                'code' => 'PASS_ILLIMIX',
                'description' => 'Passe illimix',
                'cibles' => 'All',
            ],
            [
                'code' => 'PASS_INTERNET',
                'description' => 'Passe internet',
                'cibles' => 'All',
            ],
            [
                'code' => 'CASHIN_DISTANT',
                'description' => 'Dépôt distant',
                'cibles' => 'All',
            ],
            [
                'code' => 'TAC',
                'description' => 'Transfert avec code',
                'cibles' => 'C',
            ],
            [
                'code' => 'TOP_UP_EXPRESSO',
                'description' => 'Achat crédit expresso',
                'cibles' => 'C',
            ],
            [
                'code' => 'TOP_UP_FREE',
                'description' => 'Achat crédit Free',
                'cibles' => 'C',
            ],
            [
                'code' => 'TOP_UP_HORS_MAXIT',
                'description' => 'Achat crédit hors maxit',
                'cibles' => 'C',
            ],
            [
                'code' => 'TOP_UP_MAXIT',
                'description' => 'Achat crédit sur maxit',
                'cibles' => 'C',
            ],
            [
                'code' => 'TOP_UP_PROMOBILE',
                'description' => 'Achat crédit promobile',
                'cibles' => 'C',
            ],
            [
                'code' => 'PCREDIT',
                'description' => 'Banque-crédit',
                'cibles' => 'C',
            ],
            [
                'code' => 'EPARGNE',
                'description' => 'Banque-épargne',
                'cibles' => 'C',
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                'code' => $service['code'],
                'description' => $service['description'],
                'cibles' => $service['cibles'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}