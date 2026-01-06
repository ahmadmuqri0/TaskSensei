<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Resources\Tasks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')->columnSpanFull(),
                TextEntry::make('created_at')->dateTime()->placeholder('-'),
                TextEntry::make('updated_at')->dateTime()->placeholder('-'),
            ]);
    }
}
