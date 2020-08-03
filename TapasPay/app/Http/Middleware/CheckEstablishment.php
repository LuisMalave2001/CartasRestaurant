<?php

namespace App\Http\Middleware;

use App\Models\Establishment;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEstablishment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = intval($request->id);
        $user = Auth::user();
        $user_establishments = $user->establishments;

        if(!$user_establishments->find($id)){
            return response("You don't have $id establishment!", 403);
        }

        return $next($request);
    }
}
