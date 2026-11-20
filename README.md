# Laravel Hotel Booking

A hotel booking website built with **Laravel 12** and **Jetstream**. Guests browse rooms, check
availability for their dates and send booking requests. An admin manages rooms, bookings and
contact messages from a dashboard.

## Features

**Guests**
- Browse rooms and search availability by arrival / departure date
- Room details page with a booking form (overlapping stays are rejected)
- Register / log in, view and cancel your own bookings (`/my-bookings`)
- Contact form saved to the database

**Admin (`/admin`)**
- Dashboard with totals and latest bookings
- Add, edit and delete rooms with photo upload
- Confirm, cancel or delete bookings
- Read contact messages

**Security**
- Admin routes protected by `auth` + `admin` middleware
- `usertype` is not mass-assignable
- CSRF-protected forms, validated inputs, escaped output, rate-limited booking/contact endpoints

## Tech stack

PHP 8.2+, Laravel 12, Jetstream (Livewire), Bootstrap 4 (site and admin), Tailwind + Vite (auth pages),
SQLite by default (MySQL supported), PHPUnit.



## Default accounts (local only)

| Role  | Email               | Password   |
|-------|---------------------|------------|
| Admin | `admin@example.com` | `password` |
| Guest | `guest@example.com` | `password` |

Change `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env` **before** seeding any public deployment.

## Configuration

Set these in `.env`: `HOTEL_NAME`, `HOTEL_ADDRESS`, `HOTEL_PHONE`, `HOTEL_EMAIL`, `HOTEL_CURRENCY`,
and `APP_TIMEZONE` (for example `Asia/Kolkata`). See `config/hotel.php`.

## Testing

```bash
php artisan test
```

## Project structure

```
app/Http/Controllers          public site + guest bookings
app/Http/Controllers/Admin    admin panel controllers
app/Http/Middleware           EnsureUserIsAdmin
app/Models                    User, Room, Booking, ContactMessage
resources/views/site          public pages
resources/views/admin         admin pages
routes/web.php                all routes
```

## Credits

Front-end template by [Free Html Templates](https://html.design/), distributed by
[ThemeWagon](https://themewagon.com/). Admin panel based on Bootstrious "Dark Admin".

