<?php

namespace App\Filament\Resources\CourseKeypoints;

use App\Filament\Resources\CourseKeypoints\Pages\CreateCourseKeypoint;
use App\Filament\Resources\CourseKeypoints\Pages\EditCourseKeypoint;
use App\Filament\Resources\CourseKeypoints\Pages\ListCourseKeypoints;
use App\Filament\Resources\CourseKeypoints\Schemas\CourseKeypointForm;
use App\Filament\Resources\CourseKeypoints\Tables\CourseKeypointsTable;
use App\Models\CourseKeypoint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseKeypointResource extends Resource
{
    protected static ?string $model = CourseKeypoint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CourseKeypointForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseKeypointsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseKeypoints::route('/'),
            'create' => CreateCourseKeypoint::route('/create'),
            'edit' => EditCourseKeypoint::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
