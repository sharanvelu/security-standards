<?php

namespace Sharan\Security\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExcludeHeadersMiddleware
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
        $response = $next($request);

        if ($response instanceof Response) {
            foreach (config('security.headers.exclude') as $header) {
                $response->headers->remove($header);
            }
        }

        return $response;
    }
}
