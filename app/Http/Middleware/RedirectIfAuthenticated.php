<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::guard($guard)->user()->role;

                return redirect(match ($role) {
                    User::ROLE_ADMIN => route('admin.dashboard'),
                    User::ROLE_TEACHER => route('teacher.dashboard'),
                    User::ROLE_STUDENT => route('student.dashboard'),
                    default => route('dashboard'),
                });
            }
        }

        return $next($request);
    }
}
