<?php

namespace App\Http\Controllers\UserSide;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Application\User\RegisterUser;

class UserController extends Controller
{
    
    protected RegisterUser  $registerUser;
    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function UserRegister(Request $request)
    {
        Validator::make($request->all(), [    
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'contactNumber' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $id = $this->getGenerateUserID();

        $this->registerUser->create(
            $id,
            $request->firstName,
            $request->lastName,
            $request->address,
            $request->contactNumber,
            $request->username,
            Hash::make($request->password)
        );        
    }

    private function getGenerateUserID(): string
    {
        do {
            $id = $this->generateRandomUserID(6);
            $exists = $this->registerUser->findById('userId', $id);
        } while ($exists);

        return $id;
    }

    private function generateRandomUserID(int $length = 10): string
    {
        $result = substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length);

        return $result;
    }
}
