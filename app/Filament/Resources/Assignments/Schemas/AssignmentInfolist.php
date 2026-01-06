<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class AssignmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('filename'),
                TextEntry::make('starts_at')->dateTime(),
                TextEntry::make('ends_at')->dateTime(),
                TextEntry::make('priority')->badge(),
                TextEntry::make('status')->badge(),
                TextEntry::make('created_at')->dateTime()->placeholder('-'),
                TextEntry::make('updated_at')->dateTime()->placeholder('-'),
            ]);
    }
}
