<?php

namespace App\Http\Controllers;

use App\Enums\StateEnum;
use App\Services\Campagne\RewardService;
use App\Traits\HasResponseMessageTrait;
use App\Http\Requests\CampagneRequest;
use App\Services\campagne\CampagneService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampagneController extends Controller
{
    use HasResponseMessageTrait;

    protected CampagneService $campagneService;
    protected $rewardService;

    public function __construct(CampagneService $campagneService, RewardService $rewardService)
    {
        $this->campagneService = $campagneService;
        $this->rewardService = $rewardService;
    }

    public function index(Request $request)
    {
        $this->setResponseMessage('Liste des campagnes');
        return $this->campagneService->getAll();
    }

    public function store(Request $request)
    {
        $validated = $request->all();
        $campagne = $this->campagneService->create($validated);
        $this->setResponseMessage('Campagne créée avec succès');
        return $campagne;
    }

    public function show(Request $request, string $id)
    {
        $campagne = $this->campagneService->getById($id);
        if (!$campagne) {
            throw new NotFoundHttpException('Campagne introuvable');
        }
        $this->setResponseMessage('Détails de la campagne');
        return $campagne;
    }

    public function update(CampagneRequest $request, string $id)
    {
        $validated = $request->validated();
        try {
            $this->campagneService->update($id, $validated);
            $this->setResponseMessage('Campagne mise à jour avec succès');
            return [];
        } catch (\Exception $e) {
            return app('App\Services\Responses\RestResponseService')
                ->sendErrorResponse(
                    'Erreur lors de la mise à jour : ' . $e->getMessage(),
                    StateEnum::ERROR,
                    500
                );
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $this->campagneService->delete($id);
            $this->setResponseMessage('Campagne supprimée avec succès');
            return [];
        } catch (\Exception $e) {
            return app('App\Services\Responses\RestResponseService')
                ->sendErrorResponse(
                    'Erreur lors de la suppression : ' . $e->getMessage(),
                    StateEnum::ERROR,
                    500
                );
        }
    }

    // Récupération des campagnes du jour:
    public function campaignsOfTheDay(): JsonResponse
    {
        $campaigns = $this->campagneService->getActiveCampaignsOfTheDay();

        return response()->json([
            'message' => 'Campagnes du jour',
            'campagnes' => $campaigns
        ]);
    }

    // Récupération des transactions et campagnes
    public function processRewards(): JsonResponse
    {
        $data = $this->rewardService->processTransactionsForRewards();

        return response()->json([
            'message' => 'Traitement des récompenses terminés',
            'data' => $data
        ]);
    }

    public function matchTransactionsWithCampaigns(): JsonResponse
    {
        // $data = $this->rewardService->matchTransactionsWhithCampaigns();
        return response()->json([
            $this->rewardService->matchTransactionsWhithCampaigns()
        ]);

        // return response()->json([
        //     'message' => 'Correspondances effectuées',
        //     'data' => $data
        // ]);
    }



}





