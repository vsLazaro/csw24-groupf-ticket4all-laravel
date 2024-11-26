<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Review; // Supondo que exista um modelo Review para as avaliações
use App\Models\NotificationPreference; // Supondo que exista um modelo NotificationPreference para as preferências de notificação

class ClientRepositoryImpl implements ClientRepository
{
    public function getAll()
    {
        return Client::all();
    }

    public function findById($id)
    {
        return Client::find($id);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function update($id, array $data)
    {
        $client = Client::find($id);

        if ($client) {
            $client->update($data);
        }

        return $client;
    }

    public function delete($id)
    {
        $client = Client::find($id);

        if ($client) {
            return $client->delete();
        }

        return false;
    }

}
