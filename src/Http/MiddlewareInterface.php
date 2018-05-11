<?php

namespace App\Http;

/**
 * Interface MiddlewareInterface
 * @package Http\Middleware
 */
interface MiddlewareInterface
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next): Response;
}