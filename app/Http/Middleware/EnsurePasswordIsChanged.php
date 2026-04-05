<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Filament::auth()->user();

        if (! $user?->must_change_password) {
            return $next($request);
        }

        if (
            $request->routeIs('filament.admin.auth.profile') ||
            $request->routeIs('filament.admin.auth.logout') ||
            $request->routeIs('livewire.update')
        ) {
            return $next($request);
        }

        return redirect()->to(Filament::getProfileUrl());
    }
}
