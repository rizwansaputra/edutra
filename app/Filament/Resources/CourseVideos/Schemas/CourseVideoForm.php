<?php

namespace App\Filament\Resources\CourseVideos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class CourseVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ✅ ubah course_id jadi dropdown Select
                Select::make('course_id')
                    ->label('Pilih Course')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->label('Judul Video')
                    ->required(),

                TextInput::make('path_video')
                    ->label('Path / URL Video')
                    ->required(),
            ]);
    }
}
