<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function payload(string $start, string $end): array
    {
        return [
            'name' => 'Asha Roy',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
            'start_date' => $start,
            'end_date' => $end,
        ];
    }

    public function test_home_and_room_pages_render(): void
    {
        $room = Room::factory()->create();

        $this->get('/')->assertOk()->assertSee($room->title);
        $this->get(route('rooms.show', $room))->assertOk()->assertSee($room->title);
    }

    public function test_guest_can_book_a_room(): void
    {
        $room = Room::factory()->create();
        $start = now()->addDays(10)->toDateString();
        $end = now()->addDays(12)->toDateString();

        $this->post(route('bookings.store', $room), $this->payload($start, $end))
            ->assertRedirect(route('rooms.show', $room))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'room_id' => $room->id,
            'email' => 'asha@example.com',
            'status' => Booking::PENDING,
        ]);
    }

    public function test_overlapping_booking_is_rejected(): void
    {
        $room = Room::factory()->create();
        Booking::factory()->for($room)->create([
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
        ]);

        $this->post(route('bookings.store', $room), $this->payload(
            now()->addDays(12)->toDateString(),
            now()->addDays(16)->toDateString(),
        ))->assertSessionHasErrors('start_date');

        $this->assertSame(1, Booking::count());
    }

    public function test_back_to_back_booking_is_allowed(): void
    {
        $room = Room::factory()->create();
        Booking::factory()->for($room)->create([
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
        ]);

        $this->post(route('bookings.store', $room), $this->payload(
            now()->addDays(14)->toDateString(),
            now()->addDays(16)->toDateString(),
        ))->assertSessionHasNoErrors();

        $this->assertSame(2, Booking::count());
    }

    public function test_departure_must_be_after_arrival(): void
    {
        $room = Room::factory()->create();
        $day = now()->addDays(5)->toDateString();

        $this->post(route('bookings.store', $room), $this->payload($day, $day))
            ->assertSessionHasErrors('end_date');
    }

    public function test_availability_search_hides_booked_rooms(): void
    {
        $free = Room::factory()->create(['title' => 'Free Room']);
        $taken = Room::factory()->create(['title' => 'Taken Room']);
        Booking::factory()->for($taken)->create([
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
        ]);

        $this->get(route('site.home', [
            'arrival' => now()->addDays(11)->toDateString(),
            'departure' => now()->addDays(13)->toDateString(),
        ]))->assertOk()->assertSee('Free Room')->assertDontSee('Taken Room');
    }
}
