<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   *
   * @param Request $request
   * @return string|null
   * @throws Exception
   */
  protected function redirectTo(Request $request): ?string
  {
    if (! $request->expectsJson()) {
      return route('login');
    } else {
      throw new Exception(__('Unauthenticated.'), 401);
    }
  }
}
