<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SubscribeTransaction;

class CourseController extends Controller
{
    public function index()
    {
        // ambil beberapa course populer (misal 6)
        $courses = Course::with(['teacher.user'])
            ->withCount('students') // pastikan relasi students() ada di model Course
            ->latest()
            ->take(6)
            ->get();

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load([
            'teacher.user',
            'category',
            'videos',
            'keypoints',
            'students',
        ]);

        $user = auth()->user();
        $isSubscribed = false;

        if ($user) {
            // 1) cek enroll dari pivot course_students (relasi user->courses())
            $isEnrolled = $user->courses()
                ->where('courses.id', $course->id)
                ->exists();

            // 2) cek transaksi paid di subscribe_transactions (opsional tapi aman)
            $isPaid = SubscribeTransaction::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'paid')
                ->where('is_paid', 1)
                ->exists();

            $isSubscribed = $isEnrolled || $isPaid;
        }

        return view('courses.show', compact('course', 'isSubscribed'));
    }
}
