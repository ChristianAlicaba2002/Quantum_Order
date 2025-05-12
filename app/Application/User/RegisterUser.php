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
        string $PhoneNumber,
        string $username,
        string $password,
        string $image,
    ): void {
        $user = new User(
            $userId,
            $firstName,
            $lastName,
            $gender,
            $address,
            $PhoneNumber,
            $username,
            $password,
            $image
        );
        $this->userRepository->create($user);
    }

    public function update(
        string $userId,
        string $firstName,
        string $lastName,
        string $gender,
        string $address,
        string $phoneNumber,
        string $username,
        string $password,
        string $image,
    ): void {
        $existingUser = $this->userRepository->findById($userId);
        if (!$existingUser) {
            throw new \RuntimeException('User not found');
        }

        $updatedUser = new User(
            $existingUser->getUserId(),
            $firstName,
            $lastName,
            $gender,
            $address,
            $phoneNumber,
            $username,
            $password,
            $image
        );
        
        $this->userRepository->update($updatedUser);
    }

    public function findById(string $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }
    
}