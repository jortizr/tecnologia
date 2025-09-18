<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Jetstream\InteractsWithBanner;

class CheckUserActive
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();

            // Verificar si el usuario no está activo
            if (!$user->is_active) {
                // Determinar el tipo de autenticación y hacer logout apropiado
                if ($request->hasSession()) {
                    // Autenticación de sesión web
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->with('error', 'Tu cuenta esta desactivada');
                }

            //redirigir a la pagina de la cuenta desactivada
            return redirect()->route('login')->with('error', 'Tu cuenta esta desactivada');
            }
        }
        return $next($request);
    }
}
