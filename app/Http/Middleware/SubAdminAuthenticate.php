<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class SubAdminAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function authenticate($request, array $guards)
    {
        if(auth()->guard('sub_admin')->check()){
          auth()->shouldUse('sub_admin');
         }
         $this->authenticate($request, ['sub_admin']);
    }
}
