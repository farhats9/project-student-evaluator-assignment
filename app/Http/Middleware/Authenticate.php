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
    //     return $request->expectsJson() ? null : route('home');
    // }
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $request->session()->flash('message', 'You need to Login to Access this Content');
            return route('home');
        }
    }

}
