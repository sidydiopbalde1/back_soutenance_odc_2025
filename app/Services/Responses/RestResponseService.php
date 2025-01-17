<?php

namespace App\Services\Responses;

use App\Enums\StateEnum;
use Illuminate\Http\JsonResponse;

class RestResponseService
{
    public function sendResponse(
        mixed $data,
        StateEnum $status = StateEnum::SUCCESS,
        string $message = 'Opération réussie',
        int $codeStatut = 200
    ): JsonResponse {
        if (
            is_array($data) &&
            isset($data['data'], $data['status'], $data['message'])
        ) {
            return response()->json($data, $codeStatut);
        }

        return response()->json([
            'data'    => $data,
            'status'  => $status->value,
            'message' => $message,
        ], $codeStatut);
    }

    public function sendErrorResponse(
        string $message,
        StateEnum $status = StateEnum::ERROR,
        int $codeStatut = 500
    ): JsonResponse {
        return $this->sendResponse(null, $status, $message, $codeStatut);
    }
}
