<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Priority;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Assignment extends Model implements Eventable
{
    protected $fillable = [
        'title',
        'filename',
        'filepath',
        'starts_at',
        'ends_at',
        'priority',
        'status',
        'user_id',
    ];

    // This is where you map your model into a calendar object
    public function toCalendarEvent(): CalendarEvent
    {
        // For eloquent models, make sure to pass the model to the constructor
        return CalendarEvent::make($this)
            ->title($this->title)
            ->start($this->starts_at)
            ->end($this->ends_at);
    }

    public function casts(): array
    {
        return [
            'priority' => Priority::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
