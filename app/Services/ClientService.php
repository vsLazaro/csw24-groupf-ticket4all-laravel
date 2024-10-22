<?php

namespace App\Services;

use App\Repositories\ClientRepository;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAllClients()
    {
        return $this->clientRepository->getAll();
    }

    public function getClientById($id)
    {
        return $this->clientRepository->findById($id);
    }

    public function createClient($data)
    {
        return $this->clientRepository->create($data);
    }

    public function updateClient($id, $data)
    {
        return $this->clientRepository->update($id, $data);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->delete($id);
    }
}
