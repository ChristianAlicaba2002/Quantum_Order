<?php

namespace App\Domain\User;

interface UserRepository
{
    public function create(User $user): void;
    public function update(User $user): void;
    public function findById(string $userId): ?User;
}