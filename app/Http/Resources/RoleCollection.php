<?php


namespace App\Http\Resources;

use App\Traits\HasPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public $collects = UserResource::class;
    use HasPaginationTrait;
    /**
     * Transforme la collection en tableau.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection, // Utilise automatiquement UserResource pour chaque élément
            'meta' => $this->paginationMeta(),
            'links' => $this->paginationLinks(),
        ];
    }
}

