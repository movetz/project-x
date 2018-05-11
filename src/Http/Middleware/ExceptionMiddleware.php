<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

/**
 * Class ExceptionMiddleware
 * @package App\Http\Middleware
 */
class ExceptionMiddleware
{
    /**
     * @var array
     */
    private $codes;

    public function __construct(array $codes = [])
    {
        $this->codes = $codes;
    }

    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next)
    {
        try {
            $response = $next($request);
        } catch (\Throwable $e) {
            error_log($e);
            $response = new Response('Oops =(', 500);
        }

        return $response;
    }
}
