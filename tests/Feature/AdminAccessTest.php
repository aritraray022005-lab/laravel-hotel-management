<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_regular_users_are_forbidden(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
    }

    public function test_regular_users_cannot_delete_rooms(): void
    {
        $room = Room::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('admin.rooms.destroy', $room))
            ->assertForbidden();

        $this->assertModelExists($room);
    }

    public function test_admins_can_see_the_dashboard_and_manage_rooms(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($admin)->get(route('admin.rooms.index'))->assertOk();

        $this->actingAs($admin)->post(route('admin.rooms.store'), [
            'title' => 'Sea View',
            'description' => 'Nice room',
            'price' => 120,
            'type' => 'deluxe',
            'has_wifi' => 1,
        ])->assertRedirect(route('admin.rooms.index'));

        $this->assertDatabaseHas('rooms', ['title' => 'Sea View']);
    }

    public function test_usertype_cannot_be_mass_assigned(): void
    {
        $user = User::create([
            'name' => 'Eve',
            'email' => 'eve@example.com',
            'phone' => '9999999999',
            'password' => 'password',
            'usertype' => 'admin',
        ]);

        $this->assertFalse($user->fresh()->isAdmin());
    }
}
