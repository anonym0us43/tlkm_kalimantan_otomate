<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = Auth::user();

        if (! $user || ! $user->role)
        {
            abort(403, 'Unauthorized');
        }

        if (! in_array($user->role->name, $roles))
        {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
