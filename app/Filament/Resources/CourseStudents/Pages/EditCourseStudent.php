<?php

namespace App\Filament\Resources\CourseStudents\Pages;

use App\Filament\Resources\CourseStudents\CourseStudentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseStudent extends EditRecord
{
    protected static string $resource = CourseStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
