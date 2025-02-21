<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Service\ServiceService;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Traits\HasResponseMessageTrait;


class ServiceController extends Controller
{
    use HasResponseMessageTrait;
    // Constructeur pour injecter le service
    private $serviceService;
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }
    public function index()
    {
        $services = $this->serviceService->getServices();
        if (!$services) {
            $this->setResponseMessage("Aucun service trouvé");
            return [];
        }
        $this->setResponseMessage("Liste des services");
        return $services;
    }
    public function store(StoreServiceRequest $request)
    {
        $serviceData = $request->validated();

        $service = $this->serviceService->saveService($serviceData);
        if (!$service) {
            $this->setResponseMessage("Erreur lors de la création du service");
            return [];
        }

        $this->setResponseMessage("Service créé avec succès");
        return $service;
    }
    public function show($id)
    {
        // Récupération d'un service par son ID
        $service = $this->serviceService->getServiceById($id);
        if (!$service) {
            $this->setResponseMessage("Service introuvable");
            return []; // Retour d'un tableau vide en cas d'échec de la récupération du service
        }
        $this->setResponseMessage("Service trouvé");
        return $service; // Retour du service
    }
    public function update(UpdateServiceRequest $request, $id)
    {
        $serviceData = $request->validated();

        $service = $this->serviceService->update($id, $serviceData);
        if (!$service) {
            $this->setResponseMessage("Erreur lors de la modification du service");
            return [];
        }

        $this->setResponseMessage("Service modifié avec succès");
        return $service;
    }
    public function destroy($id)
    {
        // Suppression d'un service
        $success = $this->serviceService->deleteService($id);
        if (!$success) {
            $this->setResponseMessage("Erreur lors de la suppression du service");
            return []; // Retour d'un tableau vide en cas d'échec de la suppression du service
        }
        $this->setResponseMessage("Service supprimé avec succès");
        return []; // Retour d'un tableau vide en cas de succès de la suppression du service
    }

    public function restore($id)
    {
        // Restauration d'un service
        $success = $this->serviceService->restore($id);

        if (!$success) {
            $this->setResponseMessage("Erreur lors de la restauration du service");
            return []; // Retour d'un tableau vide en cas d'échec
        }

        $this->setResponseMessage("Service restauré avec succès");
        return $this->serviceService->getServiceById($id);
    }
}
