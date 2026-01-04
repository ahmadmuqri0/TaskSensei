<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Ingest
        </x-slot>
        <form wire:submit="create">
            {{ $this->form }}
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
