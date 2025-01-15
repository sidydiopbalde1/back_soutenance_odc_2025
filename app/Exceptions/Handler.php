<?php

namespace App\Exceptions;

use App\enums\StateEnum;
use App\Services\Responses\RestResponseService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected RestResponseService $restResponseService;

    public function __construct(RestResponseService $restResponseService)
    {
        // Important: on appelle le parent avec app() si on a besoin du conteneur
        parent::__construct(app());
        $this->restResponseService = $restResponseService;
    }

    public function render($request, Throwable $e)
    {
        // Gestion des exceptions de Validation
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return $this->restResponseService->sendResponse(
                $e->errors(),
                StateEnum::VALIDATION_ERROR,
                'Erreur de validation',
                422
            );
        }

        // Erreur d’authentification
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::UNAUTHORIZED,
                'Erreur d’authentification',
                401
            );
        }

        // Ressource non trouvée
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::NOT_FOUND,
                'Ressource introuvable',
                404
            );
        }

        // Cas général
        return $this->restResponseService->sendResponse(
            null,
            StateEnum::ERROR,
            $e->getMessage(),
            500
        );
    }
}
