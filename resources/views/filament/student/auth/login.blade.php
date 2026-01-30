<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{-- LOGIN GOOGLE --}}
    <div class="mt-6">
        <a
            href="{{ route('student.google.redirect') }}"
            class="inline-flex w-full items-center justify-center rounded-xl border px-4 py-2 text-sm font-medium hover:bg-gray-100"
        >
            Login / Daftar dengan Google
        </a>
    </div>
</x-filament-panels::page.simple>
