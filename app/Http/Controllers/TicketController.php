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
     * Comprar Ingresso
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
     * Listar Ingresso para Venda
     */
    public function listTicketForSale(Request $request)
    {
        $ticket = $this->ticketService->listTicketForSale($request->all());
        return response()->json(['message' => 'Ingresso listado para venda com sucesso!', 'ticket' => $ticket], 201);
    }

    /**
     * Validar Ingresso no Evento
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
     * Solicitar Reembolso de Ingresso
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
