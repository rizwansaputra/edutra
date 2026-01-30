<?php

namespace App\Filament\Resources\SubscribeTransactions;

use App\Filament\Resources\SubscribeTransactions\Pages\CreateSubscribeTransaction;
use App\Filament\Resources\SubscribeTransactions\Pages\EditSubscribeTransaction;
use App\Filament\Resources\SubscribeTransactions\Pages\ListSubscribeTransactions;
use App\Filament\Resources\SubscribeTransactions\Schemas\SubscribeTransactionForm;
use App\Filament\Resources\SubscribeTransactions\Tables\SubscribeTransactionsTable;
use App\Models\SubscribeTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscribeTransactionResource extends Resource
{
    protected static ?string $model = SubscribeTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return SubscribeTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscribeTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSubscribeTransactions::route('/'),
            'create' => CreateSubscribeTransaction::route('/create'),
            'edit'   => EditSubscribeTransaction::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
