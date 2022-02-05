<?php
namespace App\Http\Middleware;
use Closure;
use Session;
class IsUserLogin
{
  public function handle($request, Closure $next)
  {
  


    if(Session::has('locale')){

      \App::setLocale(\Session::get('locale'));
    
    }
    else{

    Session::put('locale','ar');
    Session::save();
    \App::setLocale(\Session::get('locale'));

    }

  
    return $next($request);
  }
}