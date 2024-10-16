<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Visualizar Avaliações do Vendedor
     */
    public function showSellerReviews($sellerId)
    {
        $reviews = $this->clientService->getSellerReviews($sellerId);

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'Nenhuma avaliação encontrada para este vendedor.'], 404);
        }

        return response()->json(['reviews' => $reviews], 200);
    }

    /**
     * Enviar Avaliação do Vendedor
     */
    public function rateSeller(Request $request, $sellerId)
    {
        $rating = $this->clientService->rateSeller($sellerId, $request->all());

        if (!$rating) {
            return response()->json(['message' => 'Você não pode avaliar este vendedor.'], 403);
        }

        return response()->json(['message' => 'Avaliação enviada com sucesso!', 'rating' => $rating], 201);
    }

    /**
     * Atualizar Preferências de Notificação
     */
    public function updateNotificationPreferences(Request $request)
    {
        $user = $this->clientService->updateNotificationPreferences($request->input('preferences'));

        return response()->json(['message' => 'Preferências de notificação atualizadas com sucesso!', 'user' => $user], 200);
    }

    /**
     * Exibir Preferências de Notificação
     */
    public function getNotificationPreferences()
    {
        $preferences = $this->clientService->getNotificationPreferences();
        return response()->json(['preferences' => $preferences], 200);
    }
}
