<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use \Guava\Calendar\Filament\CalendarWidget as GuavaCalendarWidget;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class CalendarWidget extends GuavaCalendarWidget
{
    protected bool $eventClickEnabled = true;

    protected function getEvents(FetchInfo $info): Collection|array|Builder
    {
        return Assignment::query()
            ->whereDate('ends_at', '>=', $info->start)
            ->whereDate('starts_at', '<=', $info->end);
    }
}
