<?php

namespace App\Application\User;
use App\Domain\User\UserRepository;
use App\Domain\User\User;

class RegisterUser
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function create(
        string $userId,
        string $firstName,
        string $lastName,
        string $gender,
        string $address,
        string $contactNumber,
        string $username,
        string $password
    ): void {
        $user = new User(
            $userId,
            $firstName,
            $lastName,
            $gender,
            $address,
            $contactNumber,
            $username,
            $password
        );
        $this->userRepository->create($user);
    }

    public function findById(string $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }
    
}