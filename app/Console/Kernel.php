<?php

namespace App\Console;
use App\Jobs\ProcessRewardsJob;
use App\Jobs\UpdateCampaignStatusJob;
use App\Services\Campagne\RewardService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    // php artisan schedule:run

    protected function schedule(Schedule $schedule)
    {
        // $schedule->job(new UpdateCampaignStatusJob())->everyMinute();


        // Utilisation de app() pour obtenir le service:
        $rewardService = app(RewardService::class);
        $transactionsCampaigns = $rewardService->matchTransactionsWhithCampaigns();
        // $transactionsCampaigns = [];




        // Vérification si $transactionsCampaigns est vide
        if (empty($transactionsCampaigns)) {
            Log::info('Aucune transaction de campagne à traiter.');
        } else {
            $schedule->job(new ProcessRewardsJob($transactionsCampaigns))->everyMinute();
        }

    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
