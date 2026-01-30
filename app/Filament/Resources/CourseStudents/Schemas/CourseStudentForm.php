<?php

namespace App\Filament\Resources\CourseStudents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class CourseStudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Pilih Course
            Select::make('course_id')
                ->label('Course')
                ->relationship('course', 'name')
                ->searchable()
                ->preload()
                ->required(),

            // Pilih User (siswa)
            Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required()
                // Cegah duplikat enrollment (user + course unik)
                ->rule(fn ($get) => Rule::unique('course_students', 'user_id')
                    ->where('course_id', $get('course_id'))
                    ->ignore(request()->route('record'))),
        ]);
    }
}
