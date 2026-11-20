<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    public const PENDING = 'pending';

    public const CONFIRMED = 'confirmed';

    public const CANCELLED = 'cancelled';

    public const STATUSES = [self::PENDING, self::CONFIRMED, self::CANCELLED];

    protected $fillable = [
        'room_id',
        'user_id',
        'name',
        'email',
        'phone',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', self::CANCELLED);
    }

    /**
     * Stays that overlap [arrival, departure). The departure day itself is
     * free, so back-to-back bookings are allowed.
     */
    public function scopeOverlapping(Builder $query, string $arrival, string $departure): Builder
    {
        return $query->whereDate('start_date', '<', $departure)
            ->whereDate('end_date', '>', $arrival);
    }

    public function getNightsAttribute(): int
    {
        return (int) $this->start_date->diffInDays($this->end_date);
    }

    public function isCancellable(): bool
    {
        return $this->status !== self::CANCELLED && $this->start_date->isFuture();
    }
}
