<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class StudentGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // 1) cari user by email
        $user = User::where('email', $googleUser->getEmail())->first();

        // 2) kalau belum ada, create
        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? 'Student',
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        // 3) pastikan role student
        if (! $user->hasRole('student')) {
            // kalau user sebelumnya admin, kamu bisa pilih:
            // (A) tetap tambah student (multi-role)
            $user->assignRole('student');

            // atau (B) paksa jadi student saja:
            // $user->syncRoles(['student']);
        }

        // 4) login ke guard yang dipakai panel student
        // Kalau panel student pakai guard default "web":
        Auth::guard('web')->login($user);

        // Jika student panel kamu pakai guard "student", ganti jadi:
        // Auth::guard('student')->login($user);

        // 5) redirect ke dashboard student
        return redirect('/student/dashboard');
    }
}
