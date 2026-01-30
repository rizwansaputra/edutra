<?php

namespace App\Filament\Resources\CourseStudents\Pages;

use App\Filament\Resources\CourseStudents\CourseStudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseStudent extends CreateRecord
{
    protected static string $resource = CourseStudentResource::class;
}
