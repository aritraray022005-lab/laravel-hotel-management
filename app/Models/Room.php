<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    public const TYPES = [
        'regular' => 'Regular',
        'premium' => 'Premium',
        'deluxe' => 'Deluxe',
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'has_wifi',
        'type',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'has_wifi' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Public URL of the room photo (falls back to a template image).
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image
            ? asset('storage/'.$this->image)
            : asset('images/room1.jpg'));
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::get(fn () => self::TYPES[$this->type] ?? ucfirst((string) $this->type));
    }

    /**
     * Rooms with no active booking overlapping the given stay.
     */
    public function scopeAvailable(Builder $query, string $arrival, string $departure): Builder
    {
        return $query->whereDoesntHave('bookings', function (Builder $bookings) use ($arrival, $departure) {
            $bookings->active()->overlapping($arrival, $departure);
        });
    }

    public function isAvailable(string $arrival, string $departure): bool
    {
        return ! $this->bookings()->active()->overlapping($arrival, $departure)->exists();
    }
}
