<?php

namespace App\Repository\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ILogRepository
{
    public function createLog(array $data);
    public function getAllLogs(int $perPage): LengthAwarePaginator;
}
