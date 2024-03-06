<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        $explode = explode('|', $role);

        foreach ($explode as $key => $value) {
            if (request()->user()->role->name == $value) {
                return $next($request);
            }
        }

        return abort(403, 'Unauthorized action');
    }
}