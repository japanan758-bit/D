<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->role !== 'doctor' && $user->role !== 'admin') {
            abort(403, 'غير مسموح لك بالدخول إلى هذه الصفحة');
        }

        return $next($request);
    }
}