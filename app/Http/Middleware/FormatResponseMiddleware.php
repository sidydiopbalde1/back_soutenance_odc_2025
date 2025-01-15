<?php

namespace App\Http\Middleware;

use App\enums\StateEnum;
use App\Services\Responses\ResourceMappingService;
use App\Services\Responses\RestResponseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FormatResponseMiddleware
{
    protected RestResponseService $responseService;
    protected ResourceMappingService $resourceMappingService;

    public function __construct(
        RestResponseService $responseService,
        ResourceMappingService $resourceMappingService
    ) {
        $this->responseService = $responseService;
        $this->resourceMappingService = $resourceMappingService;
    }

    public function handle(Request $request, Closure $next)
    {
        /** @var \Illuminate\Http\Response|\Illuminate\Http\JsonResponse $response */
        $response = $next($request);

        // Si la réponse n’est pas un JsonResponse, on ne fait rien de particulier
        if (!$response instanceof JsonResponse) {
            \Log::debug('[MIDDLEWARE] Pas un JsonResponse => on renvoie tel quel', [
                'response_class' => get_class($response)
            ]);
            return $response;
        }

        $originalContent = $response->getOriginalContent();

        // Vérifier si c'est déjà au format { data, status, message }
        if (is_array($originalContent)
            && isset($originalContent['data'])
            && isset($originalContent['status'])
            && isset($originalContent['message'])) {
            \Log::debug('[MIDDLEWARE] Déjà au bon format => on renvoie tel quel');
            return $response;
        }

        // 2) Gérer le cas Model / Collection
        $resource = $originalContent;

        if ($originalContent instanceof Model) {
            try {
                $modelClass = class_basename($originalContent);
                $resourceClass = $this->resourceMappingService->getResourceClass($modelClass);
                $resource = new $resourceClass($originalContent);

                \Log::debug('[MIDDLEWARE] Model détecté, transformé via Resource', [
                    'model_class' => $modelClass,
                    'resource_class' => $resourceClass
                ]);
            } catch (\Exception $e) {
                \Log::warning('[MIDDLEWARE] Pas de resource class trouvée ou erreur', [
                    'error' => $e->getMessage()
                ]);
            }
        } elseif ($originalContent instanceof Collection || $originalContent instanceof LengthAwarePaginator) {
            try {
                $firstItemClass = $originalContent->first()
                    ? class_basename($originalContent->first())
                    : null;

                $collectionClass = $this->resourceMappingService->getCollectionClass($firstItemClass);
                $resource = new $collectionClass($originalContent);

                \Log::debug('[MIDDLEWARE] Collection/Paginator détecté, transformé via ResourceCollection', [
                    'first_item_class' => $firstItemClass,
                    'collection_class' => $collectionClass
                ]);
            } catch (\Exception $e) {
                \Log::warning('[MIDDLEWARE] Pas de collection class trouvée ou erreur', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // 3) Récupérer un message custom défini dans la requête
        // Sinon, on utilise 'Opération réussie' par défaut
        $message = $request->attributes->get('responseMessage', 'Opération réussie');

        \Log::debug('[MIDDLEWARE] Avant sendResponse', [
            'final_message' => $message
        ]);

        // 4) Retour via RestResponseService
        return $this->responseService->sendResponse(
            $resource,
            StateEnum::SUCCESS,
            $message
        );
    }
}
