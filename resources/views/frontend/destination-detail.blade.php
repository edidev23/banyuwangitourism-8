@extends('frontend._layout')

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi')
@section('title', $destination->title)
@section('description', 'Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas kebudayaan dan pariwisata kabupaten banyuwangi')

@section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
<style>
    .blog-card .card-img::before {
        background: linear-gradient(0deg, rgba(13,35,62,1) 0%, rgba(13,35,62,1) 35%, rgba(13,35,62,0) 100%);
    }
</style>

<script>
    function initMap() {
      const datalocation = { lat: {{ $destination->lat }}, lng: {{ $destination->lng }} };
      const map = new google.maps.Map(document.getElementById("map"), {
        scaleControl: true,
        center: datalocation,
        zoom: 15,
      });
      const infowindow = new google.maps.InfoWindow();
      infowindow.setContent("<b>{{ $destination->title }}</b>");
      const marker = new google.maps.Marker({ map, position: datalocation });
      marker.addListener("click", () => {
        infowindow.open(map, marker);
      });
    }
  </script>

@endsection

@section('main')

<section class="breadcrumb-area bread-bg-2 py-0">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-btn">
                        <div class="btn-box">
                            @if($destination->view_360 != '')
                            {{-- <a class="theme-btn" data-type="iframe" data-fancybox="video" data-src="{{ $destination->view_360 }}" data-speed="700">
                                <i class="la la-video-camera mr-2"></i>View 360°
                            </a> --}}
                            <a class="theme-btn" href="{{ $destination->view_360 }}" target="_blank">
                                <i class="la la-video-camera mr-2"></i>View 360°
                            </a>
                            @endif
                            <a class="theme-btn" data-src="{{asset('upload/destination/large/'. $destination->foto )}}" data-fancybox="gallery" data-caption="{{ $destination->title }}" data-speed="700">
                                <i class="la la-photo mr-2"></i>FOTO
                            </a>
                        </div>
                        
                        {{-- <a class="d-none" data-fancybox="gallery" data-src="images/destination-img2.jpg" data-caption="Showing image - 02" data-speed="700"></a>
                        <a class="d-none" data-fancybox="gallery" data-src="images/destination-img3.jpg" data-caption="Showing image - 03" data-speed="700"></a>
                        <a class="d-none" data-fancybox="gallery" data-src="images/destination-img4.jpg" data-caption="Showing image - 04" data-speed="700"></a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tour-detail-area padding-bottom-90px">
    <div class="single-content-navbar-wrap menu section-bg" id="single-content-navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background-color: transparent; margin-top: 1rem">
                          <li class="breadcrumb-item"><a href="{{ url('/')}}">Dashboard</a></li>
                          <li class="breadcrumb-item"><a href="{{ url('destination')}}">Destination</a></li>
                          <li class="breadcrumb-item active" aria-current="page">{{ $destination->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="single-content-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-content-wrap padding-top-60px">
                        <div id="description" class="page-scroll">
                            <div class="single-content-item pb-4">
                                <h3 class="title font-size-26">{{ $destination->title }}</h3>
                                <div class="d-flex flex-wrap align-items-center pt-2">
                                    <p class="mr-2"><i class="las la-map-marker-alt mr-2"></i> {{ $destination->address }}</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{asset('upload/destination/large/'. $destination->foto )}}" alt="{{ $destination->title }}" class="img-fluid">
                            </div>
                            <div class="section-block"></div>
                            <div class="single-content-item py-4">
                                <div class="row">
                                    <div class="col-lg-4 responsive-column">
                                        <div class="single-tour-feature d-flex align-items-center mb-3">
                                            <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                <i class="las la-map-marked"></i>
                                            </div>
                                            <div class="single-feature-titles">
                                                <h3 class="title font-size-15 font-weight-medium">Category</h3>
                                                <span class="font-size-13">{{ $destination->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 responsive-column">
                                        <div class="single-tour-feature d-flex align-items-center mb-3">
                                            <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                <i class="las la-certificate"></i>
                                            </div>
                                            <div class="single-feature-titles">
                                                <h3 class="title font-size-15 font-weight-medium">Verified</h3>
                                                <span class="font-size-13">{{ $destination->verified }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 responsive-column">
                                        <div class="single-tour-feature d-flex align-items-center mb-3">
                                            <a href="tell:{{ $destination->hp }}">
                                                <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                    <i class="las la-phone-volume"></i>
                                                </div>
                                            </a>
                                            <div class="single-feature-titles">
                                                <h3 class="title font-size-15 font-weight-medium">Telephone</h3>
                                                <span class="font-size-13">{{ $destination->hp }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($destination->view_360 != '')
                                    <div class="col-lg-12">
                                        <div class="single-tour-feature d-flex align-items-center mb-3">
                                            {{-- <a style="cursor: pointer" data-type="iframe" data-fancybox="video" data-src="{{ $destination->view_360 }}" data-speed="700">
                                                <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                    <i class="la la-video-camera"></i>
                                                </div>
                                            </a> --}}
                                            <a style="cursor: pointer" href="{{ $destination->view_360 }}" target="_blank">
                                                <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                    <i class="la la-video-camera"></i>
                                                </div>
                                            </a>
                                            <div class="single-feature-titles">
                                                <h3 class="title font-size-15 font-weight-medium">View 360°</h3>
                                                <span class="font-size-13">Lihat lokasi dengan foto 360°</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="section-block"></div>
                            <div class="single-content-item padding-top-40px padding-bottom-40px">
                                <h3 class="title font-size-20">Description</h3>
                                <p class="py-3">{{ $destination->description }}</p>
                            </div>
                            <div class="section-block"></div>
                            <div class="single-content-item">
                                <h3 class="title font-size-20 mb-3">Location Maps</h3>
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar single-content-sidebar mb-0">
                        <div class="sidebar-widget single-content-widget">
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

                        <div class="sidebar-widget single-content-widget">
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
    </div>
</section>

@endsection

@section('js')
    <script src="{{ url('frontend/js/jquery.fancybox.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPNr2k3C6EcXO8805uKg7j1klqR3iqxF8&callback=initMap&libraries=&v=weekly"
      async></script>
@endsection