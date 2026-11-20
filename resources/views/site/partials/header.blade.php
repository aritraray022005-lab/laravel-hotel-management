<header>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="{{ route('site.home') }}"><img src="{{ asset('images/logo.png') }}" alt="{{ config('hotel.name') }}"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                    <nav class="navigation navbar navbar-expand-md navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="mainNav">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item {{ request()->routeIs('site.home') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('site.home') }}">Home</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.home') }}#about">About</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.home') }}#rooms">Our rooms</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.home') }}#gallery">Gallery</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.home') }}#contact">Contact Us</a></li>

                                @auth
                                    <li class="nav-item {{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('bookings.index') }}">My bookings</a>
                                    </li>
                                    @if (auth()->user()->isAdmin())
                                        <li class="nav-item pr-2">
                                            <a class="btn btn-warning" href="{{ route('admin.dashboard') }}">Admin</a>
                                        </li>
                                    @endif
                                    <li class="nav-item pr-2">
                                        <a class="btn btn-primary" href="{{ route('profile.show') }}">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Logout</button>
                                        </form>
                                    </li>
                                @else
                                    <li class="nav-item pr-2">
                                        <a class="btn btn-success" href="{{ route('login') }}">Login</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                                        </li>
                                    @endif
                                @endauth
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
