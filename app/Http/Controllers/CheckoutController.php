<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SubscribeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show(Course $course)
    {
        return view('checkout.show', compact('course'));
    }

    public function activate(Request $request, Course $course)
    {
        $user = $request->user();
        abort_unless($user, 403);

        DB::transaction(function () use ($user, $course) {

            // 1) enroll ke course_students
            $user->courses()->syncWithoutDetaching([$course->id]);

            // 2) catat transaksi free ke subscribe_transactions
            //    pakai updateOrCreate supaya tidak double kalau user klik 2x
            SubscribeTransaction::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ],
                [
                    'status' => 'paid', // pending | paid | failed
                    'total_amount' => 0.00,
                    'is_paid' => 1,
                    'subscription_start_date' => now()->toDateString(),
                    'proof' => null,
                ]
            );
        });

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Free access berhasil diaktifkan!');
    }
}
