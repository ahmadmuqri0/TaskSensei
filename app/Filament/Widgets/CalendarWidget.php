<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Assignment;
use Filament\Actions\ViewAction;
use Guava\Calendar\Filament\CalendarWidget as GuavaCalendarWidget;
use Guava\Calendar\ValueObjects\EventClickInfo;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class CalendarWidget extends GuavaCalendarWidget
{
    protected bool $eventClickEnabled = true;

    protected function getEvents(FetchInfo $info): Collection|array|Builder
    {
        return Assignment::query()
            ->whereDate('ends_at', '>=', $info->start)
            ->whereDate('starts_at', '<=', $info->end);
    }

    protected function onEventClick(EventClickInfo $info, Model $event, ?string $action = null): void
    {
        to_route('filament.app.resources.master-schedules.view', $event->id);
    }
}
