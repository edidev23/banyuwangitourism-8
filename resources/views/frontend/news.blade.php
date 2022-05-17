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
                            <h2 class="sec__title text-white">News</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="breadcrumb-list text-right">
                        <ul class="list-items">
                            <li><a href="{{ url('/') }}">Dashboard</a></li>
                            <li>News</li>
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
                            <h3 class="title font-size-24">Berita Banyuwangi</h3>
                            <p class="font-size-16 line-height-20 pt-1">Berita terbaru seputar pariwisata Banyuwangi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @foreach ($news as $news)
                    <div class="card-item card-item-list ">
                        <div class="card-img">
                            <a href="{{ url('news/'. $news->slug) }}" class="d-block">
                                <img src="{{ asset('upload/news/'. $news->foto)}}" alt="{{ $news->title }}">
                            </a>
                            <div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for Later">
                                <i class="la la-heart-o"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><a href="{{ url('news/'. $news->slug) }}">{{ $news->title }}</a></h3>
                            <p class="card-meta my-2"><i class="las la-newspaper mr-1"></i>  {{ $news->category }} &nbsp;&nbsp;&nbsp; <i class="las la-calendar-week mr-1"></i> {{ formatTglFestival($news->created_at) }}</p>

                            <p class="mb-3"><?= lengthChar($news->text, 250) ?></p>
                           
                            <div class="card-price d-flex align-items-center justify-content-between">
                                <a href="{{ url('news/'. $news->slug) }}" class="btn-text">Read More<i class="la la-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
    <script src="{{ url('frontend/js/jquery.fancybox.min.js') }}"></script>
@endsection