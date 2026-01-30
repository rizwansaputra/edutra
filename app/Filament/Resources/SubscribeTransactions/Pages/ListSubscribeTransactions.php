<?php

namespace App\Filament\Resources\SubscribeTransactions\Pages;

use App\Filament\Resources\SubscribeTransactions\SubscribeTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscribeTransactions extends ListRecords
{
    protected static string $resource = SubscribeTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
