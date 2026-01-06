<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Resources\Tasks\Pages;

use App\Filament\Resources\Assignments\Resources\Tasks\TaskResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
