<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

/**
 * Class CorsMiddleware
 * @package App\ttp\Middleware
 */
class CorsMiddleware
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next): Response
    {
        /** @var Response $response */
        $response = $next($request);
        $response->setHeader('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
