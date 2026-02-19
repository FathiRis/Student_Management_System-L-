<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || $user->password !== $credentials['password']) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended($this->routeForRole(Auth::user()->role));
    }

    public function dashboardRedirect(): RedirectResponse
    {
        return redirect($this->routeForRole(Auth::user()->role));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function routeForRole(string $role): string
    {
        return match ($role) {
            User::ROLE_ADMIN => route('admin.dashboard'),
            User::ROLE_TEACHER => route('teacher.dashboard'),
            User::ROLE_STUDENT => route('student.dashboard'),
            default => route('login'),
        };
    }
}
