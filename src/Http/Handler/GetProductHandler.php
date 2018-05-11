<?php

namespace App\Http\Handler;

use App\Http\Request;
use App\Http\Response;
use App\Domain\Product\ProductRepository;

/**
 * Class GetProductHandler
 * @package App\Http\Handler
 */
class GetProductHandler
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * GetProductHandler constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, callable $next): Response
    {
        $post = $this->repository->getOne($request->getMeta('route')[0]);
        return new Response($post);
    }
}
