<?php

return [
    'global' => [
        \Middleware\SessionsSetupMiddleware::class,
        \Middleware\HttpLoggingMiddleware::class,
        \Middleware\MiddlewareA::class,
        \Middleware\MiddlewareB::class,
        \Middleware\MiddlewareC::class,
    ],
];
