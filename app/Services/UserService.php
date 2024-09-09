<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;

class UserService
{

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function create($data)
    {
        return $this->userRepository->create($data);
    }

    public function checkUserCredentials($email,$password)
    {
        return $this->userRepository->checkUserCredentials($email,$password);
    }


}
