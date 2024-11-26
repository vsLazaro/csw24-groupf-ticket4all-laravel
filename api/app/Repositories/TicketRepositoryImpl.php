<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepositoryImpl implements TicketRepository
{
    public function getAll()
    {
        return Ticket::all();
    }

    public function findById($id)
    {
        return Ticket::find($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update($id, array $data)
    {
        $ticket = Ticket::find($id);

        if ($ticket) {
            $ticket->update($data);
        }

        return $ticket;
    }

    public function delete($id)
    {
        $ticket = Ticket::find($id);

        if ($ticket) {
            return $ticket->delete();
        }

        return false;
    }
}
