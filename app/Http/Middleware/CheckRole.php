<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        if (auth()->user()->role === 1 && $role === 'admin') {
            return $next($request);
        }

        if (auth()->user()->role === 2 && $role === 'user') {
            return $next($request);
        }

        if (auth()->user()->role === 1 && $role === 'user') {
            return redirect()->route('admin.dashboard');
        }

        abort(404);
    }
}
