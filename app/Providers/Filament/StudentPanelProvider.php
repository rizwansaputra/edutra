<?php

namespace App\Providers\Filament;

use App\Filament\Student\Auth\StudentLoginResponse;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Responses\Auth\LoginResponse;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StudentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('student')
            ->path('student')
            ->brandName('Edutra.id')
            ->brandLogo(asset('assets/logo/logo-black.svg'))
            ->brandLogoHeight('40px')

            // Login bawaan Filament
            ->login()
            ->authGuard('web')

            ->bootUsing(function (): void {
                // ✅ setelah login, pakai redirect()->intended(...)
                app()->bind(LoginResponse::class, StudentLoginResponse::class);

                // ✅ Inject tombol Google ke halaman login student
                FilamentView::registerRenderHook(
                    PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                    fn () => Request::is('student/*')
                        ? view('filament.student.auth.student-google-login')
                        : '',
                );
            })

            ->discoverResources(
                in: app_path('Filament/Student/Resources'),
                for: 'App\\Filament\\Student\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Student/Pages'),
                for: 'App\\Filament\\Student\\Pages'
            )

            ->colors([
                'primary' => Color::Amber,
            ])

            ->pages([
                \App\Filament\Student\Pages\Dashboard::class,
            ])

            ->discoverWidgets(
                in: app_path('Filament/Student/Widgets'),
                for: 'App\\Filament\\Student\\Widgets'
            )

            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
