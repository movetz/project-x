<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Service\SessionService;

/**
 * Class AuthMiddleware
 * @package App\Http\Middleware
 */
class AuthMiddleware
{
    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * AuthMiddleware constructor.
     * @param SessionService $sessionService
     */
    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next)
    {
        if (!$this->sessionService->check($request->getQueryParam('sid', ''))) {
            return new Response(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
