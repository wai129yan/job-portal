<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('account.login'); // Redirect to the login page
            //the user who is not register he will be redirected to the login page
            // If user logged in == NO | And it tries to access login profile page it will redirect to user to
        }
    }
}


