<?php

namespace App\Http\Handler;

use App\Http\Request;
use App\Http\Response;
use App\Service\SessionService;

/**
 * Class StartSessionHandler
 * @package App\Http\Handler
 */
class StartSessionHandler
{
    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * StartSessionHandler constructor.
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
    public function __invoke(Request $request, callable $next): Response
    {
        $data = $request->getBody();
        //TODO: Add validator
        if (!(
            isset($data['username']) &&
            strlen($data['username']) &&
            isset($data['password']) &&
            strlen($data['password'])
        )) {
            return new Response(['error' => 'Username or password can not be blank.'], 422);
        }

        $sid = $this->sessionService->authenticate($data['username'], $data['password']);

        return $sid ? new Response(['sid' => $sid], 201) : new Response(['error' => 'Invalid credentials.'], 422);
    }
}
