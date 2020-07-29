<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Role;
class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(!Auth::user()) return redirect('/login')->with('error', ['Авторизуйтесь, чтобы продолжить работу']);

        $roles = array_slice(func_get_args(), 2); // [default, admin, manager]

        foreach ($roles as $role) {

            try {

                Role::whereName($role)->firstOrFail(); // make sure we got a "real" role

                if (Auth::user()->hasRole($role)) {
                    return $next($request);
                }

            } catch (ModelNotFoundException $exception) {

                dd('Could not find role ' . $role);

            }
        }

         // custom flash class

        return redirect('/home')->with('error', ['У вас нет доступа к этому разделу']);
    }
}
