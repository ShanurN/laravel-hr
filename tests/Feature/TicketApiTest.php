<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_ticket_via_api()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('attachment.pdf', 500);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+1234567890',
            'subject' => 'Test Subject',
            'text' => 'Test message content',
            'file' => $file,
        ];

        $response = $this->postJson('/api/tickets', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.subject', 'Test Subject')
            ->assertJsonPath('data.customer.email', 'test@example.com');

        $this->assertDatabaseHas('customers', ['email' => 'test@example.com']);
        $this->assertDatabaseHas('tickets', ['subject' => 'Test Subject']);
    }

    public function test_rate_limiting_one_ticket_per_day()
    {
        $data = [
            'name' => 'Rate Limit Test',
            'email' => 'ratelimit@example.com',
            'phone' => '+9876543210',
            'subject' => 'First Ticket',
            'text' => 'First message',
        ];

        // First submission
        $this->postJson('/api/tickets', $data)->assertStatus(201);

        // Second submission with same email
        $this->postJson('/api/tickets', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

        // Second submission with same phone but different email
        $data2 = $data;
        $data2['email'] = 'other@example.com';
        $this->postJson('/api/tickets', $data2)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']); // Validations adds error to email field
    }

    public function test_statistics_endpoint()
    {
        Ticket::factory()->count(3)->create(['status' => 'new']);
        Ticket::factory()->count(2)->create(['status' => 'processed']);

        $response = $this->getJson('/api/tickets/statistics?period=month');

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'new', 'count' => 3])
            ->assertJsonFragment(['status' => 'processed', 'count' => 2]);
    }
}
