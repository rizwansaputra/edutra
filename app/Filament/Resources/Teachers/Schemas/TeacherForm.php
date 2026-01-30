<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Saat CREATE: pilih user dulu (biar relasinya kebentuk)
            Select::make('user_id')
                ->label('Pilih User')
                ->relationship('user', 'name')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} — {$record->email}")
                ->searchable(['name', 'email'])
                ->preload()
                ->required()
                ->visible(fn (string $operation) => $operation === 'create'),

            // Saat EDIT: edit langsung data user (name/email)
            Section::make('Data User')
                ->relationship('user') // <-- ini yang bikin nyimpan ke tabel users
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->visible(fn (string $operation) => $operation === 'edit'),

            Section::make('Data Teacher')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true)
                        ->required(),
                ]),
        ]);
    }
}
