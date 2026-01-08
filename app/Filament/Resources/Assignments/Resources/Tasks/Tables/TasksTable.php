<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Resources\Tasks\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

final class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')->label('No')->numeric()->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('description')->searchable()->limit(80),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->columnManager(false)
            ->filters([
                TrashedFilter::make()
                    ->label('Finished tasks')
                    ->trueLabel('With finished tasks')
                    ->falseLabel('Finished tasks only')
                    ->placeholder('Without finished tasks')
            ])
            ->recordActions([
                ViewAction::make()->modal()->label('')->icon(''),
                DeleteAction::make()
                    ->label('Done')
                    ->icon('heroicon-s-check-circle')
                    ->color('success')
                    ->modalHeading('Mark As Done')
                    ->modalIcon('heroicon-s-check-circle')
                    ->modalSubmitActionLabel('Sure')
                    ->visible(true),
                RestoreAction::make()
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
