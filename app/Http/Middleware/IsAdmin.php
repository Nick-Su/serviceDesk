<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{

    public function handle($request, Closure $next)
    {
        if ((auth()->check() && auth()->user()->id_role != 1 ))
        {
            return(redirect(url('employee/permission_denied')));
        }

        return $next($request);
    }
}
