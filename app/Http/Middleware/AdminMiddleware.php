<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user tidak login atau role-nya bukan 'admin', redirect
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->withErrors(['unauthorized' => 'Anda tidak memiliki akses ke halaman ini.']);
        }

        return $next($request);
    }
}