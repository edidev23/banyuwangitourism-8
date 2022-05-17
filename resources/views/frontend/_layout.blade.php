<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="id" xml:lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | Banyuwangi Tourism</title>
    <meta name="description" content="@yield('description')">
    <meta name="keyword" content="@yield('keywords')">
    <meta name="author" content="Banyuwangi Tourism">

    <meta image="{{ asset('upload/logo_new.png') }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ asset('upload/logo_new.png') }}">
    <meta property="og:title" content="@yield('title') — Banyuwangi Tourism">
    <meta property="og:site_name" content="Banyuwangi Tourism">
    <meta property="og:url" content="{{ getCurrentUrl() }}">
    <meta property="og:description" content="@yield('description')">

    <link rel="icon" type="image/png" href="{{ asset('upload/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('upload/favicon.png') }}">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="{{ asset('frontend/css/fontgoogle.css?family=Roboto:wght@400;500;700;900&amp;display=swap') }}" />
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/line-awesome.css') }}" />
    {{-- <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

    @yield('meta_data')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LDFGWBJ2E3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-LDFGWBJ2E3');
    </script>

    @yield('css')
</head>

<body>
    <!-- start cssload-loader -->
    <div class="preloader" id="preloader">
        <div class="loader">
            <svg class="spinner" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
            </svg>
        </div>
    </div>
    <!-- end cssload-loader -->

    <header class="header-area">
        <div class="header-menu-wrapper padding-right-100px padding-left-100px">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="menu-wrapper justify-content-between">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('upload/logo_new.png') }}"
                                        alt="logo" height="50px" /></a>
                                <div class="menu-toggler">
                                    <i class="la la-bars"></i>
                                    <i class="la la-times"></i>
                                </div>
                            </div>
                            <div class="main-menu-content pr-0 ml-0">
                                <nav>
                                    <ul>
                                        <li>
                                            <a href="{{ url('') }}"
                                                class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('destination') }}"
                                                class="{{ request()->is('destination', 'destination/*') ? 'active' : '' }}">Destination</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('festival') }}"
                                                class="{{ request()->is('festival', 'festival/*') ? 'active' : '' }}">Festival</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('produk_ppkm') }}"
                                                class="{{ request()->is('produk_ppkm', 'produk_ppkm/*') ? 'active' : '' }}">Culinary & Merchandise</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('handcraft') }}"
                                                class="{{ request()->is('handcraft', 'handcraft/*') ? 'active' : '' }}">Handcraft</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('news') }}"
                                                class="{{ request()->is('news', 'news/*') ? 'active' : '' }}">News</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('get-apps') }}"
                                                class="{{ request()->is('get-apps', 'get-apps/*') ? 'active' : '' }}">Get
                                                Apps</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('main')

    <section class="footer-area section-bg padding-top-100px padding-bottom-70px">
        <div class="container">
            <div class="row">
                <div class="col  responsive-column">
                    <div class="footer-item">
                        <div class="footer-logo padding-bottom-30px">
                            <a href="{{ url('/') }}" class="foot__logo"><img
                                    src="{{ asset('upload/logo_new.png') }}" alt="logo"
                                    style="margin-top: -20px; height: 70px" /></a>
                        </div>
                        <!-- end logo -->
                        <p class="footer__desc mb-3">
                            Banyuwangitourism adalah website promosi pariwisata Kabupaten Banyuwangi yang dikelola oleh
                            Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi.
                        </p>



                        <div class="footer-social-box text-left">
                            <ul class="social-profile">
                                <li><span class="mr-3">FOLLOW US</span></li>
                                <li>
                                    <a href="https://www.facebook.com/profile.php?id=100014271571685" rel="noreferrer"
                                        aria-label="Facebook" target="_blank"><i class="lab la-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/Banyuwangi_tour" rel="noreferrer" aria-label="Twitter"
                                        target="_blank"><i class="lab la-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/banyuwangi_tourism/" rel="noreferrer"
                                        aria-label="Instagram" target="_blank"><i class="lab la-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="https://posts.google.com/share/CAcVjc9W" rel="noreferrer"
                                        aria-label="Google Plus" target="_blank"><i class="lab la-google-plus"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end footer-item -->
                </div>
                <!-- end col-lg-3 -->
                <div class="col-lg-2 offset-lg-1 responsive-column">
                    <div class="footer-item">
                        <h5 class="title curve-shape pb-3 margin-bottom-20px" data-text="curvs">
                            Fitur Lain
                        </h5>
                        <ul class="list-items list--items">
                            <li><a href="#">Ebook</a></li>
                            <li><a href="https://banyuwangitourism.com/jalanjalan/" rel="noreferrer"
                                    target="_blank">Jalan-jalan</a></li>
                            <li><a href="#">Reservasi Pendopo</a></li>
                            <li><a href="#">Buku Tamu</a></li>
                        </ul>
                    </div>
                    <!-- end footer-item -->
                </div>
                <!-- end col-lg-3 -->
                <div class="col col-lg-3 responsive-column">
                    <div class="footer-item">
                        <h5 class="title curve-shape pb-3 margin-bottom-20px" data-text="curvs">
                            Contact With Us
                        </h5>
                        <ul class="list-items list--items">
                            <li><a href="call:0333424172" target="_blank">(0333) 424172</a></li>
                            <li><a href="mailto:bwitourism1@gmail.com" target="_blank">bwitourism1@gmail.com</a></li>
                        </ul>
                    </div>
                    <!-- end footer-item -->
                </div>
            </div>
            <!-- end row -->
            <div class="section-block"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="copy-right padding-top-30px text-center">
                        <p class="copy__desc">
                            &copy; Copyright <?= date('Y') ?>. Made with
                            <span class="la la-heart" style="color: red"></span> by
                            <a href="#">Disbudpar Banyuwangi</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- start back-to-top -->
    <div id="back-to-top">
        <i class="la la-angle-up" title="Go top"></i>
    </div>
    <!-- end back-to-top -->

    <!-- Template JS Files -->
    {{-- <script src="{{ asset('frontend/js/jquery-3.4.1.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    @yield('js')

    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
