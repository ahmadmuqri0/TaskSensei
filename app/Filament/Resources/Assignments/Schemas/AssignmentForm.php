<?php

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('filename')
                    ->required(),
                TextInput::make('filepath')
                    ->required(),
                DateTimePicker::make('starts_at')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->required(),
                Textarea::make('subtask')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('priority')
                    ->required()
                    ->default('low'),
                TextInput::make('status')
                    ->required()
                    ->default('ongoing'),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
