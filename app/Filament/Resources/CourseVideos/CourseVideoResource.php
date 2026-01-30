<?php

namespace App\Filament\Resources\CourseVideos;

use App\Filament\Resources\CourseVideos\Pages\CreateCourseVideo;
use App\Filament\Resources\CourseVideos\Pages\EditCourseVideo;
use App\Filament\Resources\CourseVideos\Pages\ListCourseVideos;
use App\Filament\Resources\CourseVideos\Schemas\CourseVideoForm;
use App\Filament\Resources\CourseVideos\Tables\CourseVideosTable;
use App\Models\CourseVideo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseVideoResource extends Resource
{
    protected static ?string $model = CourseVideo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CourseVideoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseVideosTable::configure($table);
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
            'index' => ListCourseVideos::route('/'),
            'create' => CreateCourseVideo::route('/create'),
            'edit' => EditCourseVideo::route('/{record}/edit'),
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
