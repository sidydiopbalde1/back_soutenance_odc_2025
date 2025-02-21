<?php

namespace App\Repository\Services;

use App\Models\Service;
use App\Repository\Interfaces\IService;

class ServiceRepository implements IService
{
    public function getAllServices()
    {
        return Service::paginate(5);
    }
    public function getServiceById($serviceId)
    {
        return Service::find($serviceId);
    }
    public function saveService($serviceData)
    {
        $service = Service::create($serviceData);
        return $service;
    }
    public function update($service, array $data)
    {
        $service->update($data);
        return $service;
    }
    public function deleteService($serviceId)
    {
        $service = Service::find($serviceId);
        if ($service) {
            $service->delete();
            return true;
        }
        return false;
    }
    public function restore($id)
    {
        $service = Service::withTrashed()->find($id);
        if ($service) {
            $service->restore();
            return true;
        }
        return false;
    }
}
