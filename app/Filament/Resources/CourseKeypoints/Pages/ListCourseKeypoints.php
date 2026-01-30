<?php

namespace App\Filament\Resources\CourseKeypoints\Pages;

use App\Filament\Resources\CourseKeypoints\CourseKeypointResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseKeypoints extends ListRecords
{
    protected static string $resource = CourseKeypointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
