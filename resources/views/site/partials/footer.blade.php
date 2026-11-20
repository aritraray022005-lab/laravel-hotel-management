<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3>Contact Us</h3>
                    <ul class="conta">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> {{ config('hotel.address') }}</li>
                        <li><i class="fa fa-mobile" aria-hidden="true"></i> {{ config('hotel.phone') }}</li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{{ config('hotel.email') }}">{{ config('hotel.email') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Menu Link</h3>
                    <ul class="link_menu">
                        <li><a href="{{ route('site.home') }}">Home</a></li>
                        <li><a href="{{ route('site.home') }}#about">About</a></li>
                        <li><a href="{{ route('site.home') }}#rooms">Our Rooms</a></li>
                        <li><a href="{{ route('site.home') }}#gallery">Gallery</a></li>
                        <li><a href="{{ route('site.home') }}#contact">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <p>
                            &copy; {{ date('Y') }} {{ config('hotel.name') }}. All rights reserved.
                            <br><br>
                            Template by <a href="https://html.design/" target="_blank" rel="noopener">Free Html Templates</a>,
                            distributed by <a href="https://themewagon.com/" target="_blank" rel="noopener">ThemeWagon</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
