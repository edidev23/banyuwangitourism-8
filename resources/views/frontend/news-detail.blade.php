@extends('frontend._layout')

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi')
@section('title', $news_detail->title)
@section('description', 'Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas kebudayaan dan pariwisata kabupaten banyuwangi')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
<style>
    .blog-card .card-img::before {
        background: linear-gradient(0deg, rgba(13,35,62,1) 0%, rgba(13,35,62,1) 35%, rgba(13,35,62,0) 100%);
    }

    p {
        margin-bottom: 1rem
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
                            <h2 class="sec__title text-white">Detail News</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="breadcrumb-list text-right">
                        <ul class="list-items">
                            <li><a href="{{ url('/') }}">Dashboard</a></li>
                            <li><a href="{{ url('news') }}">News</a></li>
                            <li>{{ lengthChar($news_detail->title, 200) }}</li>
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
            <div class="col-lg-8">
                <div class="card-item blog-card blog-card-layout-2 blog-single-card mb-5">
                    <div class="card-img before-none">
                        <img src="{{ asset('upload/news/large/'. $news_detail->foto)}}" alt="{{ $news_detail->title }}">
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="post-categories">
                            <a href="#" class="badge">{{ $news_detail->category }}</a>
                            <a href="#" class="badge">{{ $news_detail->sumber }}</a>
                        </div>
                        <h3 class="card-title font-size-28">{{ $news_detail->title }}</h3>
                        <p class="card-meta pb-3">
                            <span class="post__author">By <a href="#" class="text-gray">Admin</a></span>
                            <span class="post-dot"></span>
                            <span class="post__date"> {{ formatTglFestival($news_detail->created_at)}}</span>
                        </p>
                        <div class="section-block"></div>
                        <p class="card-text"><?= $news_detail->text ?></p>
                        
                    </div>
                </div>
                <div class="section-block"></div>
                {{-- <div class="comments-list pt-5">
                    <h3 class="title">Showing 3 Comments</h3>
                    <div class="comment pt-5">
                        <div class="comment-avatar">
                            <img class="avatar__img" alt="" src="images/team8.jpg">
                        </div>
                        <div class="comment-body">
                            <div class="meta-data">
                                <h3 class="comment__author">Jenny Doe</h3>
                                <div class="meta-data-inner">
                                    <p class="comment__date">April 5, 2019</p>
                                </div>
                            </div>
                            <p class="comment-content">
                                Lorem ipsum dolor sit amet, dolores mandamus moderatius ea ius, sed civibus vivendum imperdiet ei, amet tritani sea id. Ut veri diceret fierent mei, qui facilisi suavitate euripidis
                            </p>
                            <div class="comment-reply">
                                <a class="theme-btn" href="#" data-toggle="modal" data-target="#replayPopupForm">
                                    <span class="la la-mail-reply mr-1"></span>Reply
                                </a>
                            </div>
                        </div>
                    </div><!-- end comments -->
                    <div class="comment comment-reply-item">
                        <div class="comment-avatar">
                            <img class="avatar__img" alt="" src="images/team9.jpg">
                        </div>
                        <div class="comment-body">
                            <div class="meta-data">
                                <h3 class="comment__author">Jenny Doe</h3>
                                <div class="meta-data-inner">
                                    <p class="comment__date">April 5, 2019</p>
                                </div>
                            </div>
                            <p class="comment-content">
                                Lorem ipsum dolor sit amet, dolores mandamus moderatius ea ius, sed civibus vivendum imperdiet ei, amet tritani sea id. Ut veri diceret fierent mei, qui facilisi suavitate euripidis
                            </p>
                            <div class="comment-reply">
                                <a class="theme-btn" href="#" data-toggle="modal" data-target="#replayPopupForm">
                                    <span class="la la-mail-reply mr-1"></span>Reply
                                </a>
                            </div>
                        </div>
                    </div><!-- end comments -->
                    <div class="comment">
                        <div class="comment-avatar">
                            <img class="avatar__img" alt="" src="images/team10.jpg">
                        </div>
                        <div class="comment-body">
                            <div class="meta-data">
                                <h3 class="comment__author">Jenny Doe</h3>
                                <div class="meta-data-inner">
                                    <p class="comment__date">April 5, 2019</p>
                                </div>
                            </div>
                            <p class="comment-content">
                                Lorem ipsum dolor sit amet, dolores mandamus moderatius ea ius, sed civibus vivendum imperdiet ei, amet tritani sea id. Ut veri diceret fierent mei, qui facilisi suavitate euripidis
                            </p>
                            <div class="comment-reply">
                                <a class="theme-btn" href="#" data-toggle="modal" data-target="#replayPopupForm">
                                    <span class="la la-mail-reply mr-1"></span>Reply
                                </a>
                            </div>
                        </div>
                    </div><!-- end comments -->
                    <div class="btn-box load-more text-center">
                        <button class="theme-btn theme-btn-small theme-btn-transparent" type="button">Load More Comment</button>
                    </div>
                </div> --}}
                <div class="comment-forum pt-5">
                    <div class="form-box">
                        <div class="form-title-wrap">
                            <h3 class="title">Tinggalkan komentar</h3>
                        </div>
                        <div class="form-content">
                            <div class="contact-form-action">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-lg-6 responsive-column">
                                            <div class="input-box">
                                                <label class="label-text">Nama</label>
                                                <div class="form-group">
                                                    <span class="la la-user form-icon"></span>
                                                    <input class="form-control" type="text" name="text" placeholder="Your name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 responsive-column">
                                            <div class="input-box">
                                                <label class="label-text">Email</label>
                                                <div class="form-group">
                                                    <span class="la la-envelope-o form-icon"></span>
                                                    <input class="form-control" type="email" name="email" placeholder="Email address">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-box">
                                                <label class="label-text">Pesan</label>
                                                <div class="form-group">
                                                    <span class="la la-pencil form-icon"></span>
                                                    <textarea class="message-control form-control" name="message" placeholder="Write message"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="chbyes">
                                                    <label for="chbyes">Save my name, email, and website in this browser for the next time I comment.</label>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-12">
                                            <div class="btn-box">
                                                <button type="button" class="theme-btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar mb-0">
                    <div class="sidebar-widget">
                        <div class="section-tab section-tab-2 pb-3">
                            <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="lokal-tab" data-toggle="tab" href="#lokal" role="tab" aria-controls="lokal" aria-selected="true">
                                        Lokal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nasional-tab" data-toggle="tab" href="#nasional" role="tab" aria-controls="nasional" aria-selected="false">
                                        Nasional
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="manca-tab" data-toggle="tab" href="#manca" role="tab" aria-controls="manca" aria-selected="false">
                                        Manca
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="lokal" role="tabpanel" aria-labelledby="lokal-tab">
                                @foreach($news as $n)
                                <div class="card-item card-item-list recent-post-card">
                                    <div class="card-img">
                                        <a href="{{ url('news/'. $n->slug)}}" class="d-block">
                                            <img src="{{ asset('upload/news/'. $n->foto)}}" alt="{{ $n->title}}">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><a href="{{ url('news/'. $n->slug)}}">{{ lengthChar($n->title, 40) }}</a></h3>
                                        <p class="card-meta">
                                            <span class="post__date"> {{ formatTglFestival($n->created_at) }}</span>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div><!-- end tab-pane -->
                            <div class="tab-pane" id="nasional" role="tabpanel" aria-labelledby="nasional-tab">
                                <p>Tidak ada berita</p>
                            </div><!-- end tab-pane -->
                            <div class="tab-pane" id="manca" role="tabpanel" aria-labelledby="manca-tab">
                                <p>Tidak ada berita</p>
                            </div><!-- end tab-pane -->
                        </div>
                    </div>

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
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
    <script src="{{ url('frontend/js/jquery.fancybox.min.js') }}"></script>
@endsection