<?php

use App\Jobs\ProcessRewardsJob;
use App\Mail\TestMail;
use App\Services\Campagne\RewardService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/launch-rewards-job', function (RewardService $rewardService) {
    $transactionsCampaigns = $rewardService->matchTransactionsWhithCampaigns();

    // Vérification si $transactionsCampaigns est vide
    if (empty($transactionsCampaigns)) {
        Log::info('Aucune transaction de campagne à traiter.');
        return response()->json([
            'status' => 'error',
            'message' => 'Aucune transaction de campagne à traiter.'
        ], 400);
    }

    // Lancer le job
    dispatch(new ProcessRewardsJob($transactionsCampaigns));

    return response()->json([
        'status' => 'success',
        'message' => 'Job ProcessRewardsJob lancé avec succès.'
    ]);


});

// Simulation campagnes et transactions du jour
// $transactionsCampaigns = [
//     [

//         'campaign' => [
//             'libelle' => 'Tabaski',
//             'rewards' => [
//                 [
//                     'id' => 'remiseFrais.pourcentage',
//                     'name' => 'Pourcentage de remise',
//                     'value' => [
//                         'percentage' => '5',
//                         'cappedAmount' => '1000'
//                     ]
//                 ]
//             ],
//         ],

//         'transactions' => [
//             [
//                 'id' => 1,
//                 'sender_msisdn_id' => 1
//             ]
//         ],


//     ]
// ];
