<?php
namespace App\Repository\Transactions;

use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository
{
    public function createTransaction(array $data)
    {
        return Transaction::create($data);
    }

    public function getUnrewardedTransactionsOfTheDay()
    {
        return Transaction::whereDate('transfert_datetime', Carbon::today())
            ->where('rewarded', false)
            ->get()
            ->groupBy('service_type');
    }
}       