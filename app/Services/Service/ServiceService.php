<?php
namespace App\Services\Service;
use App\Repository\Services\ServiceRepository;
use App\Services\Interfaces\IService;

class ServiceService implements IService{
    private $serviceRepository;
    public function __construct(ServiceRepository $serviceRepository){
        $this->serviceRepository = $serviceRepository;
    }
    
    public function getServices()
    {
        return $this->serviceRepository->getAllServices();
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
