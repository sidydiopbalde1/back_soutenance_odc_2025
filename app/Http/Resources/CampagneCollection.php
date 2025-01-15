<?php

namespace App\Http\Resources;

use App\Traits\HasPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CampagneCollection extends ResourceCollection
{
    public $collects = CampagneResource::class;
    use HasPaginationTrait;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'articles' => $this->collection,
            'meta' => $this->paginationMeta(),
            'links' => $this->paginationLinks(),
        ];
    }
}
