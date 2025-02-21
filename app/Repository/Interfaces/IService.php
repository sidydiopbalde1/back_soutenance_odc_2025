<?php
namespace App\Repository\Interfaces;
interface IService {
    public function getAllServices();
    public function getServiceById($serviceId);
    public function saveService($serviceData);
    public function update($service, array $data);  
    public function deleteService($serviceId);
    public function restore($id);
}