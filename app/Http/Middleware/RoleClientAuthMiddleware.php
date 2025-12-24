<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleClientAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
                // 1. Проверка аутентификации
        // Если пользователь не аутентифицирован, перенаправляем его на страницу входа.
        if (!Auth::check()) {
            return redirect()->route('login'); 
            // Или используйте abort(401) для API
        }

        $user = Auth::user();

        // 2. Проверка роли
        // Проверяем, существует ли у пользователя поле 'role' и совпадает ли оно с требуемой ролью.
        // $role передается из роута (см. ниже).
        $role = (int)$user->role;
        if (!in_array($role, [0,3])) {
            // Если роль не совпадает, можно вернуть 403 (Forbidden)
            abort(403);
        }

        if ($request->isMethod('get')) {
            $parts = explode('/', $request->fullUrl());
            $client_id = array_pop($parts);
            $client_id = explode('?', $client_id);
            $client_id = $client_id[0];

            if(Auth::user()->role === 3){
                return $next($request);
            }

            if(Auth::user()->id !== (int)$client_id){
                abort(403);
            }
        }

        return $next($request);
    }
}
