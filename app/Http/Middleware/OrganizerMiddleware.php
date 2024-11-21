<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // disini toh taruh perkondisian untuk mengecek apakah user adalah admin atau bukan, kalau bukan
        // maka akan diarahkan ke halaman lain atau di berikan pesan error
        if (Auth::check()) {
            if (Auth::user()->role == 'organizer') {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            return redirect()->route('login');
        }
    }
}
