<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true).' room',
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(40, 400),
            'has_wifi' => true,
            'type' => fake()->randomElement(array_keys(Room::TYPES)),
            'image' => null,
        ];
    }
}
