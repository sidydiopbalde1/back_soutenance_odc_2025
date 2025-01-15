<?php

namespace App\Services\Responses;

use App\Http\Resources\CampagneCollection;
use App\Http\Resources\CampagneResource;
use Exception;

class ResourceMappingService
{
    protected array $resourceMappings = [
        // 'ModelClassName' => ResourceClass::class,
        'Campagne' => CampagneResource::class,
    ];

    protected array $collectionMappings = [
        // 'ModelClassName' => ResourceCollectionClass::class,
        'Campagne' => CampagneCollection::class,
    ];

    /**
     * Retourne la classe Resource à utiliser pour un modèle donné.
     *
     * @throws Exception
     */
    public function getResourceClass(string $modelClass): string
    {
        if (!isset($this->resourceMappings[$modelClass])) {
            throw new Exception("Resource class not found for model: {$modelClass}");
        }

        return $this->resourceMappings[$modelClass];
    }

    /**
     * Retourne la classe ResourceCollection à utiliser pour un modèle donné.
     *
     * @throws Exception
     */
    public function getCollectionClass(string $modelClass): string
    {
        if (!isset($this->collectionMappings[$modelClass])) {
            throw new Exception("Collection class not found for model: {$modelClass}");
        }

        return $this->collectionMappings[$modelClass];
    }
}
