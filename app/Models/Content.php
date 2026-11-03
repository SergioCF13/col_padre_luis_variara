<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'category', 'summary', 'body',
        'event_date', 'event_time', 'place', 'author', 'image_path',
        'photos', 'status', 'featured',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'photos' => 'array',
            'featured' => 'boolean',
        ];
    }

    public function authorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
