<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = \App\Models\Customer::all();
        
        \App\Models\Ticket::factory()->count(20)->create([
            'customer_id' => fn() => $customers->random()->id
        ]);
    }
}
