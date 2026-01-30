<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Course')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('slug', Str::slug($state))
                    ),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('path_trailer')
                    ->label('Trailer (URL/Path)')
                    ->default(null),

                Textarea::make('about')
                    ->label('Tentang')
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('courses/thumbnails')
                    ->visibility('public')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048)
                    ->nullable()
                    ->openable()

                    // ✅ Filament 4: matikan backend file info fetch
                    // (sering bikin preview edit tidak muncul)
                    ->fetchFileInformation(false),

                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('teacher_id')
                    ->label('Pengajar')
                    ->relationship('teacher', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name ?? '—')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
