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
     * @OA\Get(
     *     path="/api/tickets",
     *     summary="Retorna os dados do ticket",
     *     description="Retorna todos os tickets",
     *     tags={"Tickets"},
     *     @OA\Response(
     *         response=200,
     *         description="Array contendo os dados dos tickets",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="ticket_id", type="integer", example=1),
     *                 @OA\Property(property="event_id", type="integer", example=1),
     *                 @OA\Property(property="seller_id", type="integer", example=1),
     *                 @OA\Property(property="ticket_id", type="integer", example=1),
     *                 @OA\Property(property="original_price", type="float", example=100.00),
     *                 @OA\Property(property="status", type="string", example="available"),
     *                 @OA\Property(property="verificatio_code", type="string", example="123456"),
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        // Lista todos os clientes
        $clients = $this->ticketService->getAllTickets();
        return response()->json($clients);
    }

    /**
     * @OA\Post(
     *    path="/api/ticket",
     *    summary="Registra um novo ticket",
     *    description="Registra um novo ticket",
     *    tags={"Tickets"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *                type="object",
     *                  @OA\Property(property="event_id", type="integer", example=1),
     *                  @OA\Property(property="seller_id", type="integer", example=1),
     *                  @OA\Property(property="ticket_id", type="integer", example=1),
     *                  @OA\Property(property="original_price", type="float", example=100.00),
     *                  @OA\Property(property="status", type="string", example="available"),
     *                  @OA\Property(property="verificatio_code", type="string", example="123456"),
     *            )
     *        ),
     *    @OA\Response(
     *        response=201,
     *        description="Ticket registrado com sucesso",
     *        @OA\JsonContent(
     *            type="object",
     *              @OA\Property(property="ticket_id", type="integer", example=1),
     *              @OA\Property(property="event_id", type="integer", example=1),
     *              @OA\Property(property="seller_id", type="integer", example=1),
     *              @OA\Property(property="ticket_id", type="integer", example=1),
     *              @OA\Property(property="original_price", type="float", example=100.00),
     *              @OA\Property(property="status", type="string", example="available"),
     *              @OA\Property(property="verificatio_code", type="string", example="123456"),
     *        ),
     *    ),
     * )
     */
    public function store(Request $request)
    {
        // Cria um novo cliente
        $client = $this->ticketService->createTicket($request->all());

        return response()->json($client, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/ticket/{id}",
     *     summary="Retorna os dados do ticket",
     *     description="Retorna os dados de um ticket",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do ticket",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),

     *     @OA\Response(
     *         response=200,
     *         description="Objeto contendo os dados do domínio e mapeamentos vinculados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="event_id", type="integer", example=1),
     *             @OA\Property(property="seller_id", type="integer", example=1),
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="original_price", type="float", example=100.00),
     *             @OA\Property(property="status", type="string", example="available"),
     *             @OA\Property(property="verificatio_code", type="string", example="123456"),
     *         ),
     *     ),
     * )
     */
    public function show($id)
    {
        // Mostra um cliente específico
        $client = $this->ticketService->getTicketById($id);
        return response()->json($client);
    }

    /**
     * @OA\Put(
     *     path="/api/ticket/{id}",
     *     summary="Atualiza os dados do ticket",
     *     description="Atualiza os dados do ticket",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do ticket",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="ticket_id", type="integer", example=1),
     *              @OA\Property(property="event_id", type="integer", example=1),
     *              @OA\Property(property="seller_id", type="integer", example=1),
     *              @OA\Property(property="ticket_id", type="integer", example=1),
     *              @OA\Property(property="original_price", type="float", example=100.00),
     *              @OA\Property(property="status", type="string", example="available"),
     *              @OA\Property(property="verificatio_code", type="string", example="123456"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objeto contendo os dados do domínio e mapeamentos vinculados",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="ticket_id", type="integer", example=1),
     *              @OA\Property(property="event_id", type="integer", example=1),
     *              @OA\Property(property="seller_id", type="integer", example=1),
     *              @OA\Property(property="ticket_id", type="integer", example=1),
     *              @OA\Property(property="original_price", type="float", example=100.00),
     *              @OA\Property(property="status", type="string", example="available"),
     *              @OA\Property(property="verificatio_code", type="string", example="123456"),
     *         ),
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Ticket não encontrado",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="message", type="string", example="Ticket não encontrado")
     *     )
     *   ),
     * )
     */
    public function update(Request $request, $id)
    {

        // Atualiza o cliente
        $client = $this->ticketService->updateTicket($id, $request->all());

        return response()->json($client);
    }

    /**
     * @OA\Delete(
     *     path="/api/ticket/{id}",
     *     summary="Remove um ticket",
     *     description="Remove um ticket",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do ticket",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket removido com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404,
     *        description="Ticket não encontrado",
     *       @OA\JsonContent(
     *          type="object",
     *         @OA\Property(property="message", type="string", example="Ticket não encontrado")
     *     )
     *   ),
     * )
     */
    public function destroy($id)
    {
        $deleted = $this->ticketService->deleteTicket($id);

        if (!$deleted) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        return response()->json(['message' => 'Cliente deletado com sucesso!']);
    }

    // public function purchaseTicket(Request $request)
    // {
    //     $ticket = $this->ticketService->purchaseTicket($request->input('ticket_id'));

    //     if ($ticket) {
    //         return response()->json(['message' => 'Compra realizada com sucesso!', 'ticket' => $ticket], 200);
    //     }

    //     return response()->json(['message' => 'Erro ao processar pagamento.'], 500);
    // }

    // public function listTicketForSale(Request $request)
    // {
    //     $ticket = $this->ticketService->listTicketForSale($request->all());
    //     return response()->json(['message' => 'Ingresso listado para venda com sucesso!', 'ticket' => $ticket], 201);
    // }

    // public function validateTicket($ticketId)
    // {
    //     $ticket = $this->ticketService->validateTicket($ticketId);

    //     if ($ticket) {
    //         return response()->json(['message' => 'Ingresso válido!', 'ticket' => $ticket], 200);
    //     }

    //     return response()->json(['message' => 'Ingresso inválido ou já utilizado.'], 400);
    // }

    // public function requestRefund($ticketId)
    // {
    //     $ticket = $this->ticketService->requestRefund($ticketId);

    //     if ($ticket) {
    //         return response()->json(['message' => 'Reembolso solicitado com sucesso!', 'ticket' => $ticket], 200);
    //     }

    //     return response()->json(['message' => 'Reembolso não disponível para este ingresso.'], 403);
    // }
}
