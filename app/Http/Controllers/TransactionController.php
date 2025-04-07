<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillChargeRequest;
use App\Http\Requests\CreditChargeRequest;
use App\Http\Requests\TransactionRequest;
use App\Services\Transactions\TransactionsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionsService $transactionsService)
    {
        $this->transactionService = $transactionsService;
    }


    public function transferTransaction(TransactionRequest $request, $id)
    {
        try {
            $transaction = $this->transactionService->transfertMoney(
                $id,
                $request->input("amount"),
                $request->input("receiver_number"),
            );
            return response()->json([
                'message' => 'Transfert effectué avec succès !',
                'transaction' => $transaction
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function creditChargeTransaction(CreditChargeRequest $request, $id)
    {
        try {
            $transaction = $this->transactionService->creditCharge(
                $id,
                $request->input('amount'),
            );
            return response()->json([
                'message' => 'Recharge de crédit effectuée avec succès',
                'transaction' => $transaction
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function billPaiementTransaction(BillChargeRequest $request, $id)
    {
        try {
            $transaction = $this->transactionService->billPaiement(
                $id,
                $request->input('bill_reference'),
                $request->input('amount'),
            );
            return response()->json([
                'message' => 'paiement facture effectué avec succès !',
                'transaction' => $transaction
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function processRewards(): JsonResponse
    {
        $transactions = $this->transactionService->processTransactionsForRewards();

        return response()->json([
            'message' => 'Transactions récupérées avec succès',
            'transactions' => $transactions
        ]);
    }

    public function getTransactionsOfTheDay()
    {
        $transactions = $this->transactionService->getUnRewardedTransactionsOfTheDay();

        return response()->json([
            'message' => 'Transactions du jour non récompensées',
            'transactions' => $transactions
        ]);
    }


}
