<?php

namespace App\Filament\Student\Resources\MyCourses\Pages;

use App\Filament\Student\Resources\MyCourses\MyCourseResource;
use App\Models\Course;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ListMyCourses extends ListRecords
{
    protected static string $resource = MyCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getView(): string
    {
        return 'filament.student.my-courses.index';
    }

    /**
     * ✅ Ambil course hanya yang SUDAH DIBELI (PAID)
     * sumber: subscribe_transactions
     */
    public function getCourses(): LengthAwarePaginator
    {
        $search = request('q');
        $userId = auth()->id();

        return Course::query()
            ->whereIn('id', function ($q) use ($userId) {
                $q->select('course_id')
                    ->from('subscribe_transactions')
                    ->where('user_id', $userId)
                    ->where('status', 'paid')
                    ->where('is_paid', 1)
                    ->whereNull('deleted_at')
                    ->distinct();
            })
            ->with(['category', 'teacher.user'])
            ->withCount('students')
            ->when($search, function (Builder $q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();
    }
}
