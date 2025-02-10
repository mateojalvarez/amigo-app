<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class TelescopeAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @throws BindingResolutionException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $username = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');

        if (app()->environment('local')
            || ($username === config('telescope.basic_auth.username')
            && $password  === config('telescope.basic_auth.password'))) {
            return $next($request);
        }

        return response()->make('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
