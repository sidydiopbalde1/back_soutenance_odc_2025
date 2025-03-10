<?php

namespace App\Repository\Logs;

use App\Models\Log;
use App\Repository\Interfaces\ILogRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class LogRepository implements ILogRepository
{
    public function createLog(array $data)
    {
        return Log::create($data);
    }

    // public function getAllLogs(int $perPage): LengthAwarePaginator
    // {
    //     return DB::table('logs')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($perPage);
    // }
    public function getAllLogs(int $perPage): LengthAwarePaginator
{
    return Log::query()
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
}


}



    
