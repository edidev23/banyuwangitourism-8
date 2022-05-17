@extends('frontend._layout')

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi ')
@section('title', 'Gaya baru berwisata di Banyuwangi')
@section('description',
    'Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas
    kebudayaan dan pariwisata kabupaten banyuwangi')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
    <style>
        .blog-card .card-img::before {
            background: linear-gradient(0deg, rgba(13, 35, 62, 1) 0%, rgba(13, 35, 62, 1) 35%, rgba(13, 35, 62, 0) 100%);
        }

    </style>
@endsection

@section('main')
    <section class="breadcrumb-area bread-bg-2">
        <div class="breadcrumb-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="breadcrumb-content">
                            <div class="section-heading">
                                <h2 class="sec__title text-white">Gaya Baru Berwisata di Banyuwangi</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="breadcrumb-list text-right">
                            <ul class="list-items">
                                <li><a href="{{ url('/') }}">Dashboard</a></li>
                                <li>{{ lengthChar('Gaya Baru Berwisata di Banyuwangi', 200) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bread-svg-box">
            <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
                <polygon points="100 0 50 10 0 0 0 10 100 10"></polygon>
            </svg>
        </div>
    </section>

    <section class="card-area section--padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="card-title font-size-28">Gaya Baru Berwisata di Banyuwangi, Kamu bisa simak dibawah ini ya !
                    </h3>
                    <div class="card-item blog-card blog-card-layout-2 blog-single-card mb-5">
                        <div class="card-img before-none">
                            <object style="width:100%; height: 600px;" type="application/pdf"
                                data="{{ asset('upload/') }}/modul-penggunaan-banyuwangitourism-app.pdf?#zoom=auto&scrollbar=0&toolbar=0&navpanes=0">
                                <p>Insert your error message here, if the PDF cannot be displayed.</p>
                            </object>
                            {{-- <img src="" alt="Banyuwangi Tourism"> --}}
                        </div>
                    </div>
                    <div class="section-block"></div>
                    <p class="card-text pt-3">Pedoman Teknis ini untuk memudahkan para wisatawan untuk menggunakan aplikasi
                        Banyuwangi Tourism. Bisa download panduan nya dengan link di bawah ini :</p>
                    <a href="{{ asset('upload/') }}/modul-penggunaan-banyuwangitourism-app.pdf" target="_blank">Modul
                        Penggunaan Aplikasi BanyuwangiTourism</a>

                    <div class="section-block"></div>
                    <p class="card-text py-3">Belum punya aplikasi BanyuwangiTourism ? Yuk segera Install dan nikmati
                        Indahnya Pariwisata Banyuwangi</p>
                    <a href="https://play.google.com/store/apps/details?id=com.bwx.majesticbanyuwangi" rel="noreferrer"
                        target="_blank" class="theme-btn">Download Sekarang</a>


                    <hr style="margin-top: 70px">

                    <div style="margin-top: 100px">
                        <h3 class="card-title" style="font-size: 20px">
                            PEDOMAN TEKNIS PENGGUNAAN FITUR NJAJAN KULINER (KAMPUNG WISATA KULINER)
                            DI APLIKASI BANYUWANGI TOURISM APP
                        </h3>

                        <div class="card-item blog-card blog-card-layout-2 blog-single-card mb-5">
                            <div class="card-img before-none">
                                <object style="width:100%; height: 600px;" type="application/pdf"
                                    data="{{ asset('upload/') }}/pedoman_kuliner.pdf?#zoom=auto&scrollbar=0&toolbar=0&navpanes=0">
                                    <p>Insert your error message here, if the PDF cannot be displayed.</p>
                                </object>
                                {{-- <img src="" alt="Banyuwangi Tourism"> --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="sidebar mb-0">

                        <div class="sidebar-widget">
                            <h3 class="title stroke-shape">Info Terbaru</h3>

                            <a data-src="{{ asset('upload/kalender-2021.jpg') }}" data-fancybox="gallery"
                                data-caption="Kalender Banyuwangi Festival 2021" data-speed="700" style="cursor: pointer">
                                <div class="card-item blog-card mb-0">
                                    <div class="card-img">
                                        <img src="{{ asset('upload/kalender-2021.jpg') }}" alt="kalender festival">
                                        <div class="post-format icon-element">
                                            <i class="la la-photo"></i>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title line-height-26">
                                                Kalender Banyuwangi Festival 2021
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="{{ url('frontend/js/jquery.fancybox.min.js') }}"></script>
@endsection
