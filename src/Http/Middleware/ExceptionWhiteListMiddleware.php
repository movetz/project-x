<?php

namespace App\Http\Middleware;

use App\Http\Response;
use App\Http\Request;

/**
 * Class ExceptionWhiteListMiddleware
 * @package App\Http\Middleware
 */
class ExceptionWhiteListMiddleware
{
    /**
     * @var array
     */
    private $whitelist;

    /**
     * ExceptionWhiteListMiddleware constructor.
     * @param array $whitelist
     */
    public function __construct(array $whitelist = [])
    {
        $this->whitelist = $whitelist;
    }

    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     * @throws \Throwable
     */
    public function __invoke(Request $request, callable $next)
    {
        try {
            $response = $next($request);
        } catch (\Throwable $e) {
            $className = get_class($e);

            if (!array_key_exists($className, $this->whitelist)) {
                throw $e;
            }

            $statusCode = $this->whitelist[$className];
            $response = new Response(['message' => $e->getMessage()], $statusCode);
        }

        return $response;
    }
}
