<?php 
    $routeMiddleware = [
        'auth.admin' => \App\Http\Middleware\CheckAdmin::class,
    ];