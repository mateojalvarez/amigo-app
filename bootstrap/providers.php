<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Contexts\Auth\AuthServiceProvider::class,
    App\Providers\Contexts\Expense\ExpenseServiceProvider::class,
    App\Providers\Contexts\User\UserServiceProvider::class,
    App\Providers\FirebaseServiceProvider::class,
    App\Providers\RouteMiddlewareServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
];
