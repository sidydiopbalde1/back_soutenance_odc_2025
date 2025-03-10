<?php

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ILog
{
    public function getLogs(int $perPage): LengthAwarePaginator;
    public function logAction(string $action, string $description, string $status): void;
}
