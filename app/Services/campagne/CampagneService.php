<?php

namespace App\Services\campagne;

use App\Services\Interfaces\IDatabase;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampagneService
{
    protected IDatabase $databaseService;

    public function __construct(IDatabase $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * Récupère toutes les campagnes, paginées.
     */
    public function getAll(): LengthAwarePaginator
    {
        // Récupération brute de la collection "campagnes"
        $allCampagnes = $this->databaseService->getCollection('campagnes');

        // Conversion en collection Laravel (si pas déjà un Collection)
        $collection = collect($allCampagnes);

        // Définition des paramètres de pagination
        $perPage = (int) request()->get('per_page', 3);
        $page = (int) request()->get('page', 1);
        $total = $collection->count();

        // Calcul de l'offset et extraction des éléments pour la page courante
        $startingPoint = ($page - 1) * $perPage;
        $currentPageItems = $collection->slice($startingPoint, $perPage)->values();

        // Construction du paginator Laravel
        return new LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    /**
     * Récupère une campagne par son identifiant, ou null si introuvable.
     */
    public function getById(string $id): ?array
    {
        return $this->databaseService->getDocument('campagnes', $id);
    }

    /**
     * Crée une nouvelle campagne et la persiste.
     */
    public function create(array $data): array
    {
        // Génération d'un ID unique, à adapter selon vos contraintes
        $data['_id'] = uniqid();
        $this->databaseService->saveDocument('campagnes', $data['_id'], $data);
        // On retourne les données stockées (vous pourriez filtrer / adapter si besoin)
        return $data;
    }

    /**
     * Met à jour une campagne existante.
     * Lève une exception si l'id n'existe pas.
     */
    public function update(string $id, array $data): bool
    {
        $existing = $this->databaseService->getDocument('campagnes', $id);
        if (!$existing) {
            throw new NotFoundHttpException("Campagne introuvable pour l'ID : $id");
        }

        // Si la campagne existe, on fait l’update
        return $this->databaseService->saveDocument('campagnes', $id, $data);
    }

    /**
     * Supprime une campagne.
     * Lève une exception si l'id n'existe pas.
     */
    public function delete(string $id): bool
    {
        $existing = $this->databaseService->getDocument('campagnes', $id);
        if (!$existing) {
            throw new NotFoundHttpException("Campagne introuvable pour l'ID : $id");
        }
        // Si elle existe, on procède à la suppression
        return $this->databaseService->deleteDocument('campagnes', $id);
    }

    public function getActiveCampaignsOfTheDay()
    {
        $allCampagnes = collect($this->databaseService->getCollection('campagnes'));

        // Filtrer les campagnes actives du jour
        $today = Carbon::today();   

        $activeCampaigns = $allCampagnes->filter(function ($campagne) use ($today) {
            $startDate = Carbon::parse($campagne['dateStart']);
            $endDate = Carbon::parse($campagne['dateEnd']);
            return $campagne['status'] === 'en cours' && $today->between($startDate, $endDate);
        });

        // Grouper par code de service:
        return $activeCampaigns->groupBy(function ($campagne) {
            return collect($campagne['services'])->pluck('code')->first();
        });
    }
}


