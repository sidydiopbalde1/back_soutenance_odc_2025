<?php
namespace App\Services\Interfaces;

interface IService {
    public function getServices(); // recupere l'ensemble des services
    public function getServiceById($serviceId);// recupere une service pa son id
    public function saveService($serviceData);// creer un service
    public function update($service, array $data); // modifier un service  (update)  // $service : objet service, $data : tableau des nouvelles données du service  // return : objet service modifié  // exemple : $serviceService->update($service, ['name' => 'nouveau nom'])  // exemple : $serviceService->update($service, ['price' => 15.99])  // exemple : $serviceService->
    public function deleteService($serviceId);// supprimer un service
    public function restore($id); // restaurer un service supprimé
}