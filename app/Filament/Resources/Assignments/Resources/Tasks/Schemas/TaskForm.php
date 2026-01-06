<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Resources\Tasks\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                Textarea::make('description')->required()->columnSpanFull(),
                TextInput::make('order')->required()->numeric(),
            ]);
    }
}
