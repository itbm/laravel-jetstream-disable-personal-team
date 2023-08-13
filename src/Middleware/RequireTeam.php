<?php

namespace ITBM\DPT\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireTeam
{
    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isMemberOfATeam()) {
            return redirect()->route('teams.create');
        }
        
        return $next($request);
    }
}