<?php

namespace App\Filament\Student\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Settings extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?int $navigationSort = 50;

    public ?array $data = [];

    // ✅ HARUS public
    public function getView(): string
    {
        return 'filament.student.pages.settings';
    }

    public function mount(): void
    {
        $user = auth()->user();

        $this->data = [
            'name' => $user?->name,
            'email' => $user?->email,
            'password' => null,
            'password_confirmation' => null,
        ];
    }

    public function save(): void
    {
        $this->validate([
            'data.name' => ['required', 'string', 'max:255'],
            'data.email' => ['required', 'email', 'max:255'],
            'data.password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        $payload = [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
        ];

        if (!empty($this->data['password'])) {
            $payload['password'] = Hash::make($this->data['password']);
        }

        $user->update($payload);

        $this->data['password'] = null;
        $this->data['password_confirmation'] = null;

        $this->notify('success', 'Settings updated successfully.');
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }
}
