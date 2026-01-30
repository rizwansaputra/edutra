<?php

namespace App\Filament\Resources\SubscribeTransactions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class SubscribeTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Pilih user yang bayar
            Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required(),

            // Pilih course yang dibeli
            Select::make('course_id')
                ->label('Course')
                ->relationship('course', 'name')
                ->searchable()
                ->preload()
                ->required(),

            // Nominal pembayaran
            TextInput::make('total_amount')
                ->label('Amount')
                ->numeric()
                ->minValue(0)
                ->required(),

            // Status transaksi
            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'paid'    => 'Paid',
                    'failed'  => 'Failed',
                ])
                ->required(),

            // Tanggal dibayar (opsional, bisa diisi saat status paid)
            DateTimePicker::make('subscription_start_date')
                ->label('Paid At')
                ->seconds(false)
                ->native(false)
                ->nullable(),

            // Upload bukti pembayaran (gambar/pdf)
            FileUpload::make('proof')
                ->label('Bukti Pembayaran')
                ->directory('transactions/proof')
                ->imageEditor()
                ->imagePreviewHeight('160')
                ->acceptedFileTypes(['image/*', 'application/pdf'])
                ->downloadable()
                ->nullable(),
        ]);
    }
}
