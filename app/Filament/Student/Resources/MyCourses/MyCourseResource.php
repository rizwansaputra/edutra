<?php

namespace App\Filament\Student\Resources\MyCourses;

use App\Filament\Student\Resources\MyCourses\Pages;
use App\Models\Course;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyCourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static UnitEnum|string|null $navigationGroup = 'Overview';

    protected static ?string $navigationLabel = 'My Course';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    /**
     * ✅ Query: tampilkan course yang sudah dibeli (subscribe_transactions)
     * Syarat akses:
     * - user_id = auth()->id()
     * - status = paid
     * - is_paid = 1
     * - deleted_at null (soft delete)
     */
    public static function getEloquentQuery(): Builder
    {
        $userId = Auth::id();

        return parent::getEloquentQuery()
            ->whereIn('id', function ($q) use ($userId) {
                $q->select('course_id')
                    ->from('subscribe_transactions')
                    ->where('user_id', $userId)
                    ->where('status', 'paid')
                    ->where('is_paid', 1)
                    ->whereNull('deleted_at')
                    ->distinct();
            });
    }

    // Student tidak boleh create / edit / delete
    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function canForceDelete($record): bool { return false; }
    public static function canRestore($record): bool { return false; }

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyCourses::route('/'),
            'view'  => Pages\ViewMyCourse::route('/{record}'),
        ];
    }
}
