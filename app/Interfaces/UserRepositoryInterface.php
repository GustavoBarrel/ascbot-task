<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function create(object $data);

    public function checkUserCredentials(string $email, string $password);
}
