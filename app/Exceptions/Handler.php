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
use App\Services\Logs\LogService;

class Handler extends ExceptionHandler
{
    protected RestResponseService $restResponseService;
    protected LogService $logService;

    public function __construct(RestResponseService $restResponseService, LogService $logService)
    {
        parent::__construct(app());
        $this->restResponseService = $restResponseService;
        $this->logService = $logService;
    }

    public function render($request, Throwable $e)
    {
        // Gestion des erreurs spécifiques
        if ($e instanceof ValidationException) {
            $message = 'Erreur de validation';
            $state = StateEnum::VALIDATION_ERROR;
            $statusCode = 422;
        } elseif ($e instanceof AuthenticationException) {
            $message = 'Erreur d’authentification';
            $state = StateEnum::UNAUTHORIZED;
            $statusCode = 401;
        } elseif ($e instanceof AuthorizationException) {
            $message = 'Accès refusé';
            $state = StateEnum::ERROR;
            $statusCode = 403;
        } elseif ($e instanceof NotFoundHttpException) {
            $message = 'Ressource introuvable';
            $state = StateEnum::NOT_FOUND;
            $statusCode = 404;
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $message = 'Méthode non autorisée';
            $state = StateEnum::ERROR;
            $statusCode = 405;
        } elseif ($e instanceof TooManyRequestsHttpException) {
            $message = 'Trop de requêtes. Veuillez réessayer plus tard.';
            $state = StateEnum::ERROR;
            $statusCode = 429;
        } elseif ($e instanceof HttpException) {
            $message = $e->getMessage() ?? 'Une erreur HTTP est survenue';
            $state = StateEnum::ERROR;
            $statusCode = $e->getStatusCode();
        } else {
            $message = $e->getMessage() ?? 'Une erreur interne est survenue';
            $state = StateEnum::ERROR;
            $statusCode = 500;
        }

        // Enregistrement du log avec conversion explicite de Enum
        $this->logService->logAction(
            'Exception',
            $message,
            $state->value, // Convertir l'Enum en string
            [
                'status_code' => $statusCode,
                'ip' => request()->ip(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
            ]
        );

        return $this->restResponseService->sendResponse(
            null,
            $state, 
            $message,
            $statusCode
        );
        
    }
}
