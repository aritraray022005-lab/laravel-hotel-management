<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedAdmin();

        if (app()->environment('local', 'testing')) {
            $this->seedDemoGuest();
        }

        if (Room::count() === 0) {
            $this->seedRooms();
        }
    }

    private function seedAdmin(): void
    {
        $admin = User::firstOrNew(['email' => config('hotel.admin.email')]);

        $admin->forceFill([
            'name' => config('hotel.admin.name'),
            'phone' => $admin->phone ?? '0000000000',
            'usertype' => User::TYPE_ADMIN,
            'password' => config('hotel.admin.password'),
        ])->save();
    }

    private function seedDemoGuest(): void
    {
        $guest = User::firstOrNew(['email' => 'guest@example.com']);

        if (! $guest->exists) {
            $guest->forceFill([
                'name' => 'Demo Guest',
                'phone' => '9000000000',
                'usertype' => User::TYPE_USER,
                'password' => 'password',
            ])->save();
        }
    }

    private function seedRooms(): void
    {
        $rooms = [
            ['Standard Single', 'regular', 59, 'A quiet single room with a work desk, fast Wi-Fi and a comfortable bed. Ideal for solo travellers.'],
            ['Standard Double', 'regular', 79, 'A bright double room with a queen bed, private bathroom and a city view.'],
            ['Premium Twin', 'premium', 109, 'Spacious twin room with a seating area, mini fridge and a complimentary breakfast.'],
            ['Premium King', 'premium', 139, 'A king-size room with a lounge corner, rain shower and a balcony.'],
            ['Deluxe Suite', 'deluxe', 199, 'A two-room suite with a separate living area, bathtub and panoramic views.'],
            ['Family Suite', 'deluxe', 229, 'Two bedrooms and a shared lounge, perfect for families of up to five guests.'],
        ];

        foreach ($rooms as $index => [$title, $type, $price, $description]) {
            $number = $index + 1;
            $source = public_path("images/room{$number}.jpg");
            $image = null;

            if (File::exists($source)) {
                $image = "rooms/room{$number}.jpg";
                Storage::disk('public')->put($image, File::get($source));
            }

            Room::create([
                'title' => $title,
                'type' => $type,
                'price' => $price,
                'has_wifi' => true,
                'description' => $description,
                'image' => $image,
            ]);
        }
    }
}
