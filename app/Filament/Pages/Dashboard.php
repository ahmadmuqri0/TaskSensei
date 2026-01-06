<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendarWidget;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

final class Dashboard extends Page implements HasForms
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
                        ->label('Attachment')
                        ->disk('public')
                        ->directory('attachments')
                        ->visibility('public')
                        ->storeFileNamesIn('filename')
                        ->acceptedFileTypes(['application/pdf']),
                ])
                ->action(function (array $data): void {
                    $fullPath = Storage::disk('public')->path($data['filepath']);

                    $controller = new \App\Http\Controllers\GeminiController();

                    $request = new \Illuminate\Http\Request([
                        'title' => $data['title'],
                        'filepath' => $data['filepath'],
                        'filename' => $data['filename'],
                        'full_path' => $fullPath,
                        'user_id' => Auth::id(),
                    ]);

                    $response = $controller->__invoke($request);
                    $result = $response->getData();

                    if ($result->success) {
                        Notification::make()
                            ->title('Assignment Created')
                            ->body('Document analyzed successfully with '.count($result->assignment->tasks).' tasks extracted.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Analysis Failed')
                            ->body($result->message)
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
