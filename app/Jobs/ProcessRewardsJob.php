<?php

namespace App\Jobs;

use App\Mail\RewardNotificationMail;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Mail;

class ProcessRewardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $transactionsCampaigns;
    /**
     * Create a new job instance.
     */
    public function __construct($transactionsCampaigns)
    {
        $this->transactionsCampaigns = $transactionsCampaigns;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->transactionsCampaigns as $campaignTransaction) {
            // ⚠ Récupérer la première campagne (car $campaignTransaction['campaign'] est une collection)
            $campaign = $campaignTransaction['campaign']->first();

            // Vérifier si la campagne est bien définie
            if (!$campaign) {
                Log::warning("Aucune campagne trouvée pour les transactions.");
                continue;
            }

            $transactions = $campaignTransaction['transactions'];

            Log::info($transactions);

            foreach ($transactions as $transaction) {
                $client = Client::where('id', $transaction['sender_msisdn_id'])->first();

                if (!$client) {
                    Log::warning("Client introuvable pour le MSISDN: " . $transaction['sender_msisdn_id']);
                    continue;
                }

                // 🔹 Vérifier si la clé 'rewards' existe et n'est pas vide
                if (!isset($campaign['rewards']) || empty($campaign['rewards'])) {
                    Log::warning("Pas de récompenses définies pour la campagne : " . $campaign['libelle']);
                    continue;
                }

                // Traiter les récompenses
                foreach ($campaign['rewards'] as $reward) {
                    $rewardName = $reward['name'] ?? "Récompense inconnue";

                    // Log du message de notification
                    Log::info("Notification : {$client->email} - Suite à votre transaction, vous bénéficiez de : {$rewardName} de la campagne {$campaign['libelle']}");

                    // Simuler l'envoi d'email (sera remplacé par un envoi réel plus tard)
                    Mail::to($client->email)->send(new RewardNotificationMail($client, $reward, $campaign));
                }

                // Mettre à jour la transaction
                Transaction::where('id', $transaction['id'])->update(['rewarded' => 1]);
                Log::info("Transaction {$transaction['id']} mise à jour avec rewarded = true");
            }
        }
    }
}



// foreach ($this->transactionsCampaigns as $campaignTransaction) {
//     $campaign = $campaignTransaction['campaign'];
//     $transactions = $campaignTransaction['transactions'];

//     foreach ($transactions as $transaction) {
//         $client = Client::where('id', $transaction['sender_msisdn_id'])->first();

//         if (!$client) {
//             Log::warning("Client introuvable pour le MSISDN: " . $transaction['sender_msisdn_id']);
//             continue;
//         }

//         // Récupérer les récompenses de la campagne
//         $rewards = $campaign['rewards'];

//         foreach ($rewards as $reward) {
//             $rewardName = $reward['name'];

//             // Log du message de notification
//             Log::info("Notification : {$client->email} - Suite à votre transaction, vous bénéficiez de : {$rewardName} de la campagne {$campaign['libelle']}");

//             // Simuler l'envoi d'email (sera remplacé par un envoi réel plus tard)
//             // Mail::to($client->email)->send(new RewardNotificationMail($client, $reward, $campaign));
//         }


//         Transaction::where('id', $transaction['id'])->update(['rewarded' => 1]);
//         Log::info("Transaction {$transaction['id']} mise à jour avec rewarded = true");
//     }
// }




// foreach ($this->transactionsCampaigns as $campaignTransaction) {
//     $campaign = $campaignTransaction['campaign'];
//     $transactions = $campaignTransaction['transactions'];

//     foreach ($transactions as $transaction) {
//         // Récupérer le client via "sender_msisdn"
//         // $client = Client::where('msisdn', $transaction['sender_msisdn_id'])->first();
//         $client = Client::where('id', $transaction['sender_msisdn_id'])->first();

//         if (!$client) {
//             Log::warning("Client introuvable pour le MSISDN: " . $transaction['sender_msisdn_id']);
//             continue;
//         }

//         // Récupérer les récompenses de la campagne
//         $rewards = $campaign['rewards'];

//         foreach ($rewards as $reward) {
//             $rewardName = $reward['name'];

//             // Log du message de notification
//             Log::info("Notification : {$client->email} - Suite à votre transaction, vous bénéficiez de : {$rewardName} de la campagne {$campaign['libelle']}");
//             // Simuler l'envoi d'email (sera remplacé par un envoi réel plus tard)
//             // Mail::to($client->email)->send(new RewardNotificationMail($client, $reward, $campaign));
//         }

//         // Mise à jour de l'état rewarded de la transaction:
//         // Transaction::when('id', $transaction['id']->update(['rewarded' => true]));
//         Transaction::where('id', $transaction['id'])->update(['rewarded' => 1]);
//         Log::info("Transaction {$transaction['id']} mise à jour avec rewarded = true");
//     }
// }
