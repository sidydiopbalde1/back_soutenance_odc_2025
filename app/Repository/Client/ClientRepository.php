<?php
namespace App\Repository\Client;
use App\Models\Client;
use \App\Repository\Interfaces\IClient;

class ClientRepository implements IClient
{
    public function getClientById($clientId)
    {
        return Client::find($clientId);
    }
}