<?php

namespace App\Infrastructure\Persistence\Eloquent\User;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
// use App\Models\RegisterUser as RegisterUserModel;
use App\Models\User as ModelsUser;

class EloquentUserRepository implements UserRepository
{
    public function create(User $user): void
    {
        $UserModel = ModelsUser::find($user->getUserId()) ?? new ModelsUser();
        $UserModel->userId = $user->getUserId();
        $UserModel->firstName = $user->getFirstName();
        $UserModel->lastName = $user->getLastName();
        $UserModel->gender = $user->getGender();
        $UserModel->address = $user->getAddress();
        $UserModel->PhoneNumber = $user->getPhoneNumber();
        $UserModel->username = $user->getUsername();
        $UserModel->password = $user->getPassword();
        $UserModel->save();
    }

    public function findById(string $userId): ?User
    {
        $UserModel = ModelsUser::find($userId);
        if ($UserModel === null) {
            return null;
        }
        return new User(
            $UserModel->userId,
            $UserModel->firstName,
            $UserModel->lastName,
            $UserModel->gender,
            $UserModel->address,
            $UserModel->PhoneNumber,
            $UserModel->username,
            $UserModel->password
        );
    }

}