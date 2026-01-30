<?php

namespace App\Filament\Resources\CourseStudents\Pages;

use App\Filament\Resources\CourseStudents\CourseStudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCourseStudents extends ListRecords
{
    protected static string $resource = CourseStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
