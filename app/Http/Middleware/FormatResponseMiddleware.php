<?php

namespace App\Http\Middleware;

use App\Enums\StateEnum;
use App\Services\Responses\ResourceMappingService;
use App\Services\Responses\RestResponseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class FormatResponseMiddleware
{
    protected RestResponseService $responseService;
    protected ResourceMappingService $resourceMappingService;

    public function __construct(
        RestResponseService    $responseService,
        ResourceMappingService $resourceMappingService
    ) {
        $this->responseService = $responseService;
        $this->resourceMappingService = $resourceMappingService;
    }

    public function handle(Request $request, Closure $next)
    {
        /** @var Response|JsonResponse $response */
        $response = $next($request);

        if (!$response instanceof JsonResponse) {
            Log::debug('[MIDDLEWARE] Pas un JsonResponse => renvoi tel quel', [
                'response_class' => get_class($response)
            ]);
            return $response;
        }

        // Vérifier le code HTTP pour éviter de reformater les erreurs
        if ($response->getStatusCode() !== 200) {
            Log::debug('[MIDDLEWARE] Réponse avec code non 200, renvoi tel quel', [
                'status' => $response->getStatusCode()
            ]);
            return $response;
        }

        // Vérifier si la réponse a déjà été formatée
        $originalContent = $response->getOriginalContent();
        if (
            is_array($originalContent) &&
            (
                (isset($originalContent['data'], $originalContent['status'], $originalContent['message'])) ||
                (isset($originalContent['content']) &&
                    is_array($originalContent['content']) &&
                    isset($originalContent['content']['data'], $originalContent['content']['status'], $originalContent['content']['message']))
            )
        ) {
            Log::debug('[MIDDLEWARE] Contenu déjà formaté, renvoi tel quel');
            return $response;
        }

        Log::debug('[MIDDLEWARE] Contenu original', [
            'content' => $originalContent
        ]);

        // Transformation du contenu si nécessaire
        $resource = $originalContent;
        if ($originalContent instanceof Model) {
            Log::debug('[MIDDLEWARE] Contenu = Model Eloquent', [
                'model_class' => get_class($originalContent)
            ]);
            try {
                $modelClass = class_basename($originalContent);
                $resourceClass = $this->resourceMappingService->getResourceClass($modelClass);
                $resource = new $resourceClass($originalContent);
                Log::debug('[MIDDLEWARE] Model transformé via Resource', [
                    'resource_class' => $resourceClass
                ]);
            } catch (\Exception $e) {
                Log::warning('[MIDDLEWARE] Erreur lors de la transformation du Model', [
                    'error' => $e->getMessage()
                ]);
            }
        } elseif ($originalContent instanceof Collection || $originalContent instanceof LengthAwarePaginator) {
            Log::debug('[MIDDLEWARE] Contenu = Collection / Paginator', [
                'collection_count' => $originalContent->count()
            ]);
            try {
                $firstItem = $originalContent->first();
                if (!$firstItem) {
                    Log::debug('[MIDDLEWARE] Collection vide, aucune transformation par Resource');
                    $resource = $originalContent;
                } else {
                    $firstItemClass = class_basename($firstItem);
                    $collectionClass = $this->resourceMappingService->getCollectionClass($firstItemClass);
                    $resource = new $collectionClass($originalContent);
                    Log::debug('[MIDDLEWARE] Collection transformée via ResourceCollection', [
                        'collection_class' => $collectionClass
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('[MIDDLEWARE] Erreur lors de la transformation de la Collection', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        $message = $request->attributes->get('responseMessage', 'Opération réussie');
        Log::debug('[MIDDLEWARE] Préparation de la réponse finale', [
            'final_message' => $message,
            'resource_type' => is_object($resource) ? get_class($resource) : gettype($resource)
        ]);

        return $this->responseService->sendResponse(
            $resource,
            StateEnum::SUCCESS,
            $message
        );
    }
}
