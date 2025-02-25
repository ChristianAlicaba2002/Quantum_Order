<?php

namespace App\Infrastructure\Persistence\Eloquent\User;
use App\Domain\User\User;
use App\Domain\User\UserRepository;
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
        $UserModel->image = $user->getImage();
        $UserModel->save();
    }

    // public function update(User $user): void
    // {
    //     $UserModel = ModelsUser::find($user->getUserId()) ?? new ModelsUser();
    //     $UserModel->userId = $user->getUserId();
    //     $UserModel->firstName = $user->getFirstName();
    //     $UserModel->lastName = $user->getLastName();
    //     $UserModel->gender = $user->getGender();
    //     $UserModel->address = $user->getAddress();
    //     $UserModel->PhoneNumber = $user->getPhoneNumber();
    //     $UserModel->username = $user->getUsername();
    //     $UserModel->password = $user->getPassword();
    //     $UserModel->image = $user->getImage();
    //     $UserModel->save();
    // }

    public function update(User $user): void
    {
        $userModel = ModelsUser::where('userId', $user->getUserId())->first();
        if (!$userModel) {
            throw new \RuntimeException('User not found');
        }
        
        $userModel->firstName = $user->getFirstName();
        $userModel->lastName = $user->getLastName();
        $userModel->gender = $user->getGender();
        $userModel->address = $user->getAddress();
        $userModel->PhoneNumber = $user->getPhoneNumber();
        $userModel->username = $user->getUsername();
        $userModel->password = $user->getPassword();
        $userModel->image = $user->getImage();
        $userModel->save();
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
            $UserModel->password,
            $UserModel->image,
        );
    }

}