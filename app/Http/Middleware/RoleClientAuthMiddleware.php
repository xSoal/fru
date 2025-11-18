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
      
        if (!in_array($role, [0,2])) {
            // Если роль не совпадает, можно вернуть 403 (Forbidden)
            abort(403);
        }

        // Если все проверки пройдены, разрешаем продолжение запроса
        return $next($request);
    }
}
