<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'order',
        'assignment_id',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
