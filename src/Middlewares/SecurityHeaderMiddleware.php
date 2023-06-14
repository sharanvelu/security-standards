<?php

namespace Sharan\Security\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SecurityHeaderMiddleware
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
            if (config('security.enabled', true)) {
                $response = $this->addStrictTransportSecurityHeaderValue($response);

                $response = $this->addContentSecurityPolicyHeaderValue($response);

                $response = $this->addIncludedHeaders($response);
            }
        }

        return $response;
    }

    /**
     * Add Strict-Transport-Security header to the response.
     *
     * @param Response $response
     * @return Response
     */
    private function addStrictTransportSecurityHeaderValue(Response $response)
    {
        if ($HSTSValue = config('security.headers.Strict-Transport-Security')) {
            $response->headers->set('Strict-Transport-Security', $HSTSValue);
        }

        return $response;
    }

    /**
     * Parse the Content-Security-Policy header value.
     *
     * @return Response
     */
    private function addContentSecurityPolicyHeaderValue(Response $response)
    {
        $CSPConfig = config('security.headers.Content-Security-Policy');

        if (is_array($CSPConfig)) {
            $CSPValue = '';
            foreach ($CSPConfig as $directive => $value) {
                $content = trim($directive) . ' ' . trim(trim($value), ';') . '; ';
                $CSPValue = $CSPValue . $content;
            }

            $response->headers->set('Content-Security-Policy', $CSPValue);
        }

        return $response;
    }

    /**
     * Check if we can add this header.
     *
     * @param $headerKey
     * @return bool
     */
    private function shouldAddHeader($headerKey)
    {
        $predefinedHeaders = ['content-security-policy', 'strict-transport-security'];

        return !in_array(strtolower($headerKey), $predefinedHeaders);
    }

    /**
     * Include Header will be added in the response.
     *
     * @param Response $response
     * @return Response
     */
    private function addIncludedHeaders(Response $response)
    {
        foreach (config('security.headers.includes') as $header => $value) {
            $header = str_replace(' ', '', $header);

            if ($this->shouldAddHeader($header)) {
                $response->headers->set($header, $value);
            }
        }

        return $response;
    }
}
