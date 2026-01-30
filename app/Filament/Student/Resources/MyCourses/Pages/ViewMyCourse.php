<?php

namespace App\Filament\Student\Resources\MyCourses\Pages;

use App\Filament\Student\Resources\MyCourses\MyCourseResource;
use App\Models\SubscribeTransaction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewMyCourse extends ViewRecord
{
    protected static string $resource = MyCourseResource::class;

    public function getView(): string
    {
        return 'filament.student.my-courses.view-my-course';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount($record): void
    {
        parent::mount($record);

        $userId = Auth::id();

        if (! $userId) {
            abort(401);
        }

        // ✅ STRICT: hanya PAID + is_paid = 1
        $hasAccess = SubscribeTransaction::query()
            ->where('user_id', $userId)
            ->where('course_id', $this->record->id)
            ->where('status', 'paid')
            ->where('is_paid', 1)
            ->whereNull('deleted_at')
            ->exists();

        if (! $hasAccess) {
            abort(403, 'You do not have access to this course.');
        }
    }

    protected function getViewData(): array
    {
        return [
            'course' => $this->record->load('videos'),
        ];
    }
}
