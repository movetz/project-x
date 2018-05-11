<?php

namespace App\Http\Handler;

use App\Http\Request;
use App\Http\Response;
use App\Domain\Product\ProductRepository;

/**
 * Class GetAllProductsHandler
 * @package App\Http\Handler
 */
class GetAllProductsHandler
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
        $limit = $request->getQueryParam('limit', 5);
        $offset = $request->getQueryParam('offset', 0);

        $paginator = $this->repository->getAll($limit, $offset);
        return new Response($paginator);
    }
}
