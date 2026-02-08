<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // check if route starts with customer
            if ($request->is('customer/*')) {
                return route('customer.login'); // redirect to customer login
            }
            return route('login'); // normal user login
        }
    }
}
