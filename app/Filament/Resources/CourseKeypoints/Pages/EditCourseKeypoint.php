<?php

namespace App\Filament\Resources\CourseKeypoints\Pages;

use App\Filament\Resources\CourseKeypoints\CourseKeypointResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseKeypoint extends EditRecord
{
    protected static string $resource = CourseKeypointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
