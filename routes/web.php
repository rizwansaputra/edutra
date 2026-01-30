<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\CourseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Account\MyCourseController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\StudentGoogleController;

Route::get('/', [CourseController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/checkout/{course:slug}', [CheckoutController::class, 'show'])
    ->name('checkout.free.show');

Route::post('/checkout/{course:slug}/activate', [CheckoutController::class, 'activate'])
    ->name('checkout.activate');

Route::get('/checkout/{course:slug}/login', function (\App\Models\Course $course) {
    session([
        'url.intended' => route('checkout.free.show', $course),
    ]);

    // arahkan ke login PANEL STUDENT (ganti jika route panelmu beda)
    return redirect()->route('filament.student.auth.login');
})->name('checkout.login');


// ✅ login redirect HARUS di luar auth middleware
Route::get('/login', function () {
    return redirect()->route('filament.student.auth.login');
})->name('login');


Route::prefix('student')->group(function () {
    Route::get('/auth/google', [StudentGoogleController::class, 'redirect'])->name('student.google.redirect');
    Route::get('/auth/google/callback', [StudentGoogleController::class, 'callback'])->name('student.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/my-courses', [MyCourseController::class, 'index'])
        ->name('my-courses.index');

    Route::get('/my-courses/{course:slug}/learn', [MyCourseController::class, 'learn'])
        ->name('my-courses.learn');

    Route::get('/settings', [SettingsController::class, 'edit'])
        ->name('settings.edit');

    Route::post('/settings', [SettingsController::class, 'update'])
        ->name('settings.update');

    Route::post('/logout', function () {
    Auth::logout(); // logout user yang sedang login (guard default)

    request()->session()->invalidate();        // buang session lama
    request()->session()->regenerateToken();   // ganti CSRF token

    return redirect('/'); // atau redirect('/admin/login')
    })->middleware('auth')->name('logout');

});


