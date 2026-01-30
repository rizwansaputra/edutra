<?php

namespace App\Filament\Student\Pages;

use App\Models\SubscribeTransaction;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class TransactionHistory extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-receipt-refund';
    protected static ?string $navigationLabel = 'History Transaksi';
    protected static ?int $navigationSort = 70;

    public array $transactions = [];
    public int $transactionsCount = 0; // buat debug ringan

    public function getView(): string
    {
        return 'filament.student.pages.transaction-history';
    }

    public function mount(): void
    {
        $user = auth()->user();

        if (! $user) {
            $this->transactions = [];
            $this->transactionsCount = 0;
            return;
        }

        $query = SubscribeTransaction::query()
            ->with(['course'])
            ->where('user_id', $user->id)
            ->latest();

        // kalau ternyata datanya soft deleted, uncomment ini untuk test:
        // $query->withTrashed();

        $rows = $query->get();

        $this->transactionsCount = $rows->count();

        $this->transactions = $rows->map(function (SubscribeTransaction $t) {
            $status = $t->status ?? 'pending';

            $statusLabel = match ($status) {
                'paid' => 'PAID',
                'failed' => 'FAILED',
                default => 'PENDING',
            };

            $statusClass = match ($status) {
                'paid' => 'pill--paid',
                'failed' => 'pill--failed',
                default => 'pill--pending',
            };

            $amount = (float) ($t->total_amount ?? 0);
            $amountFormatted = 'Rp ' . number_format($amount, 0, ',', '.');

            $proofUrl = $t->proof ? Storage::url($t->proof) : null;

            return [
                'id' => $t->id,
                'course_name' => $t->course?->name ?? '-',

                'status' => $status,
                'status_label' => $statusLabel,
                'status_class' => $statusClass,

                'amount_formatted' => $amountFormatted,
                'is_paid' => (bool) $t->is_paid,

                'subscription_start_date' => $t->subscription_start_date?->format('d M Y'),
                'created_at' => $t->created_at?->format('d M Y, H:i'),

                'proof_url' => $proofUrl,
            ];
        })->toArray();
    }
}
