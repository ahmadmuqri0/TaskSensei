<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
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
                TrashedFilter::make()
                    ->label('Finished tasks')
                    ->trueLabel('With finished tasks')
                    ->falseLabel('Finished tasks only')
                    ->placeholder('Without finished tasks')
            ])
            ->recordActions([
                ViewAction::make()->label('')->icon(''),
                DeleteAction::make()
                    ->label('Done')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->modalHeading('Mark As Done')
                    ->modalIcon('heroicon-s-check-circle')
                    ->modalSubmitActionLabel('Sure'),
                RestoreAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
