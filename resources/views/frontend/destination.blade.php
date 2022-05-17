@extends('frontend._layout')

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi')
@section('title', 'Ayo ke Banyuwangi, Anda pasti ingin kembali')
@section('description', 'Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas kebudayaan dan pariwisata kabupaten banyuwangi')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
<style>
    .blog-card .card-img::before {
        background: linear-gradient(0deg, rgba(13,35,62,1) 0%, rgba(13,35,62,1) 35%, rgba(13,35,62,0) 100%);
    }
    .bread-bg {
        background-image:url({{ asset('upload/bg-festival.jpg')}})
    }
</style>
@endsection

@section('main')

<section class="breadcrumb-area bread-bg">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title text-white">Destination</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="breadcrumb-list text-right">
                        <ul class="list-items">
                            <li><a href="{{ url('/') }}">Dashboard</a></li>
                            <li>Destination</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bread-svg-box">
        <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><polygon points="100 0 50 10 0 0 0 10 100 10"></polygon></svg>
    </div>
</section>



<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="filter-wrap margin-bottom-30px">
                    <div class="filter-top d-flex align-items-center justify-content-between pb-4">
                        <div>
                            <h3 class="title font-size-24">Destination Majestic Banyuwangi</h3>
                            <p class="font-size-16 line-height-20 pt-1">Berikut ini daftar wisata yang sering dikunjungi wisatawan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @foreach($destination as $des)
                    <div class="col-lg-6 responsive-column">
                        <div class="card-item ">
                            <div class="card-img">
                                <a href="{{ url('destination/'. $des->slug) }}" class="d-block">
                                    <img src="{{ asset('upload/destination/'. $des->foto) }}" alt="{{ $des->title }}">
                                </a>
                                <div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for Later">
                                    <i class="la la-heart-o"></i>
                                </div>
                                @if($des->view_360 != '')
                                <span class="badge bg-dark">View 360°</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><a href="{{ url('destination/'. $des->slug) }}">{{ $des->title }}</a></h3>
                                <p class="card-meta"><i class="las la-map-marker-alt mr-1"></i>  {{ $des->address }}</p>
                                <div class="card-rating">
                                    <span class="badge text-white">{{ $des->name }}</span>
                                    <span class="review__text">{{ $des->verified }}</span>
                                    {{-- <span class="rating__text">(30 Reviews)</span> --}}
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                    {{-- <p>
                                        <span class="price__num">{{ $des->hp }}</span>
                                    </p> --}}
                                    <a href="call:{{ $des->hp }}"><span><i class="la la-phone mr-1"></i>{{ $des->hp }}</span></a>

                                    <a href="{{ url('destination/'. $des->slug) }}" class="btn-text">See details<i class="la la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar mt-0">
                    <div class="sidebar-widget">
                        <h3 class="title stroke-shape">Info Terbaru</h3>
                        <a data-src="{{ asset('upload/kalender-2021.jpg') }}" data-fancybox="gallery" data-caption="Kalender Banyuwangi Festival 2021" data-speed="700"  style="cursor: pointer">
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

                    <div class="sidebar-widget">
                        <h3 class="title stroke-shape">Punya Pertanyaan ?</h3>
                        <p class="font-size-14 line-height-24">Jika anda pertanyaan seputar Banyuwangi Tourism Silahkan hubungi kontak dibawah ini :</p>
                        <div class="sidebar-list pt-3">
                            <ul class="list-items">
                                <li><i class="la la-phone icon-element mr-2"></i><a href="#">(0333) 424172</a></li>
                                <li><i class="la la-envelope icon-element mr-2"></i><a href="mailto:bwitourism1@gmail.com">bwitourism1@gmail.com</a></li>
                            </ul>
                        </div>
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