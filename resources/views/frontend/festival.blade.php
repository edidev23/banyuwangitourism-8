@extends('frontend._layout')

@section('keywords', 'Banyuwangi, kabupaten banyuwangi, banyuwangitourism, pariwisata banyuwangi, wisata banyuwangi')
@section('title', 'Ayo ke Banyuwangi, Anda pasti ingin kembali')
@section('description',
    'Banyuwangitourism adalah website promosi pariwisata Banyuwangi yang dikelola oleh dinas
    kebudayaan dan pariwisata kabupaten banyuwangi')

@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}">
    <style>
        .blog-card .card-img::before {
            background: linear-gradient(0deg, rgba(13, 35, 62, 1) 0%, rgba(13, 35, 62, 1) 35%, rgba(13, 35, 62, 0) 100%);
        }

        .bread-bg {
            background-image: url({{ asset('upload/bg-festival.jpg') }})
        }

        .item-filter {
            margin: 2% 1%;
        }

        .sort-button {
            position: absolute;
            right: 0;
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
                                <h2 class="sec__title text-white">Festival</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="breadcrumb-list text-right">
                            <ul class="list-items">
                                <li><a href="{{ url('/') }}">Dashboard</a></li>
                                <li>Festival</li>
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
                <div class="col-lg-12">
                    <div class="filter-wrap margin-bottom-30px">
                        <div class="filter-top d-flex align-items-center justify-content-between pb-4">
                            <div>
                                <h3 class="title font-size-24">Majestic Banyuwangi Festival</h3>
                                <p class="font-size-16 line-height-20 pt-1">Berikut ini event yang akan diselenggarakan di
                                    Banyuwangi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    {{-- vue 2 --}}
                    <div id="app">
                        <div class="filter-bar d-flex mb-3">
                            <div class="item-filter">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control" v-model="month"
                                    @change="changeDataApi()">
                                    <option value="all">All</option>
                                    <option v-for="item in listMonth" v-bind:value="item">@{{ item }}</option>
                                </select>
                            </div>

                            <div class="item-filter">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control" v-model="year"
                                    @change="changeDataApi()">
                                    <option v-for="item in listYear" v-bind:value="item">@{{ item }}</option>
                                </select>
                            </div>

                            <div class="item-filter" style="position: relative">
                                <label for="sort">Urutkan</label>

                                <span v-on:click="ascending = !ascending" class="sort-button">
                                    <i v-if="ascending" class="las la-sort-alpha-down"></i>
                                    <i v-else class="las la-sort-alpha-up"></i>
                                </span>

                                <select name="sort" id="sort" class="form-control" v-model="sortBy">
                                    <option value="title">Nama</option>
                                    <option value="event_date">Tanggal Event</option>
                                </select>
                            </div>

                            <div class="item-filter">
                                <label for="keyword">Cari Festival</label>
                                <input type="text" placeholder="Masukkan judul" class="form-control" name="keyword"
                                    v-model="keyword" id="keyword">
                            </div>

                            <div class="item-filter d-flex align-items-end justify-content-end flex-fill">
                                <button class="btn btn-info" @click.prevent="resetFilter()">Reset Filter</button>
                            </div>
                        </div>

                        <div class="card-item card-item-list" v-for="data in searchResult" :key="data.id">
                            <div class="card-img">
                                <a :href="link(data.slug)" class="d-block">
                                    <img :src="img_url(data.foto)">
                                </a>
                                <div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top"
                                    title="" data-original-title="Save for Later">
                                    <i class="la la-heart-o"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><a :href="link(data.slug)">@{{ data.title }}</a></h3>
                                <p class="card-meta mb-3"><i class="las la-map-marker-alt mr-1"></i>
                                    @{{ data.location }}</p>

                                <div class="card-price d-flex align-items-center justify-content-between">
                                    <p>
                                        <span class="price__num">@{{ displayDate(data.event_date_from) }}</span>
                                        <span class="price__text">Mulai @{{ displayTime(data.event_date_from) }} WIB
                                        </span>
                                    </p>

                                    <a :href="link(data.slug)" class="btn-text">See details<i class="la la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning text-center" v-if="searchResult.length == 0">
                            Data Festival tidak ditemukan !
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar mt-0">
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

                        <div class="sidebar-widget">
                            <h3 class="title stroke-shape">Punya Pertanyaan ?</h3>
                            <p class="font-size-14 line-height-24">Jika anda pertanyaan seputar Banyuwangi Tourism Silahkan
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

@endsection

@section('js')
    <script src="{{ url('frontend/js/popper.min.js') }}"></script>
    <script src="{{ url('frontend/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ url('frontend/js/jquery.fancybox.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                ascending: true,
                base_url: "<?= asset('/upload/festival') ?>",
                site_url: "<?= url('/festival') ?>",
                month: 'all', 
                year: moment().format("YYYY"),
                sortBy: 'event_date',
                orderBy: 'DESC',
                keyword: '',
                listMonth: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
                ],
                listYear: ['2021', '2022'],
                events: []
            },
            methods: {
                getData() {
                    let month = this.getMonthNumber(this.month)

                    fetch('/api/festival-by-month/' + month + '?' + new URLSearchParams({
                            year: this.year,
                            orderBy: this.orderBy,
                        }))
                        .then(response => response.json())
                        .then(data => {
                            this.events = data
                        });
                },
                link(slug) {
                    return this.site_url + '/' + slug
                },
                img_url(foto) {
                    return this.base_url + '/' + foto
                },
                resetFilter() {
                    this.month = moment().format("MM")

                    console.log(this.month)
                    this.year = moment().format("YYYY")
                    this.sortBy = 'event_date'
                    this.orderBy = 'DESC'
                    this.ascending = false
                    this.keyword = ''

                    this.getData()
                },
                changeDataApi() {
                    this.getData()
                },
                getMonthNumber(month) {
                    if (month == "Januari") {
                        return '01'
                    } else if (month == "Februari") {
                        return '02'
                    } else if (month == "Maret") {
                        return '03'
                    } else if (month == "April") {
                        return '04'
                    } else if (month == "Mei") {
                        return '05'
                    } else if (month == "Juni") {
                        return '06'
                    } else if (month == "Juli") {
                        return '07'
                    } else if (month == "Agustus") {
                        return '08'
                    } else if (month == "September") {
                        return '09'
                    } else if (month == "Oktober") {
                        return '10'
                    } else if (month == "Nopember") {
                        return '11'
                    } else if (month == "Desember") {
                        return '12'
                    } else {
                        return 'all'
                    }
                },
                displayDate(date) {
                    return moment(date).format('DD MMM YYYY');
                },
                displayTime(date) {
                    return moment(date).format('hh : mm');
                }

            },
            mounted() {
                this.getData()
            },
            computed: {
                searchResult() {
                    let dataEvent = this.events
                    if (this.keyword != '' && this.keyword) {
                        dataEvent = dataEvent.filter((item) => {
                            return item.title
                                .toUpperCase()
                                .includes(this.keyword.toUpperCase())
                        })
                    }

                    dataEvent = dataEvent.sort((a, b) => {
                        if (this.sortBy == 'title') {
                            let fa = a.title.toLowerCase(),
                                fb = b.title.toLowerCase()

                            if (fa < fb) {
                                return -1
                            }
                            if (fa > fb) {
                                return 1
                            }
                            return 0

                            // Sort by event date to
                        } else if (this.sortBy == 'event_date') {

                            return new Date(a.event_date_to) - new Date(b.event_date_to)
                        }
                    })

                    if (!this.ascending) {
                        dataEvent.reverse()
                    }

                    return dataEvent
                }
            }
        })
    </script>
@endsection
