@extends('frontend._layout')

@section('meta_data')
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Website",
            "name": "Banyuwangi Tourism",
            "url": "{{ getCurrentUrl() }}",
            "offers": {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Trip",
                    "name": "Destination",
                    "subTrip": [{
                            "@type": "Trip",
                            "name": "Kawah Ijen",
                            "description": "Keindahan Kawah ijen dengan fenomena alam yang mendunia tidak terbantahkan. Api Biru menjadi salah satu daya tarik utama dari Kawah ijen, saat selimut malam tiba memunculkan pijar api biru dari dasar kawah Ijen."
                        },
                        {
                            "@type": "Trip",
                            "name": "Bangsring Underwater",
                            "description": "Merupakan area konservasi terumbu karang dan sekaligus destinasi bawah laut yang dapat kalian nikmati. Area konservasi memiliki luas sekitar 15 hektar, banyak spot yang dapat kalian temukan di area ini untuk snorkeling."
                        },
                        {
                            "@type": "Trip",
                            "name": "Alas Purwo",
                            "description": "Padang Rumput Sadengan berada di dalam Taman Nasional Alas Purwo. Mempunyai luas 84 hektare, padang rumput ini telah menjadi favorit para wisatawan dari dalam dan luar negeri."
                        },
                        {
                            "@type": "Trip",
                            "name": "Pantai Pulau Merah",
                            "description": "Pulau Merah atau Pulo Merah adalah sebuah pantai dan objek wisata di Kecamatan Pesanggaran, Banyuwangi. Pantai ini dikenal karena sebuah bukit hijau kecil dengan tanah berwarna merah yang terletak di dekat bibir pantai."
                        }
                    ]
                }
            }
        }
    </script>
@endsection

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi')
@section('title', 'Ayo ke Banyuwangi, Anda pasti ingin kembali')
@section('description',
    "Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas
    kebudayaan dan pariwisata kabupaten banyuwangi")

@section('css')
    <style>
        .hero-wrapper .carousel-item {
            height: 32rem;
            background: #000;
            color: white;
            position: relative;
        }

        .hero-wrapper .container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding-top: 120px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .hero-wrapper .overlay-image {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            top: 0;
            background-position: bottom;
            background-size: cover;
            opacity: 0.4;
        }

        #carouselBanner .list-inline {
            white-space: nowrap;
            overflow-x: auto;
        }

        #carouselBanner .carousel-indicators {
            position: absolute;
            margin-bottom: 10px
        }

        #carouselBanner .carousel-indicators>li {
            width: 12rem;
            height: 8rem;
            text-indent: initial;
            opacity: 1;
            background: transparent;
        }

        #carouselBanner .carousel-indicators>li img {
            height: 100%;
            width: 100%;
            object-fit: cover
        }

        #carouselBanner .carousel-indicators>li.active img {
            /* opacity: 1; */
        }

        @media (max-width: 576px) {
            .hero-wrapper .carousel-item {
                height: 25rem;
            }
        }

    </style>
@endsection

@section('main')

    <section class="hero-wrapper hero-wrapper7">
        <div id="carouselBanner" class="carousel slide carousel-fade" data-ride="carousel" data-pause="false">
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="12000">
                    <div class="overlay-image"
                        style="opacity: 1; background-image: url('{{ asset('upload/background_bfest.jpg') }}');">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7">
                                <h1>Gaya Baru Berwisata di Banyuwangi</h1>
                                <p class="py-3 font-size-18 d-none d-md-block">"BANYUWANGI TOURISM APP" Trobosan Inovatif
                                    buat panduan kamu pelisiran menikmati indahnya destinasi pariwisata Banyuwangi, dengan
                                    fasilitas booking langsung dalam aplikasi</p>
                                <a href="https://play.google.com/store/apps/details?id=com.bwx.majesticbanyuwangi"
                                    rel="noreferrer" target="_blank" class="theme-btn border-0 mt-3">Download Sekarang <i
                                        class="la la-arrow-right ml-1"></i></a>
                            </div>

                        </div>
                        <div class="d-none d-lg-block" style="position: absolute; top: 50px; right:0;">
                            <img src="{{ asset('upload/img_mobile.png') }}" alt="" class="img-fluid"
                                style="height: 470px ">
                        </div>

                    </div>
                </div>
                <div class="carousel-item" data-interval="10000">
                    <div class="overlay-image"
                        style="opacity: 1; background-image: url('{{ asset('upload/bg-dashboard-festival-2022.png') }}');">
                    </div>
                    <div class="container">
                        <div class="d-none d-lg-block" style="position: absolute; top: 50px; left:0; margin-left:-100px">
                            <img src="{{ asset('upload/img_arong.png') }}" alt="" class="img-fluid"
                                style="height: 400px ">
                        </div>

                        <div class="row justify-content-lg-center">
                            <div class="col col-lg-7 text-center">
                                <h1 class="">Banyuwangi Festival</h1>
                                <p class="py-3 font-size-18 d-none d-md-block ">Kini Banyuwangi Festival <?= date('Y') ?>
                                    adalah trend berwisata
                                    ke Banyuwangi di era pandemi. Dengan colorful hybrid concept penggabungan event/atraksi
                                    secara
                                    offline dengan virtual.</p>
                                <a href="{{ url('festival') }}" class="theme-btn border-0 mt-3 ">Lihat Festival <i
                                        class="la la-arrow-right ml-1"></i></a>
                            </div>
                        </div>

                        <div class="d-none d-lg-block" style="position: absolute; top: 50px; right:0;  margin-right:-100px">
                            <img src="{{ asset('upload/img_arong_kanan.png') }}" alt="" class="img-fluid"
                                style="height: 400px ">
                        </div>

                    </div>
                </div>
                <div class="carousel-item" data-interval="10000">
                    <div class="overlay-image" style="background-image: url('{{ asset('upload/background_pm.jpg') }}');">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7">
                                <h1>Pantai Pulau Merah</h1>
                                <p class="py-3 font-size-18 d-none d-md-block">Salah satu destinasi populer yang ada
                                    dibanyuwangi. Dengan view Pantai berwana merah menjelang sunset Membuat wisatawan merasa
                                    tenang dan nyaman berada di banyuwangi</p>
                                <a href="{{ url('destination') }}" class="theme-btn border-0 mt-3">Explore Destination <i
                                        class="la la-arrow-right ml-1"></i></a>
                            </div>
                        </div>

                        <div class="d-none d-lg-block" style="position: absolute; top: 50px; right:0;">
                            <img src="{{ asset('upload/img_wisatawan.png') }}" alt="" class="img-fluid"
                                style="height: 470px ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-block">
                <ol class="carousel-indicators list-inline">
                    <li class="list-inline-item active">
                        <a href="#" id="carousel-selector-0" class="selected" data-slide-to="0"
                            data-target="#carouselBanner">
                            <img src="{{ url('upload/mobile.png') }}" class="img-thumbnail" alt="image banner"
                                style="border-radius: 15px">
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" id="carousel-selector-1" data-slide-to="1" data-target="#carouselBanner">
                            <img src="{{ url('upload/thumbnail-festival.png') }}" class=" img-thumbnail" alt="image banner"
                                style="border-radius: 15px">
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" id="carousel-selector-2" data-slide-to="2" data-target="#carouselBanner">
                            <img src="{{ url('upload/icon-pm.png') }}" class="img-thumbnail" alt="image banner"
                                style="border-radius: 15px">
                        </a>
                    </li>
                </ol>
            </div>

        </div>


    </section>

    <section class="info-area padding-top-80px padding-bottom-45px">
        <div class="arrow-separator"></div>
        {{-- <div style="position: absolute; height: auto; width:100%; top: -400px; z-index:2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,160L48,186.7C96,213,192,267,288,282.7C384,299,480,277,576,272C672,267,768,277,864,272C960,267,1056,245,1152,234.7C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </div> --}}

        <div class="container">
            <div class="row">
                <div class="col-lg-4 responsive-column">
                    <div class="icon-box icon-layout-2 d-flex align-items-center">
                        <div class="info-icon flex-shrink-0 bg-rgb-3 radius-round-full">
                            <img src="{{ asset('upload/icon-smartphone.svg') }}" class="w-50" alt="" />
                        </div>
                        <div class="info-content">
                            <h4 class="info__title"><a
                                    href="https://play.google.com/store/apps/details?id=com.bwx.majesticbanyuwangi"
                                    rel="noreferrer" target="_blank">BanyuwangiTourism Apps</a></h4>
                            <p class="info__desc">
                                Dapatkan semua fitur dalam satu genggaman
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 responsive-column">
                    <div class="icon-box icon-layout-2 d-flex align-items-center">
                        <div class="info-icon flex-shrink-0 bg-rgb-2 radius-round-full">
                            <img src="{{ asset('upload/icon-bfest.png') }}" class="w-50" alt="icon bfest" />
                        </div>
                        <div class="info-content">
                            <h4 class="info__title">
                                <a href="{{ url('festival') }}" rel="noreferrer"
                                    target="_blank">BFest Colorfull Hybrid Concept</a>
                            </h4>
                            <p class="info__desc">
                                Saksikan keseruan Virtual Event Banyuwangi Festival <?= date('Y') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 responsive-column">
                    <div class="icon-box icon-layout-2 d-flex align-items-center">
                        <div class="info-icon flex-shrink-0 bg-rgb radius-round-full">
                            <img src="{{ asset('upload/360-degree.svg') }}" class="w-50" alt="icon 360 view" />
                        </div>
                        <div class="info-content">
                            <h4 class="info__title"><a href="{{ url('destination') }}">Destination 360°</a></h4>
                            <p class="info__desc">
                                Melihat destinasi Wisata Banyuwangi dengan view 360°
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- festival --}}
    <section
        class="hotel-area section-bg position-relative overflow-hidden padding-top-100px padding-bottom-200px padding-right-100px padding-left-100px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading text-center">
                        <h2 class="sec__title line-height-55">Majestic <br> Banyuwangi Festival</h2>
                    </div>
                </div>
            </div>
            <div class="row padding-top-50px">
                <div class="col-lg-12">
                    <div class="hotel-card-wrap mb-3">
                        <div class="hotel-card-carousel carousel-action">

                            @foreach ($events as $event)
                                <div class="card-item mb-0">
                                    <div class="card-img">
                                        <a href="{{ url('festival/' . $event->slug) }}" class="d-block">
                                            <img src="{{ asset('upload/festival/' . $event->foto) }}"
                                                alt="{{ $event->title }}">
                                        </a>
                                        <span class="badge">{{ $event->fee }}</span>
                                        <div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top"
                                            title="Bookmark">
                                            <i class="la la-heart-o"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><a
                                                href="{{ url('festival/' . $event->slug) }}">{{ $event->title }}</a>
                                        </h3>
                                        <p class="card-meta mb-3">{{ $event->location }}</p>
                                        <div class="card-price d-flex align-items-center justify-content-between">
                                            <p>
                                                <span
                                                    class="price__num">{{ formatTglFestival($event->event_date_from) }}</span>
                                                <span class="price__text">Mulai
                                                    {{ formatJamFestival($event->event_date_from) }}</span>
                                            </p>
                                            <a href="{{ url('festival/' . $event->slug) }}" class="btn-text">See
                                                details<i class="la la-angle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ url('festival') }}" class="theme-btn border-0">
                            Lihat semua Festival
                            <i class="la la-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
            <path d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path>
        </svg>
    </section>

    {{-- Destination --}}
    <section class="top-activity-area padding-top-100px padding-bottom-100px">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="section-heading">
                        <h2 class="sec__title">TOP Destinations</h2>
                        <p class="sec__desc pt-2">Berikut ini daftar wisata yang sering dikunjungi wisatawan.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="btn-box btn--box text-right">
                        <a href="{{ url('destination') }}" class="theme-btn">Explore All <i
                                class="la la-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>

            <div class="row padding-top-50px">

                @foreach ($destination as $des)
                    <div class="col-lg-4 responsive-column">
                        <div class="flip-box">
                            <div class="flip-box-front">
                                <img src="{{ asset('upload/destination/' . $des->foto) }}" alt=""
                                    class="flip-img" />
                                <a href="{{ url('destination/' . $des->slug) }}"
                                    class="flip-content d-flex align-items-end justify-content-start">
                                    <h3 class="flip-title">
                                        {{ $des->title }}
                                    </h3>
                                </a>
                            </div>
                            <div class="flip-box-back">
                                <img src="{{ asset('upload/destination/' . $des->foto) }}" alt=""
                                    class="flip-img" />
                                <a href="{{ url('destination/' . $des->slug) }}"
                                    class="flip-content d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="icon-element mx-auto mb-3 bg-white text-color-2">
                                            <i class="la la-arrow-right"></i>
                                        </div>
                                        <h3 class="flip-title">
                                            Explore Activity
                                        </h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


    <section class="trending-area position-relative section-bg padding-top-100px padding-bottom-100px ">
        {{-- kuliner --}}
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 class="sec__title curve-shape padding-bottom-30px" data-text="curvs">
                            PPKM
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row padding-top-50px">
                <style>
                    .text-desc {
                        font-size: 20px;
                        font-weight: 400;
                        color: #1b1b1b;
                        margin-bottom: 18px;
                        line-height: 28px;
                    }

                    .produk img {
                        width: 100%
                    }

                </style>

                <div class="col-lg-6">

                    <div class="text-desc">
                        PPKM (Promosi Produk Kuliner & Merchandise) <br><br>
                        yang diinisiasi oleh Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi.
                    </div>
                    <div class="text-desc">
                        Cintai Produk UMKM Banyuwangi. Produk lokal buatan asli masyarakat Banyuwangi.
                    </div>
                    <div class="text-desc">
                        Beli dengan cara hubungi kontak yang tersedia pada katalog produk
                    </div>

                    <div class="my-5">
                        <a href="{{ url('produk_ppkm') }}" class="theme-btn border-0">
                            Belanja Sekarang
                            <i class="la la-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        @foreach ($produk_ppkm as $item)
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="produk">
                                        <a class="d-block">
                                            <img src="{{ asset('upload/produk_ppkm/' . $item->foto) }}" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        {{-- handcraft --}}
        {{-- <div class="container padding-top-50px">
    <div class="row">
        <div class="col-lg-12">
            <div class="section-heading">
                <h2 class="sec__title curve-shape padding-bottom-30px" data-text="curvs">
                    Handcraft
                </h2>
            </div>
        </div>
    </div>
    <div class="row padding-top-50px">
        <div class="col-lg-12">
            <div class="trending-carousel carousel-action">

                @foreach ($handcraft as $h)
                    <div class="card-item trending-card mb-0">
                        <div class="card-img">
                            <a href="{{ url('handcraft/' . $h->slug) }}" class="d-block">
                                <img src="{{ asset('upload/handcraft/' . $h->foto) }}"
                                    alt="{{ $h->title }}" />
                            </a>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><a
                                    href="{{ url('handcraft/' . $h->slug) }}">{{ $h->title }}</a></h3>
                            <p class="card-meta mb-3"><i class="las la-map-marker-alt mr-1"></i>
                                {{ $h->address }}</p>
                            <div class="card-price d-flex align-items-center justify-content-between">
                                <p>
                                    @if ($h->price != '')
                                        <span class="price__num">{{ rupiah($h->price) }}</span>
                                    @endif
                                    <span class="price__text">
                                        <a href="call:{{ $h->hp }}"> <i
                                                class="la la-phone mr-1"></i>{{ $h->hp }} </a>
                                    </span>

                                </p>
                                <a href="{{ url('handcraft/' . $h->slug) }}" class="btn-text">See details<i
                                        class="la la-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div> --}}
    </section>

    {{-- testimoni --}}
    <section class="testimonial-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading mb-0">
                        <h2 class="sec__title curve-shape padding-bottom-30px" data-text="curvs">
                            Testimoni
                        </h2>
                    </div>
                    <!-- end section-heading -->
                </div>
                <!-- end col-lg-12 -->
            </div>
            <!-- end row  -->
            <div class="row padding-top-50px">
                <div class="col-lg-12">
                    <div class="testimonial-carousel carousel-action">
                        <!-- end testimonial-card -->
                        <div class="testimonial-card">
                            <div class="testi-desc-box">
                                <p class="testi__desc">
                                    Dengan aplikasi ini,saya dapat melihat dan mencari tiket wisata yang ada di Banyuwangi.
                                    Semoga dengan aplikasi ini Banyuwangi bisa menjadi salah satu destinasi pariwisata
                                    unggulan di Indonesia
                                </p>
                            </div>
                            <div class="author-content d-flex align-items-center">
                                <div class="author-img">
                                    <img src="{{ asset('upload/testi-2.webp') }}" alt="testimonial image" />
                                </div>
                                <div class="author-bio">
                                    <h4 class="author__title">
                                        Ozi Galeri
                                    </h4>
                                    <span class="author__meta">Indonesia</span>
                                    <span class="ratings d-flex align-items-center">
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end testimonial-card -->
                        <div class="testimonial-card">
                            <div class="testi-desc-box">
                                <p class="testi__desc">
                                    App nya mudah, gampang juga pakainya.. buruan yang mau Wisata Ke Banyuwangi Langsung
                                    Download App ini... Berwisata dengan mematuhi segala protokol ya...
                                </p>
                            </div>
                            <div class="author-content d-flex align-items-center">
                                <div class="author-img">
                                    <img src="{{ asset('upload/testi-3.webp') }}" alt="testimonial image" />
                                </div>
                                <div class="author-bio">
                                    <h4 class="author__title">
                                        Ardy arnyth
                                    </h4>
                                    <span class="author__meta">Indonesia</span>
                                    <span class="ratings d-flex align-items-center">
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-card">
                            <div class="testi-desc-box">
                                <p class="testi__desc">
                                    Banyuwangi tourism App sangat membantu....top markotop untuk banyuwangi
                                </p>
                            </div>
                            <div class="author-content d-flex align-items-center">
                                <div class="author-img">
                                    <img src="{{ asset('upload/testi-1.webp') }}" alt="testimonial image" />
                                </div>
                                <div class="author-bio">
                                    <h4 class="author__title">
                                        Idham Holid
                                    </h4>
                                    <span class="author__meta">Indonesia</span>
                                    <span class="ratings d-flex align-items-center">
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-block"></div>

    <section class="cta-area bg-fixed section-padding" style="background-image: url('{{ asset('upload/bg-2.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 class="sec__title text-white font-size-50 line-height-60">
                            Enjoy Your Holiday with<br />
                            BanyuwangiTourism Apps
                        </h2>
                        <p class="sec__desc text-white pt-3">
                            Langsung Pesan Paket Wisata, Tiket Festival, atau Makanan di BanyuwangiTourism Apps
                        </p>
                    </div>
                    <!-- end section-heading -->
                    <div class="btn-box padding-top-35px">
                        <a href="https://play.google.com/store/apps/details?id=com.bwx.majesticbanyuwangi" rel="noreferrer"
                            target="_blank" class="theme-btn border-0">Download Sekarang
                            <i class="la la-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <!-- end col-lg-12 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    <section class="padding-top-80px padding-bottom-80px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading text-center">
                        <h2 class="sec__title font-size-35">
                            Berita Terkini
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row  padding-top-30px">
                @foreach ($news as $n)
                    <div class="col-lg-6 mb-4">
                        <div>
                            <h3 class="font-size-17 mb-2"><a href="{{ url('news', $n->slug) }}"
                                    style="color: #0d233e">{{ $n->title }}</a></h3>
                            <p>
                                <?= lengthChar($n->text, 140) ?>
                            </p>

                            <a href="{{ url('news', $n->slug) }}" class="btn-text">Selengkapnya <i
                                    class="la la-angle-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="clientlogo-area padding-top-80px padding-bottom-80px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading text-center">
                        <h2 class="sec__title font-size-35">
                            Partner Kita
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row padding-top-10px">
                <div class="col-lg-12">
                    <div class="client-logo">
                        <div class="client-logo-item">
                            <img src="{{ asset('upload/partner1.png') }}" alt="brand image" />
                        </div>
                        <div class="client-logo-item">
                            <img src="{{ asset('upload/partner2.png') }}" alt="brand image" />
                        </div>
                        <div class="client-logo-item">
                            <img src="{{ asset('upload/partner3.png') }}" alt="brand image" />
                        </div>
                        <div class="client-logo-item">
                            <img src="{{ asset('upload/partner4.png') }}" alt="brand image" />
                        </div>
                        <div class="client-logo-item">
                            <img src="{{ asset('upload/partner5.png') }}" alt="brand image" />
                        </div>
                        <div class="client-logo-item">
                            <img src="{{ asset('upload/partner6.png') }}" alt="brand image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
