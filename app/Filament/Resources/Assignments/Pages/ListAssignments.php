<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Pages;

use App\Filament\Resources\Assignments\AssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListAssignments extends ListRecords
{
    protected static string $resource = AssignmentResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }
}
