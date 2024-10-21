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

    // Implementação dos novos métodos

    /**
     * Obter avaliações de um vendedor
     */
    public function getSellerReviews($sellerId)
    {
        return Review::where('seller_id', $sellerId)->get(); // Supondo que o campo seja 'seller_id' no modelo de Review
    }

    /**
     * Avaliar um vendedor
     */
    public function rateSeller($sellerId, array $data)
    {
        // Aqui, criamos uma nova avaliação associada ao vendedor
        return Review::create([
            'seller_id' => $sellerId,
            'user_id' => $data['user_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
    }

    /**
     * Verificar se o usuário pode avaliar o vendedor
     */
    public function canRateSeller($sellerId, $userId)
    {
        // Exemplo simples: verificar se o usuário já fez uma compra ou se já avaliou o vendedor anteriormente
        // Isso pode depender de como sua lógica de negócios está estruturada
        $alreadyRated = Review::where('seller_id', $sellerId)
            ->where('user_id', $userId)
            ->exists();

        return !$alreadyRated; // Permite avaliar se não houver uma avaliação anterior
    }

    /**
     * Atualizar preferências de notificação
     */
    public function updateNotificationPreferences(array $preferences)
    {
        // Atualiza as preferências de notificação do usuário logado (pode usar auth()->user() ou passar o user_id no $preferences)
        $user = auth()->user();
        $notificationPreferences = NotificationPreference::where('user_id', $user->id)->first();

        if ($notificationPreferences) {
            $notificationPreferences->update($preferences);
        } else {
            $notificationPreferences = NotificationPreference::create([
                'user_id' => $user->id,
                'preferences' => json_encode($preferences)
            ]);
        }

        return $notificationPreferences;
    }

    /**
     * Obter preferências de notificação
     */
    public function getNotificationPreferences()
    {
        $user = auth()->user(); // Supondo que o usuário está autenticado
        return NotificationPreference::where('user_id', $user->id)->first();
    }
}
