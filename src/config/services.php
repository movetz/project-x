<?php

use App\Container;
use App\Http\Handler\{
    StartSessionHandler, GetProductHandler, GetAllProductsHandler
};
use App\Http\Middleware\AuthMiddleware;
use App\Service\SessionService;
use App\Domain\Product\ProductRepository;

return [
    //Middlewares
    AuthMiddleware::class => function (Container $container) {
        return new AuthMiddleware(
            $container[SessionService::class]
        );
    },

    //Handlers
    StartSessionHandler::class => function (Container $container) {
        return new StartSessionHandler(
            $container[SessionService::class]
        );
    },
    GetProductHandler::class => function (Container $container) {
        return new GetProductHandler(
            $container[ProductRepository::class]
        );
    },
    GetAllProductsHandler::class => function (Container $container) {
        return new GetAllProductsHandler(
            $container[ProductRepository::class]
        );
    },

    //Domain
    ProductRepository::class => function (Container $container) {
        return new ProductRepository();
    },

    //Services
    SessionService::class => function (Container $container) {
        return new SessionService([
            'username' => 'test',
            'password' => '12345',
        ]);
    },
];
