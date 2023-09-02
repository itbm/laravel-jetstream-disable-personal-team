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
        if (auth()->user()->allTeams()->count() === 0) {
            return redirect()->route('teams.create');
        }

        if(! auth()->user()->currentTeam) {
            if (! auth()->user()->switchTeam(auth()->user()->allTeams()[0])) {
                abort(403);
            }
        }
        
        return $next($request);
    }
}
