<?php

namespace App\Exceptions;

use App\Enums\StateEnum;
use App\Services\Responses\RestResponseService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected RestResponseService $restResponseService;

    public function __construct(RestResponseService $restResponseService)
    {
        parent::__construct(app());
        $this->restResponseService = $restResponseService;
    }

    public function render($request, Throwable $e)
    {
        // Gestion des erreurs de validation
        if ($e instanceof ValidationException) {
            return $this->restResponseService->sendResponse(
                $e->errors(),
                StateEnum::VALIDATION_ERROR,
                'Erreur de validation',
                422
            );
        }

        // Erreur d'authentification
        if ($e instanceof AuthenticationException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::UNAUTHORIZED,
                'Erreur d’authentification',
                401
            );
        }

        // Autorisation refusée
        if ($e instanceof AuthorizationException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::ERROR,
                'Accès refusé',
                403
            );
        }

        // Ressource non trouvée
        if ($e instanceof NotFoundHttpException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::NOT_FOUND,
                'Ressource introuvable',
                404
            );
        }

        // Méthode HTTP non autorisée
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::ERROR,
                'Méthode non autorisée',
                405
            );
        }

        // Trop de requêtes (Rate Limiting)
        if ($e instanceof TooManyRequestsHttpException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::ERROR,
                'Trop de requêtes. Veuillez réessayer plus tard.',
                429
            );
        }

        // Autres exceptions HTTP générales
        if ($e instanceof HttpException) {
            return $this->restResponseService->sendResponse(
                null,
                StateEnum::ERROR,
                $e->getMessage(),
                $e->getStatusCode()
            );
        }

        // Clause générique pour toutes les autres exceptions
        return $this->restResponseService->sendResponse(
            null,
            StateEnum::ERROR,
            $e->getMessage(),
            500
        );
    }
}
