<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Priority: int implements HasColor, HasLabel
{
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::LOW => 'low',
            self::MEDIUM => 'medium',
            self::HIGH => 'high'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::LOW => 'success',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger'
        };
    }
}
