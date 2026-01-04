<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendarWidget;
use App\Filament\Widgets\QuickIngest;
use App\Filament\Widgets\QuickIngestWidget;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

use Filament\Support\Icons\Heroicon;

class Dashboard extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected string $view = 'filament.pages.dashboard';

    public function getHeaderActions(): array
    {
        return [
            Action::make('upload')
                ->label('Upload Assignment')
                ->modalDescription('The uploaded document will be sent to Gemini to be analyze')
                ->schema([
                    TextInput::make('title')
                        ->placeholder('Individual Assignment 1'),
                    FileUpload::make('filepath')
                        ->disk('public')
                        ->directory('attachments')
                        ->visibility('public')
                        ->storeFileNamesIn('filename')
                        ->acceptedFileTypes(['application/pdf'])
                ]),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
