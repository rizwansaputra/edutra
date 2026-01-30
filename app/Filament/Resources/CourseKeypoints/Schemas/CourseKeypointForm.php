<?php

namespace App\Filament\Resources\CourseKeypoints\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourseKeypointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // ✅ course_id jadi dropdown pilih course
            Select::make('course_id')
                ->label('Pilih Course')
                ->relationship('course', 'name')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('name')
                ->label('Keypoint')
                ->required(),
        ]);
    }
}
