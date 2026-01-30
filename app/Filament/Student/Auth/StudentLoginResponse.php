<?php

namespace App\Filament\Student\Auth;

use Filament\Http\Responses\Auth\LoginResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class StudentLoginResponse extends LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        return redirect()->intended(route('filament.student.pages.dashboard'));
    }
}
