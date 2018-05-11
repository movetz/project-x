<?php

namespace App\Http\Middleware;

use App\Domain\Paginator;
use App\Http\Request;
use App\Http\Response;

/**
 * Class PaginatorMiddleware
 * @package App\Http\Middleware
 */
class PaginatorSerializer
{
    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next)
    {
        /** @var Response $response */
        $response = $next($request);

        $paginator = $response->getPayload();
        if ($paginator instanceof  Paginator) {
            $response->setPayload([
                'total'  => $paginator->getTotal(),
                'offset' => $paginator->getOffset(),
                'data'   => $paginator->getData(),
            ]);
        }

        return $response;
    }
}
