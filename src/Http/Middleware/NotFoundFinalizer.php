<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

/**
 * Class NotFound
 * @package App\Http\Middleware
 */
class NotFoundFinalizer
{
    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return new Response('Not found', 404);
    }
}
