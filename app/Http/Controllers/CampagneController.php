<?php

namespace App\Http\Controllers;

use App\Enums\StateEnum;
use App\Traits\HasResponseMessageTrait;
use App\Http\Requests\CampagneRequest;
use App\Services\campagne\CampagneService;
use App\Services\Responses\RestResponseService;
use Illuminate\Http\Request;

class CampagneController extends Controller
{
    use HasResponseMessageTrait;

    protected CampagneService $campagneService;
    protected RestResponseService $restResponseService;

    public function __construct(
        CampagneService $campagneService,
        RestResponseService $restResponseService
    ) {
        $this->campagneService = $campagneService;
        $this->restResponseService = $restResponseService;
    }

    public function index(Request $request)
    {
        $this->setResponseMessage('Liste des campagnes');
        return $this->campagneService->getAll();
    }

    public function store(CampagneRequest $request)
    {
        $validated = $request->validated();

        $newCampagne = $this->campagneService->create($validated);

        $this->setResponseMessage('Campagne créée avec succès');
        return $newCampagne;
    }

    public function show(Request $request, string $id)
    {
        $campagne = $this->campagneService->getById($id);
        if (!$campagne) {
            // Au lieu de `response()->json(...)`, on peut faire :
            return $this->restResponseService->sendErrorResponse(
                'Campagne introuvable',
                StateEnum::NOT_FOUND,
                404
            );
        }

        $this->setResponseMessage('Détails de la campagne');
        return $campagne;
    }

    public function update(CampagneRequest $request, string $id)
    {
        try {
            $this->campagneService->update($id, $request->validated());
            $this->setResponseMessage('Campagne mise à jour avec succès');
            return [];
        } catch (\Exception $e) {
            return $this->restResponseService->sendErrorResponse(
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
            return $this->restResponseService->sendErrorResponse(
                'Erreur lors de la suppression : ' . $e->getMessage(),
                StateEnum::ERROR,
                500
            );
        }
    }
}
