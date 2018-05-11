<?php

use App\Domain\Product\ProductNotFoundException;
use App\Http\Handler\{
    GetAllProductsHandler, GetProductHandler, StartSessionHandler
};
use App\Http\Middleware\{
    AuthMiddleware, CorsMiddleware, ExceptionMiddleware, ExceptionWhiteListMiddleware, JsonSerializer, NotFoundFinalizer, PaginatorSerializer, Route
};


return [
    new ExceptionMiddleware(),
    new CorsMiddleware(),
    new JsonSerializer(),
    new ExceptionWhiteListMiddleware([
        ProductNotFoundException::class => 404
    ]),
    Route::post('/session', StartSessionHandler::class),
    Route::get('/products(.*)', [
        AuthMiddleware::class,
        Route::get('/products', [
            new PaginatorSerializer(),
            GetAllProductsHandler::class,
        ]),
        Route::get('/products/(\d+)', GetProductHandler::class),
        new NotFoundFinalizer(),
    ]),
    new NotFoundFinalizer(),
];
