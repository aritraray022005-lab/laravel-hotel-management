@extends('layouts.site')

@section('content')
    {{-- Banner + availability search --}}
    <section class="banner_main">
        <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active"><img class="first-slide" src="{{ asset('images/banner1.jpg') }}" alt="First slide"></div>
                <div class="carousel-item"><img class="second-slide" src="{{ asset('images/banner2.jpg') }}" alt="Second slide"></div>
                <div class="carousel-item"><img class="third-slide" src="{{ asset('images/banner3.jpg') }}" alt="Third slide"></div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="booking_ocline">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="book_room">
                            <h1>Find a Room</h1>
                            <form class="book_now" method="GET" action="{{ route('site.home') }}#rooms">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span>Arrival</span>
                                        <img class="date_cua" src="{{ asset('images/date.png') }}" alt="">
                                        <input class="online_book" type="date" name="arrival" value="{{ $arrival }}" min="{{ now()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <span>Departure</span>
                                        <img class="date_cua" src="{{ asset('images/date.png') }}" alt="">
                                        <input class="online_book" type="date" name="departure" value="{{ $departure }}" min="{{ now()->addDay()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="book_btn" type="submit">Check Availability</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <div id="about" class="about">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="titlepage">
                        <h2>About Us</h2>
                        <p>{{ config('hotel.name') }} offers clean, comfortable rooms and friendly service for business and leisure guests alike. {{ config('hotel.tagline') }} Choose a room, pick your dates and send a booking request in under a minute.</p>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="about_img">
                        <figure><img src="{{ asset('images/about.png') }}" alt="About {{ config('hotel.name') }}"></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rooms --}}
    <div id="rooms" class="our_room">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Our Rooms</h2>
                        <p>
                            @if ($arrival && $departure)
                                Rooms available from {{ \Illuminate\Support\Carbon::parse($arrival)->format('d M Y') }}
                                to {{ \Illuminate\Support\Carbon::parse($departure)->format('d M Y') }}.
                                <a href="{{ route('site.home') }}#rooms">Show all rooms</a>
                            @else
                                Pick the room that suits your stay.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if ($errors->any() && ! old('name'))
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row">
                @forelse ($rooms as $room)
                    <div class="col-md-4 col-sm-6">
                        <div class="room">
                            <div class="room_img">
                                <img src="{{ $room->image_url }}" alt="{{ $room->title }}">
                            </div>
                            <div class="bed_room">
                                <h3>{{ $room->title }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit($room->description, 100) }}</p>
                                <p><strong>{{ config('hotel.currency') }}{{ number_format($room->price, 2) }}</strong> / night</p>
                                <a class="btn btn-primary" href="{{ route('rooms.show', ['room' => $room, 'start_date' => $arrival, 'end_date' => $departure]) }}">Room Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 text-center">
                        <p>No rooms are available for the selected dates. Please try different dates.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Gallery --}}
    <div id="gallery" class="gallery">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage"><h2>Gallery</h2></div>
                </div>
            </div>
            <div class="row">
                @foreach (range(1, 8) as $i)
                    <div class="col-md-3 col-sm-6">
                        <div class="gallery_img">
                            <figure><img src="{{ asset("images/gallery{$i}.jpg") }}" alt="Gallery photo {{ $i }}"></figure>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Contact --}}
    <div id="contact" class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage"><h2>Contact Us</h2></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="request" class="main_form" method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Name" type="text" name="name" value="{{ old('name') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Phone Number" type="text" name="phone" value="{{ old('phone') }}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12">
                                <textarea class="textarea" placeholder="Message" name="message" required>{{ old('message') }}</textarea>
                                @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="send_btn" type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="map_main">
                        <div class="map-responsive">
                            <iframe title="Map" src="https://maps.google.com/maps?q={{ urlencode(config('hotel.address')) }}&amp;output=embed" width="600" height="400" style="border:0; width: 100%;" allowfullscreen loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
