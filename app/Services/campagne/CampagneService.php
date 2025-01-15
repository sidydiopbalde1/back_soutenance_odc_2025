<?php
namespace App\Services\campagne;

use App\Services\Interfaces\IDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class CampagneService
{
    protected IDatabase $databaseService;

    public function __construct(IDatabase $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function getAll(): LengthAwarePaginator
    {
        // Récupérer tous les documents de la collection 'campagnes'
        $allCampagnes = $this->databaseService->getCollection('campagnes');

        // Convertir en collection Laravel (si ce n'est pas déjà le cas)
        $collection = collect($allCampagnes);

        // Définir les paramètres de pagination
        $perPage = request()->get('per_page', 3); // Par défaut 10 par page, ajustez selon vos besoins
        $page = request()->get('page', 1);
        $total = $collection->count();

        // Calculer l'offset et extraire les éléments pour la page courante
        $startingPoint = ($page - 1) * $perPage;
        $currentPageItems = $collection->slice($startingPoint, $perPage)->values();

        // Créer le paginator
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

    public function getById(string $id): ?array
    {
        return $this->databaseService->getDocument('campagnes', $id);
    }

    public function create(array $data): array
    {
        $data['_id'] = uniqid();
        Log::info('Création de campagne avec données : ', $data);

        $success = $this->databaseService->saveDocument('campagnes', $data['_id'], $data);

        // On peut retourner le tableau complet si $success == true
        // ou lever une exception si $success == false
        // Pour simplifier, disons qu’on renvoie le tableau dans tous les cas
        return $data;
    }



    public function update(string $id, array $data): bool
    {
        Log::info('Mise à jour de la campagne : ', ['id' => $id, 'data' => $data]);

        return $this->databaseService->saveDocument('campagnes', $id, $data);
    }

    public function delete(string $id): bool
    {
        Log::info('Suppression de la campagne avec ID : ' . $id);

        return $this->databaseService->deleteDocument('campagnes', $id);
    }
}
