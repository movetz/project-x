<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

/**
 * Class JsonSerializer
 * @package App\Http\Middleware
 */
class JsonSerializer
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next): Response
    {
        if ($request->isMethod(Request::METHOD_POST) &&  $request->getHeader('Content-Type') == 'application/json') {
            $request->setBody(
                json_decode($request->getBody(), true)
            );
        }

        /** @var Response $response */
        $response = $next($request);

        $data = $response->getPayload();
        $data = json_encode($data);

        $response->setPayload($data);
        $response->setHeader('Content-Type', 'application/json');

        return $response;
    }
}
