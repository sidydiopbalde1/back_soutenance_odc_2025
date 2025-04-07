<?php
namespace App\Services\Transactions;

use App\Models\Transaction;
use App\Repository\Transactions\TransactionRepository;
use App\Repository\Client\ClientRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionsService
{
    protected $transactionRepository;
    protected $clientRepository;

    public function __construct(TransactionRepository $transactionRepositoty, ClientRepository $clientRepository)
    {
        $this->transactionRepository = $transactionRepositoty;
        $this->clientRepository = $clientRepository;
    }

    public function transfertMoney($clientId, $amount, $recieverNumber)
    {

        // Récupérer le client:
        $client = $this->clientRepository->getClientById($clientId);

        if (!$client) {
            throw new Exception("Client non trouvé !");
        }

        try {
            DB::beginTransaction();

            // Débiter le client
            $client->solde -= $amount;
            $client->save();

            // Enregistrer la transaction:
            $transaction = $this->transactionRepository->createTransaction([
                'service_type' => 'p2p',
                'sender_msisdn_id' => $client->id,
                'transaction_amount' => $amount,
                'commission_paid' => 0,
                'transfert_datetime' => now(),
                'sender_user_type' => 'subscriber',
                'rewarded' => false
            ]);

            DB::commit();
            return $transaction;

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur lors du transfert :" . $e->getMessage());
        }
    }

    public function creditCharge($clientId, $amount)
    {
        $client = $this->clientRepository->getClientById($clientId);
        if (!$client) {
            throw new Exception("Client non trouvé");
        }

        try {
            $transaction = $this->transactionRepository->createTransaction([
                'service_type' => 'rc',
                'sender_msisdn_id' => $client->id,
                'transaction_amount' => $amount,
                'commission_paid' => 0,
                'transfert_datetime' => now(),
                'sender_user_type' => 'subscriber',
                'rewarded' => false
            ]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la recharge de crédit");
        }
    }

    public function billPaiement($clientId, $bill_reference, $amount){
        // merchpay

        $client = $this->clientRepository->getClientById($clientId);
        if(!$client) {
            throw new Exception("Client non trouvé");
        }

        try {
            $transaction = $this->transactionRepository->createTransaction([
                'service_type' => 'merchpay',
                'sender_msisdn_id' => $client->id,
                'transaction_amount' => $amount,
                'commission_paid' => 0,
                'transfert_datetime' => now(),
                'sender_user_type' => 'subscriber',
                'rewarded' => false
            ]);
        }
        catch(Exception $e) {
            throw new Exception("Erreur lors du paiment facture". $e->getMessage());
        }
    } 

    public function processTransactionsForRewards()
    {
        $transactionsByServiceType = $this->transactionRepository->getUnrewardedTransactionsOfTheDay();

        // Pour l'instant, on affiche juste les transactions groupées pour vérification
        return $transactionsByServiceType;
    }

    public function getUnRewardedTransactionsOfTheDay()
    {
        // Récupérer les transactions du jour non récompensées
        $transactions = Transaction::whereDate('transfert_datetime', Carbon::today())
            ->where('rewarded', false)
            ->get()
            ->groupBy('service_type');

        return $transactions;
    }
}