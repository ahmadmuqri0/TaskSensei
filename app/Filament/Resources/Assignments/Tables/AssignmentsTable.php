<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('starts_at')->dateTime()->timezone('Asia/Kuala_Lumpur'),
                TextColumn::make('ends_at')->dateTime()->timezone('Asia/Kuala_Lumpur'),
                TextColumn::make('priority')->searchable()->badge()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                // Action::make('Done')
                //     ->schema([
                //         Checkbox::make('is_done')->label('Done')
                //     ])
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
