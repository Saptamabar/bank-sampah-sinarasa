<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'user' && !auth()->user()->is_active) {
            // Optional: Redirect to a "waiting for activation" page,
            // or just abort. We'll abort for now or flash a message.
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('status', 'Akun Anda belum diaktifkan oleh Admin.');
        }

        return $next($request);
    }
}
