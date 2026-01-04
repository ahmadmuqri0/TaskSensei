<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $fillable = [
        'title',
        'filename',
        'filepath',
        'starts_at',
        'ends_at',
        'subtask',
        'priority',
        'status',
        'user_id'
    ];

    public function casts(): array
    {
        return [
            'subtask' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
