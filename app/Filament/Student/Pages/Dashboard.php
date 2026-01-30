<?php

namespace App\Filament\Student\Pages;

use BackedEnum;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';

    protected string $view = 'filament.student.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Student\Widgets\StudentStats::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Student\Widgets\ContinueLearning::class,
            \App\Filament\Student\Widgets\QuickActions::class,
        ];
    }
}
