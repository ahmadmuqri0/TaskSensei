<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Priority: string implements HasLabel, HasColor
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

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
