<?php

namespace App\Repositories\Interfaces;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

interface TicketRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Ticket;
    public function create(array $data): Ticket;
    public function update(int $id, array $data): bool;
    public function getStatistics(string $period): Collection;
}
