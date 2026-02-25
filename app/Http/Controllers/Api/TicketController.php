<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        protected TicketService $ticketService,
        protected TicketRepositoryInterface $ticketRepository
    ) {}

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->ticketService->createTicket(
            $request->validated(),
            $request->file('file')
        );

        return new TicketResource($ticket);
    }

    public function statistics(Request $request)
    {
        $period = $request->query('period', 'day');
        $statistics = $this->ticketRepository->getStatistics($period);

        return response()->json([
            'period' => $period,
            'statistics' => $statistics,
        ]);
    }
}
