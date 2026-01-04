<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

class QuickIngest extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.widgets.quick-ingest';

    protected string|int|array $columnSpan = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file')
                    ->hiddenLabel(true),
            ])
            ->statePath('data');
    }
}
