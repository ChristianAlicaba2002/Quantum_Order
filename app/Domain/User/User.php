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
        private string $contactNumber,
        private string $username,
        private string $password
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->contactNumber = $contactNumber;
        $this->username = $username;
        $this->password = $password;
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

    public function getContactNumber(): string
    {
        return $this->contactNumber;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'address' => $this->address,
            'contactNumber' => $this->contactNumber,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
   
   
}