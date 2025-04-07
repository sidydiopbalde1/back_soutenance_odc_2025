<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert(
            [
                'service_type' => 'cashout',
                'sender_msisdn_id' => 1,
                'transaction_amount' => 1500,
                'commission_paid' => 20,
                'transfert_datetime' => '2025-03-22 18:09:31',
                'sender_user_type' => 'channel'                
            ]
        );
    }
}
