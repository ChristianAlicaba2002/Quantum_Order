<?php

namespace App\Http\Controllers\AdminSide;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\RegisterUser;
class AdminController extends Controller
{


    public function AdminLogin(Request $request)
    {
       Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/QuantumOrder');
        }

        return redirect('/QuantumOrder')->with('error', 'Invalid credentials');
    }


    public function AdminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/QuantumOrder');
    }
}
