<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer' => [
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ],
            'subject' => $this->subject,
            'text' => $this->text,
            'status' => $this->status,
            'manager_response_date' => $this->manager_response_date,
            'files' => $this->getMedia('tickets')->map(fn($media) => [
                'name' => $media->file_name,
                'url' => $media->getFullUrl(),
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
