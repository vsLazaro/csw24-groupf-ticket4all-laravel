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

    public function index()
    {
        // Lista todos os clientes
        $clients = $this->ticketService->getAllTickets();
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        // Cria um novo cliente
        $client = $this->ticketService->createTicket($request->all());

        return response()->json($client, 201);
    }

    public function show($id)
    {
        // Mostra um cliente específico
        $client = $this->ticketService->getTicketById($id);
        return response()->json($client);
    }


    public function update(Request $request, $id)
    {

        // Atualiza o cliente
        $client = $this->ticketService->updateTicket($id, $request->all());

        return response()->json($client);
    }

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
