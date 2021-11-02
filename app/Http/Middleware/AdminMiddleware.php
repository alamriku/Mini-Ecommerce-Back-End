<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!(boolean)auth()->user()->is_admin){
            return $this->errorForbidden();
        }
        return $next($request);
    }
}
