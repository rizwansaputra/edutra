<?php

namespace App\Filament\Student\Resources\MyCourses\Pages;

use App\Filament\Student\Resources\MyCourses\MyCourseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMyCourse extends EditRecord
{
    protected static string $resource = MyCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
