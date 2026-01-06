<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\RelationManagers;

use App\Filament\Resources\Assignments\Resources\Tasks\TaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

final class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $relatedResource = TaskResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
