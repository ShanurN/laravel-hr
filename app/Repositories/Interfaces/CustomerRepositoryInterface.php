<?php

namespace App\Repositories\Interfaces;

use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function findOrCreate(array $data): Customer;
    public function findByEmailOrPhone(string $email, string $phone): ?Customer;
}
