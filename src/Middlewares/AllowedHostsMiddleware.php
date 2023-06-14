<?php

namespace Sharan\Security\Middlewares;

use Closure;
use Illuminate\Http\Request;

class AllowedHostsMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (count(array_intersect(['*', $request->getHost()], config('security.allowed_hosts')))) {
            return $next($request);
        }

        abort(404);
    }
}
