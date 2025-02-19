<?php

namespace App\Http\Controllers\UserSide;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Application\User\RegisterUser;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    protected RegisterUser  $registerUser;
    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function UserRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [    
            'firstName' => 'required',
            'lastName' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'contactNumber' => 'required',
            'username' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $id = $this->getGenerateUserID();

        $this->registerUser->create(
            $id,
            $request->firstName,
            $request->lastName,
            $request->gender,
            $request->address,
            $request->contactNumber,
            $request->username,
            Hash::make($request->password)
        );        
        return redirect('/');
    }

    private function getGenerateUserID(): string
    {
        do {
            $userId = $this->generateRandomUserID(6);
            $exists = $this->registerUser->findById( $userId);
        } while ($exists);

        return $userId;
    }

    private function generateRandomUserID(int $length = 10): string
    {
        $result = substr(bin2hex(random_bytes(ceil($length / 2))), 0, $length);

        return $result;
    }

    public function userLogin(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [    
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt($request->only(['username', 'password']))) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Login successful');
        }

        return redirect('/')
            ->withInput($request->only('username'))
            ->with('error', 'Invalid credentials');
    }

    public function UserLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
