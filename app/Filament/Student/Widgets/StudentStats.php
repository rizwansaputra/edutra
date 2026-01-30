<?php

namespace App\Filament\Student\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if (! $user) {
            return [];
        }

        return Cache::remember("student_stats:{$user->id}", now()->addMinutes(2), function () use ($user) {
            // 1) Total course (1 query, cepat)
            $totalMyCourses = DB::table('course_students')
                ->where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->count();

            // 2) 7 hari terakhir (1 query)
            $recentCourses = DB::table('course_students')
                ->where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            // 3) Terakhir diambil (1 query)
            $lastRow = DB::table('course_students')
                ->select('course_id', 'created_at')
                ->where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->orderByDesc('created_at')
                ->first();

            $lastTakenValue = $lastRow?->created_at
                ? Carbon::parse($lastRow->created_at)->translatedFormat('d M')
                : '0';

            // Ambil nama course terakhir (1 query kecil)
            // (dipisah supaya query pivot tetap ringan & cepat)
            $lastCourseName = $lastRow?->course_id
                ? DB::table('courses')->where('id', $lastRow->course_id)->value('name')
                : null;

            $lastCourseShort = $lastCourseName
                ? Str::limit($lastCourseName, 40, '…')
                : 'Belum ada course';

            // 4) Chart 7 hari: agregasi DB (1 query) — tidak pakai get()+filter
            $countsByDay = DB::table('course_students')
                ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
                ->where('user_id', $user->id)
                ->whereNull('deleted_at')
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->groupBy('day')
                ->pluck('total', 'day');

            $chart7Days = collect(range(6, 0))->map(function ($i) use ($countsByDay) {
                $day = now()->subDays($i)->toDateString();
                return (int) ($countsByDay[$day] ?? 0);
            })->all();

            $cardClass = 'rounded-2xl shadow-sm ring-1 ring-gray-200/70 dark:ring-gray-700/70 '
                . 'bg-white/70 dark:bg-gray-900/40 backdrop-blur';

            return [
                Stat::make('My Courses', $totalMyCourses)
                    ->description('Total course yang kamu miliki')
                    ->icon('heroicon-o-book-open')
                    ->color('primary')
                    ->chart($chart7Days)
                    ->extraAttributes(['class' => $cardClass]),

                Stat::make('7 Hari Terakhir', $recentCourses)
                    ->description('Course baru yang kamu ambil')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->chart($chart7Days)
                    ->extraAttributes(['class' => $cardClass]),

                Stat::make('Terakhir Diambil', $lastTakenValue)
                    ->description($lastCourseShort)
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->extraAttributes(['class' => $cardClass]),
            ];
        });
    }
}
