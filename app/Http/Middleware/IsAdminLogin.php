<?php
namespace App\Http\Middleware;
use Closure;
use Session;
class IsAdminLogin
{
  public function handle($request, Closure $next)
  {
  	if (!$request->session()->has('admin_login'))
  	{
   		return redirect()->route('AdminLogin');
		}
    return $next($request);
  }
}