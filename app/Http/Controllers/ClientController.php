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
     * @OA\Get(
     *     path="/api/seller/{sellerId}/reviews",
     *     summary="Visualizar Avaliações do Vendedor",
     *     tags={"Seller Reviews"},
     *     @OA\Parameter(
     *         name="sellerId",
     *         in="path",
     *         description="ID do Vendedor",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avaliações retornadas com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Review")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nenhuma avaliação encontrada"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/seller/{sellerId}/rate",
     *     summary="Enviar Avaliação do Vendedor",
     *     tags={"Seller Reviews"},
     *     @OA\Parameter(
     *         name="sellerId",
     *         in="path",
     *         description="ID do Vendedor",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rating", "comment"},
     *             @OA\Property(property="rating", type="integer", description="Nota da avaliação"),
     *             @OA\Property(property="comment", type="string", description="Comentário da avaliação")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Avaliação enviada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="rating", ref="#/components/schemas/Review")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Você não pode avaliar este vendedor"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/user/notification-preferences",
     *     summary="Atualizar Preferências de Notificação",
     *     tags={"Notification Preferences"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"preferences"},
     *             @OA\Property(property="preferences", type="object", description="Preferências de notificação")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferências de notificação atualizadas com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function updateNotificationPreferences(Request $request)
    {
        $user = $this->clientService->updateNotificationPreferences($request->input('preferences'));

        return response()->json(['message' => 'Preferências de notificação atualizadas com sucesso!', 'user' => $user], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user/notification-preferences",
     *     summary="Exibir Preferências de Notificação",
     *     tags={"Notification Preferences"},
     *     @OA\Response(
     *         response=200,
     *         description="Preferências de notificação retornadas com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="preferences", type="object", description="Preferências de notificação")
     *         )
     *     )
     * )
     */
    public function getNotificationPreferences()
    {
        $preferences = $this->clientService->getNotificationPreferences();
        return response()->json(['preferences' => $preferences], 200);
    }
}
