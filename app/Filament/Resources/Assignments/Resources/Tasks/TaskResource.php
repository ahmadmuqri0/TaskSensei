<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Resources\Tasks;

use App\Filament\Resources\Assignments\AssignmentResource;
use App\Filament\Resources\Assignments\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Assignments\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Assignments\Resources\Tasks\Pages\ViewTask;
use App\Filament\Resources\Assignments\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Resources\Assignments\Resources\Tasks\Schemas\TaskInfolist;
use App\Filament\Resources\Assignments\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = AssignmentResource::class;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
            // 'view' => ViewTask::route('/{record}'),
        ];
    }
}
