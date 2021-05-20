<?php


namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->header(
            "Content-Security-Policy",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://abconvert.xyz https://cdnjs.cloudflare.com https://www.google.com https://abconvert.xyz:2053 https://www.gstatic.com; frame-src www.google.com"
        );

        return $response;
    }
}
