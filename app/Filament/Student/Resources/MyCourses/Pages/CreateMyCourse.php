<?php

namespace App\Filament\Student\Resources\MyCourses\Pages;

use App\Filament\Student\Resources\MyCourses\MyCourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMyCourse extends CreateRecord
{
    protected static string $resource = MyCourseResource::class;
}
