<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
trait HasPaginationTrait
{
    /**
     * Get the pagination meta information for the resource.
     *
     * @return array
     */
    protected function paginationMeta(): array
    {
        return $this->resource instanceof LengthAwarePaginator ? [
            'total' => $this->resource->total(),
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'per_page' => $this->resource->perPage(),
                'total_pages' => $this->resource->lastPage(),
                'total_items' => $this->resource->total(),
            ],
        ] : [];
    }

    /**
     * Get the pagination links for the resource.
     *
     * @return array
     */
    protected function paginationLinks(): array
    {
        return $this->resource instanceof LengthAwarePaginator ? [
            'first' => $this->resource->url(1),
            'last' => $this->resource->url($this->resource->lastPage()),
            'prev' => $this->resource->previousPageUrl(),
            'next' => $this->resource->nextPageUrl(),
        ] : [];
    }
}
