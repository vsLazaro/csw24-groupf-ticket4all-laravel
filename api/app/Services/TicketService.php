<?php

namespace App\Services;

use App\Repositories\TicketRepository;

class TicketService
{
    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllTickets()
    {
        return $this->ticketRepository->getAll();
    }

    public function getTicketById($id)
    {
        return $this->ticketRepository->findById($id);
    }

    public function createTicket($data)
    {
        return $this->ticketRepository->create($data);
    }

    public function updateTicket($id, $data)
    {
        return $this->ticketRepository->update($id, $data);
    }

    public function deleteTicket($id)
    {
        return $this->ticketRepository->delete($id);
    }
}
