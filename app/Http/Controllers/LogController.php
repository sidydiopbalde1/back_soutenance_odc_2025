<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\HasPaginationTrait;
use App\Traits\HasResponseMessageTrait;
use App\Services\Logs\LogService;
use Exception;

class LogController extends Controller
{
    use HasPaginationTrait, HasResponseMessageTrait;

    private LogService $logService;
    private $resource;


    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Liste des logs avec pagination.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Récupérer les logs avec pagination
            $logs = $this->logService->getLogs($request->query('per_page', 20));

            $this->resource = $logs; 

            // Loguer l'action
            $user = auth()->user();
            $this->logService->logAction(
                'Consultation logs',
                'L\'utilisateur ' . $user->nom . ' ' . $user->prenom . ' a consulté les logs le ' . now()->format('d-m-Y H:i:s'),
                'success'
            );

            // Retourner la réponse avec pagination
            return response()->json([
                'message' => 'Liste des logs récupérée avec succès.',
                'logs' => $logs->items(),
                'pagination' => $this->paginationMeta(),
                'links' => $this->paginationLinks(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des logs.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
