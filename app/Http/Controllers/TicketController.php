<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * @OA\Post(
     *     path="/api/tickets/purchase",
     *     summary="Comprar Ingresso",
     *     tags={"Tickets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ticket_id"},
     *             @OA\Property(property="ticket_id", type="integer", description="ID do ingresso a ser comprado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Compra realizada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="ticket", ref="#/components/schemas/Ticket")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao processar pagamento"
     *     )
     * )
     */
    public function purchaseTicket(Request $request)
    {
        $ticket = $this->ticketService->purchaseTicket($request->input('ticket_id'));

        if ($ticket) {
            return response()->json(['message' => 'Compra realizada com sucesso!', 'ticket' => $ticket], 200);
        }

        return response()->json(['message' => 'Erro ao processar pagamento.'], 500);
    }

    /**
     * @OA\Post(
     *     path="/api/tickets/list-for-sale",
     *     summary="Listar Ingresso para Venda",
     *     tags={"Tickets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ticket_id", "price"},
     *             @OA\Property(property="ticket_id", type="integer", description="ID do ingresso a ser listado para venda"),
     *             @OA\Property(property="price", type="number", format="float", description="Preço de venda do ingresso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ingresso listado para venda com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="ticket", ref="#/components/schemas/Ticket")
     *         )
     *     )
     * )
     */
    public function listTicketForSale(Request $request)
    {
        $ticket = $this->ticketService->listTicketForSale($request->all());
        return response()->json(['message' => 'Ingresso listado para venda com sucesso!', 'ticket' => $ticket], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tickets/{ticketId}/validate",
     *     summary="Validar Ingresso no Evento",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         description="ID do ingresso a ser validado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ingresso válido",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="ticket", ref="#/components/schemas/Ticket")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Ingresso inválido ou já utilizado"
     *     )
     * )
     */
    public function validateTicket($ticketId)
    {
        $ticket = $this->ticketService->validateTicket($ticketId);

        if ($ticket) {
            return response()->json(['message' => 'Ingresso válido!', 'ticket' => $ticket], 200);
        }

        return response()->json(['message' => 'Ingresso inválido ou já utilizado.'], 400);
    }

    /**
     * @OA\Post(
     *     path="/api/tickets/{ticketId}/refund",
     *     summary="Solicitar Reembolso de Ingresso",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         description="ID do ingresso para o qual o reembolso será solicitado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reembolso solicitado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="ticket", ref="#/components/schemas/Ticket")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Reembolso não disponível para este ingresso"
     *     )
     * )
     */
    public function requestRefund($ticketId)
    {
        $ticket = $this->ticketService->requestRefund($ticketId);

        if ($ticket) {
            return response()->json(['message' => 'Reembolso solicitado com sucesso!', 'ticket' => $ticket], 200);
        }

        return response()->json(['message' => 'Reembolso não disponível para este ingresso.'], 403);
    }
}
