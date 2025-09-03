<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LoginResponse implements LoginResponseContract
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): RedirectResponse
    {
        // 1. Obtiene la instancia del usuario autenticado.
        /** @var User $user */ //
        $user = Auth::user();

        if ($user->hasRole('Superadmin')) {
            return redirect()->intended(route('dashboard'));
        }

        if ($user->hasRole('Manager')) {
            return redirect()->intended(route('dashboard.manager'));
        }

        if ($user->hasRole('Viewer')) {
            return redirect()->intended(route('dashboard.viewer'));
        }

        // Redirección por defecto si no se encuentra un rol
        return redirect()->intended(config('fortify.home'));
    }
}
