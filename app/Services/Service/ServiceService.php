<?php
namespace App\Services\Service;
use App\Repository\Services\ServiceRepository;
use App\Services\Interfaces\IService;
use App\Services\Logs\LogService;
use Illuminate\Support\Facades\Auth;

class ServiceService implements IService{
    private $serviceRepository;
    private LogService $logService;
    public function __construct(ServiceRepository $serviceRepository, LogService $logService){
        $this->serviceRepository = $serviceRepository;
        $this->logService = $logService;
    }
    
    public function getServices()
    {
        $connectUser = Auth::user();
        $services = $this->serviceRepository->getAllServices();
        if (!$services) {
            $this->logService->logAction(
                'List services',
                "Aucun service n'a été trouvé",
                'warning'
            );
            return [];
         }
         $this->logService->logAction(
            'List Services',
            "{$connectUser->nom} {$connectUser->prenom} a listé les services avec succès le " . now()->format('d-m-Y H:i:s'),
            'success'
        );
        return $services;
    }
    public function getServiceById($serviceId)
    {
        return $this->serviceRepository->getServiceById($serviceId);
    }
    public function saveService($serviceData)
    {
        return $this->serviceRepository->saveService($serviceData);
    }
    public function deleteService($serviceId)
    {
        return $this->serviceRepository->deleteService($serviceId);
    }
    public function update($service, array $data){
        return $this->serviceRepository->update($service, $data);
    }
    public function restore($id){
        return $this->serviceRepository->restore($id);
    }

}
