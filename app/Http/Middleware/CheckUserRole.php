<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param   $roles
   * @return mixed
   */
  public function handle(Request $request, Closure $next, ...$roles)
  {
    if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
      return redirect('/welcome')->with('error', 'You do not have access to this page.');
    }

    return $next($request);
  }
}
