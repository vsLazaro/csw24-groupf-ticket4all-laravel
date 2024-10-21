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

    /**
     * Obter Avaliações do Vendedor
     */
    public function getSellerReviews($sellerId)
    {
        // Aqui você chamaria o método correspondente no repositório para obter as avaliações do vendedor
        return $this->clientRepository->getSellerReviews($sellerId);
    }

    /**
     * Avaliar Vendedor
     */
    public function rateSeller($sellerId, $data)
    {
        // Logica de verificação se o usuário pode avaliar o vendedor
        $canRate = $this->clientRepository->canRateSeller($sellerId, $data['user_id']);
        if ($canRate) {
            // Envia a avaliação para o repositório
            return $this->clientRepository->rateSeller($sellerId, $data);
        }

        return false;
    }

    /**
     * Atualizar Preferências de Notificação
     */
    public function updateNotificationPreferences($preferences)
    {
        // Atualiza as preferências de notificação do usuário
        return $this->clientRepository->updateNotificationPreferences($preferences);
    }

    /**
     * Obter Preferências de Notificação
     */
    public function getNotificationPreferences()
    {
        // Obtém as preferências de notificação do usuário
        return $this->clientRepository->getNotificationPreferences();
    }
}
