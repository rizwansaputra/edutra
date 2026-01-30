<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeCheckoutController extends Controller
{
    public function show(Course $course)
    {
        // kirim course ke view
        return view('courses.checkout', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        // TODO: sesuaikan dengan migration kamu
        // contoh sangat sederhana: tanda user sudah ambil course gratis

        // misal punya tabel pivot course_user:
        // $course->students()->syncWithoutDetaching([Auth::id()]);

        // atau punya model Subscription dsb -> isi di sini.

        return redirect()
            ->route('courses.show', $course->slug)
            ->with('success', 'Free plan untuk course ini sudah aktif. Selamat belajar!');
    }
}
