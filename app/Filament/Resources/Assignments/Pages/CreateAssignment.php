<?php

declare(strict_types=1);

namespace App\Filament\Resources\Assignments\Pages;

use App\Filament\Resources\Assignments\AssignmentResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAssignment extends CreateRecord
{
    protected static string $resource = AssignmentResource::class;
}
