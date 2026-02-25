<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\UploadedFile;

class TicketService
{
    public function __construct(
        protected TicketRepositoryInterface $ticketRepository,
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function createTicket(array $data, ?UploadedFile $file = null): Ticket
    {
        $customer = $this->customerRepository->findOrCreate([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $ticket = $this->ticketRepository->create([
            'customer_id' => $customer->id,
            'subject' => $data['subject'],
            'text' => $data['text'],
            'status' => 'new',
        ]);

        if ($file) {
            $ticket->addMedia($file)->toMediaCollection('tickets');
        }

        return $ticket;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $updateData = ['status' => $status];
        if ($status === 'processed') {
            $updateData['manager_response_date'] = now();
        }
        return $this->ticketRepository->update($id, $updateData);
    }
}
