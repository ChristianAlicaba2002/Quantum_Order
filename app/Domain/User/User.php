<?php

namespace App\Domain\User;

class User
{
    public function __construct(
        private string $userId,
        private string $firstName,
        private string $lastName,
        private string $gender,
        private string $address,
        private string $PhoneNumber,
        private string $username,
        private string $password,
        private string $image
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->PhoneNumber = $PhoneNumber;
        $this->username = $username;
        $this->password = $password;
        $this->image = $image;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getGender(): string
    {
        return $this->gender;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhoneNumber(): string
    {
        return $this->PhoneNumber;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'address' => $this->address,
            'PhoneNumber' => $this->PhoneNumber,
            'username' => $this->username,
            'password' => $this->password,
            'image' => $this->image,
        ];
    }
   
   
}