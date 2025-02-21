<?php

namespace App\Services\Responses;

use App\Http\Resources\CampagneCollection;
use App\Http\Resources\CampagneResource;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;

use Exception;

class ResourceMappingService
{
    protected array $resourceMappings = [
        // 'NomDuModel' => ResourceClass::class
        'Campagne' => CampagneResource::class,
        'User' => UserResource::class,
        'Service' => ServiceResource::class,
        'Role' => RoleResource::class,
    ];

    protected array $collectionMappings = [
        // 'NomDuModel' => ResourceCollectionClass::class
        'Campagne' => CampagneCollection::class,
        'User' => UserCollection::class,
        'Service' => ServiceCollection::class,
        'Role' => RoleCollection::class,
    ];

    /**
     * Renvoie la classe Resource à utiliser pour un modèle.
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
     * Renvoie la classe ResourceCollection à utiliser pour un modèle.
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
