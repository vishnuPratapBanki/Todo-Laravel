<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login.register');
    // }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $request->session()->flash('message', 'YOU NEED TO LOGIN TO ACCESS THIS CONTENT');
            return route('login.register');
        }
    }
}
