<?php

namespace App\Repositories;

interface ClientRepository
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    // Novos métodos adicionados
    public function getSellerReviews($sellerId);
    public function rateSeller($sellerId, array $data);
    public function updateNotificationPreferences(array $preferences);
    public function getNotificationPreferences();
    public function canRateSeller($sellerId, $userId); // Método para verificar se o usuário pode avaliar
}
