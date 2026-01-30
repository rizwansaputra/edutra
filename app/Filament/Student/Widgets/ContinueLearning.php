<?php

namespace App\Filament\Student\Widgets;

use Filament\Widgets\Widget;

class ContinueLearning extends Widget
{
    // ❗️Filament v4: $view harus NON-static
    protected string $view = 'filament.student.widgets.continue-learning';

    public function getCourses()
    {
        $user = auth()->user();

        if (! $user) {
            return collect();
        }

        return $user->courses()
            ->orderByPivot('created_at', 'desc')
            ->take(3)
            ->get(['courses.id', 'courses.name']);
    }
}
