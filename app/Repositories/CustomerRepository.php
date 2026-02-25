<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function findOrCreate(array $data): Customer
    {
        return Customer::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone']
            ]
        );
    }

    public function findByEmailOrPhone(string $email, string $phone): ?Customer
    {
        return Customer::where('email', $email)
            ->orWhere('phone', $phone)
            ->first();
    }
}
