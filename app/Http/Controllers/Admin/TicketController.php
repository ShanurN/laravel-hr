<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Services\TicketService;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class TicketController extends Controller
{
    public function __construct(
        protected TicketService $ticketService,
        protected TicketRepositoryInterface $ticketRepository
    ) {}

    public function index(Request $request)
    {
        $status = $request->query('status');
        $email = $request->query('email');
        $phone = $request->query('phone');

        $query = Ticket::with('customer')->latest();

        if ($status) {
            $query->where('status', $status);
        }
        if ($email) {
            $query->whereHas('customer', fn($q) => $q->where('email', 'like', "%$email%"));
        }
        if ($phone) {
            $query->whereHas('customer', fn($q) => $q->where('phone', 'like', "%$phone%"));
        }

        $tickets = $query->paginate(20);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = $this->ticketRepository->find($id);
        if (!$ticket) {
            abort(404);
        }

        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,processed'
        ]);

        $this->ticketService->updateStatus($id, $request->status);

        return back()->with('success', 'Status updated successfully.');
    }
}
