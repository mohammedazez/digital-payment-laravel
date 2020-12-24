<?php

namespace App\Http\Middleware;

use Closure;

class API
{
    public function handle($request, Closure $next)
    {
        return response()->json($request->user());
    }
}