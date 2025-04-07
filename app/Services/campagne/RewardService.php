<?php

namespace App\Services\Campagne;

use App\Models\Transaction;
use App\Repository\Transactions\TransactionRepository;
use App\Services\Transactions\TransactionsService;
use Carbon\Carbon;
use Log;

class RewardService
{
    private $transactionRepository;
    private $campagneService;

    private $transactionService;

    public function __construct(TransactionRepository $transactionRepository, CampagneService $campagneService, TransactionsService $transactionsService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->campagneService = $campagneService;
        $this->transactionService = $transactionsService;
    }

    public function processTransactionsForRewards()
    {
        // Récupérer les transactions du jour non récompensées, groupées par service_type.3
        $transactionsByServiceType = $this->transactionRepository->getUnrewardedTransactionsOfTheDay();

        // 2. Récupérer les campagnes actives du jour, groupées par code de service
        $campaignsByServiceCode = $this->campagneService->getActiveCampaignsOfTheDay();

        return [
            'transactions' => $transactionsByServiceType,
            'campaigns' => $campaignsByServiceCode,
        ];
    }

    public function matchTransactionsWhithCampaigns()
    {

        // Récupérer les transactions du jour non récompensées
        $transactions = $this->transactionService->getUnRewardedTransactionsOfTheDay();

        // Récupérer les campagnes actives du jour:
        $campaigns = $this->campagneService->getActiveCampaignsOfTheDay();
        // Faire correspondre transactions et campagnes:
        $matches = [];
        foreach ($transactions as $serviceType => $transList) {
            if ($campaigns->has($serviceType)) {
                $matches[$serviceType] = [
                    'transactions' => $transList,
                    'campaign' => $campaigns[$serviceType]
                ];
            }
        }

        return $matches;

    }
}


/*
C'est bon. A présent je voudrais ajouter un service de messagerie en utilisant infobip.
Le contenu sera le même qu'avec le mail. Sauf que nous devrions faire toutes les  installations et configurations
pour pouvoir utiliser infobip
*/