<?php

namespace App\Filament\Student\Resources\MyCourses\Tables;

use App\Models\Course;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MyCoursesTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultPaginationPageOption(12)
            ->paginated([12, 24, 48])
            ->searchPlaceholder('Cari kelas...')
            ->searchDebounce('500ms')
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->with(['category', 'teacher.user'])
                ->withCount('students')
            )
            ->columns([
                ViewColumn::make('card')
                    ->label('')
                    ->view('filament.student.my-courses.course-card')
                    ->viewData([
                        'url' => fn (Course $record) =>
                            route('filament.student.resources.my-courses.view', $record),
                    ])
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                              ->orWhereHas('category', fn ($c) =>
                                  $c->where('name', 'like', "%{$search}%"));
                        });
                    }),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}
