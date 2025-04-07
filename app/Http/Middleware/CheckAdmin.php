<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/AdminLogin')->with('error', 'Please login as admin first');
        }
        else{
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
