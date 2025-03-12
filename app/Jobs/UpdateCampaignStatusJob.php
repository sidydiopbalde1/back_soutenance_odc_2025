<?php

namespace App\Jobs;

use App\Services\Interfaces\IDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateCampaignStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('🔄 Job UpdateCampaignStatusJob démarré...');

        try {
            // Initialiser le service DANS handle() pour éviter la sérialisation de MongoDB Manager
            $databaseService = app(IDatabase::class);
            
            // Récupération des campagnes
            $campaigns = $databaseService->getAllDocuments('campagnes');
            Log::info("Liste des campagnes trouvées : " . json_encode($campaigns));
            $now = Carbon::now();

            Log::info("📊 Nombre de campagnes trouvées : " . count($campaigns));

            foreach ($campaigns as $campaign) {
                $startDate = Carbon::parse($campaign['dateStart']);
                $newStatus = null;

                Log::info("🔍 Vérification de la campagne ID: {$campaign['_id']}, État actuel: {$campaign['status']}");

                if ($campaign['status'] == "validée") {
                    if ($startDate->isToday() || $startDate->isPast()) {
                        $newStatus = 'en cours';
                    }
                }

                if ($startDate->isPast()) {
                    $newStatus = 'expiré';
                }

                if ($newStatus && $campaign['status'] !== $newStatus) {
                    Log::info("✅ Mise à jour de la campagne ID: {$campaign['_id']} => Nouvel état: {$newStatus}");
                    $databaseService->updateDocument('campagnes', $campaign['_id'], ['status' => $newStatus]);
                }
            }

            Log::info('✅ Job terminé avec succès !');
        } catch (\Exception $e) {
            Log::error('❌ Erreur dans UpdateCampaignStatusJob : ' . $e->getMessage());
        }
    }
}
