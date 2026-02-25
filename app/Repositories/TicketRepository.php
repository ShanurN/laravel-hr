<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketRepositoryInterface
{
    public function all(): Collection
    {
        return Ticket::with('customer')->latest()->get();
    }

    public function find(int $id): ?Ticket
    {
        return Ticket::with('customer')->find($id);
    }

    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return false;
        }
        return $ticket->update($data);
    }

    public function getStatistics(string $period): Collection
    {
        return Ticket::reportPeriod($period)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
    }
}
