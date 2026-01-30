<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use Illuminate\Http\Request;

class MyCourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // load courses + relasi yang dibutuhkan
        $courses = $user->courses()
            ->with(['category', 'teacher.user'])
            ->get();

        return view('account.my-courses', compact('user', 'courses'));
    }

    public function learn(Request $request, Course $course)
{
    // Pastikan user memang punya course (sesuaikan relasi students kamu)
    $hasAccess = $course->students()->where('users.id', auth()->id())->exists();
    abort_unless($hasAccess, 403);

    // Ambil video dari relasi videos (yang kamu sudah load di CourseController@show)
    $course->load(['videos']);

    // pilih video aktif: ?video=ID, kalau kosong ambil video pertama
    $activeVideoId = $request->query('video');
    $activeVideo = $activeVideoId
        ? $course->videos->firstWhere('id', (int)$activeVideoId)
        : $course->videos->first();

    // kalau course belum ada video
    if (!$activeVideo) {
        return view('account.learn', [
            'course' => $course,
            'videos' => $course->videos,
            'activeVideo' => null,
        ]);
    }

    return view('account.learn', [
        'course' => $course,
        'videos' => $course->videos,
        'activeVideo' => $activeVideo,
    ]);
}
}
