@extends('frontend._layout')

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi')
@section('title', 'Ayo ke Banyuwangi, Anda pasti ingin kembali')
@section('description',
    'Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas
    kebudayaan dan pariwisata kabupaten banyuwangi',)

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
    <style>
        .blog-card .card-img::before {
            background: linear-gradient(0deg, rgba(13, 35, 62, 1) 0%, rgba(13, 35, 62, 1) 35%, rgba(13, 35, 62, 0) 100%);
        }

        .bread-bg {
            background-image: url({{ asset('upload/bg-festival.jpg') }})
        }

        .content {
            position: relative;
        }

        .produk {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: black;
            opacity: 0;
            transition: all .3s ease;
        }

        .content:hover .produk {
            opacity: .3;
        }


        .produk-info {
            display: none;
            position: absolute;
            top: 40%;
            left: 0;
            height: 100%;
            width: 100%;
            text-align: center;
        }

        .content:hover .produk-info {
            display: block;
        }

        .link-sosmed {
            margin-right: 1.5rem;
            margin-bottom: 10px;
        }

        .icon-sosmed {
            height: 40px;
            width: 40px";

        }

    </style>
@endsection

@section('main')

    <div id="app">
        <section class="breadcrumb-area bread-bg">
            <div class="breadcrumb-wrap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="breadcrumb-content">
                                <div class="section-heading">
                                    <h2 class="sec__title text-white">Produk PPKM</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="breadcrumb-list text-right">
                                <ul class="list-items">
                                    <li><a href="{{ url('/') }}">Dashboard</a></li>
                                    <li>Produk PPKM</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bread-svg-box">
                <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10"
                    preserveAspectRatio="none">
                    <polygon points="100 0 50 10 0 0 0 10 100 10"></polygon>
                </svg>
            </div>
        </section>

        <section class="card-area section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="filter-wrap">
                            <div class="filter-top d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="title font-size-24">Promosi Produk Kuliner dan Merchandise</h3>
                                    <p class="font-size-16 line-height-20 pt-1">Produk Kuliner dan Merchandise Asli
                                        Banyuwangi
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6" v-for="produk in produk_ppkm" :key="produk.id">
                                <div class="mb-4">
                                    <a href="#" class="d-block" @click.prevent="openModal(produk)">
                                        <div class="content">
                                            <img :src="img_url(produk.foto)" class="w-100" />
                                            <div class="produk"></div>
                                            <div class="produk-info">
                                                <div class="btn btn-info rounded-pill">
                                                    @{{ produk . name }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="row">
                                        <div class="col-lg-5 text-center" v-if="detail_produk.foto">
                                            <img :src="img_large(detail_produk.foto)" class="w-100" />
                                        </div>
                                        <div class="col-lg-7 col-md-12">
                                            <div class="p-3">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>

                                                <div>
                                                    <h3 class="my-3" style="font-size: 24px">
                                                        @{{ detail_produk . name }}
                                                    </h3>
                                                    <div class="badge badge-primary mb-2"
                                                        style="font-size: 16px; text-transform: Capitalize">
                                                        @{{ detail_produk . category == 'makanan' ? 'Produk Kuliner' : 'Merchandise' }}
                                                    </div>

                                                    <p class="mb-5" style="font-size: 18px">
                                                        @{{ detail_produk . description }}
                                                    </p>

                                                    <div class="mb-3" style="font-size: 22px; font-weight: bold">
                                                        Order By :
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <a :href="'https://api.whatsapp.com/send?phone=' + detail_produk.whatsapp + '&text=Halo%20Saya%20Mau%20Pesan%20' + detail_produk.name"
                                                            class="link-sosmed" v-if="detail_produk.whatsapp">
                                                            <i>
                                                                <img src="{{ asset('frontend/images/whatsapp.svg') }}"
                                                                    class="icon-sosmed" alt="whatsapp" />
                                                            </i>
                                                            <span>Whatsapp</span>
                                                        </a>
                                                        <a :href="'https://instagram.com/' + detail_produk.instagram"
                                                            class="link-sosmed" v-if="detail_produk.instagram"
                                                            target="_blank">
                                                            <i>
                                                                <img src="{{ asset('frontend/images/instagram.svg') }}"
                                                                    class="icon-sosmed" alt="instagram" />
                                                            </i>
                                                            <span>Instagram</span>
                                                        </a>
                                                        {{-- <a :href="'https://facebook.com/' + detail_produk.facebook"
                                                            class="link-sosmed" v-if="detail_produk.facebook">
                                                            <i>
                                                                <img src="{{ asset('frontend/images/facebook.svg') }}"
                                                                    class="icon-sosmed" alt="facebook" />
                                                            </i>
                                                            <span>Facebook</span>
                                                        </a> --}}
                                                        <a :href="detail_produk.website" class="link-sosmed"
                                                            target="_blank" v-if="detail_produk.website">
                                                            <i>
                                                                <img src="{{ asset('frontend/images/world-wide.svg') }}"
                                                                    class="icon-sosmed" alt="website" />
                                                            </i>
                                                            <span>Website</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar mt-0">
                            <div class="sidebar-widget">
                                <h3 class="title stroke-shape">Info Terbaru</h3>
                                <a data-src="{{ asset('upload/kalender-2021.jpg') }}" data-fancybox="gallery"
                                    data-caption="Kalender Banyuwangi Festival 2021" data-speed="700"
                                    style="cursor: pointer">
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
                                <p class="font-size-14 line-height-24">Jika anda pertanyaan seputar Banyuwangi Tourism
                                    Silahkan
                                    hubungi kontak dibawah ini :</p>
                                <div class="sidebar-list pt-3">
                                    <ul class="list-items">
                                        <li><i class="la la-phone icon-element mr-2"></i><a href="#">(0333) 424172</a></li>
                                        <li><i class="la la-envelope icon-element mr-2"></i><a
                                                href="mailto:bwitourism1@gmail.com">bwitourism1@gmail.com</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection

@section('js')
    <script src="{{ url('frontend/js/jquery.fancybox.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

    <script>
        // import modal from './produk-modal';

        const app = new Vue({
            el: "#app",
            data: {
                base_url: "<?= asset('/upload/produk_ppkm') ?>",
                produk_ppkm: [],
                detail_produk: {}
            },
            mounted() {
                this.getProduk()
            },
            methods: {
                getProduk() {
                    fetch("/api/produk-ppkm")
                        .then(response => response.json())
                        .then(data => {
                            this.produk_ppkm = data
                            // console.log(this.produk_ppkm)
                        });
                },
                openModal(produk) {
                    $('#modalDetail').modal('toggle');
                    this.detail_produk = produk
                },
                img_url(foto) {
                    return this.base_url + '/' + foto
                },
                img_large(foto) {
                    return this.base_url + '/large/' + foto
                }
            },
        })
    </script>
@endsection
