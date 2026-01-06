<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                TextInput::make('priority')->readOnly()->disabled(),
                DateTimePicker::make('starts_at')->required(),
                DateTimePicker::make('ends_at')->required(),
            ]);
    }
}
