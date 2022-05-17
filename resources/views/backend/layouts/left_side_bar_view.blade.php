<nav class="navbar-default navbar-static-side fixed-menu" role="navigation">
    <div class="sidebar-collapse">
        <div id="hover-menu"></div>
        <ul class="nav metismenu" id="side-menu">
            <li class="menu-bg">
                <div class="logopanel"
                    style="margin-left: 0px; z-index: 99999; background: url({{ asset('assets/images/bg-menu.jpg') }});">
                    <div class="profile-element">
                        <a href="#"><img src="{{ asset('assets/images/logo-web.png') }}"></a>
                    </div>
                    <div class="logo-element">
                        <img src="{{ asset('assets/images/icon.png') }}">
                    </div>
                </div>
            </li>
            <li>
                <div class="leftpanel-profile">
                    <div class="media-left">
                        <a href="#">
                            <img src="@if (Auth::user()->foto != '') {{ asset('upload/user/' . Auth::user()->foto) }}@else{{ asset('assets/images/profile.svg') }} @endif"
                                alt="" class="media-object img-circle">
                        </a>
                    </div>
                    <div class="media-body profile-name" style="white-space:nowrap;">
                        <h4 class="media-heading">{{ Auth::user()->name }}</h4>
                        <span>Administrator</span>
                    </div>
                </div>

            </li>
            <li>
                <div class="nano left-sidebar">
                    <div class="nano-content">
                        <ul class="nav nav-pills nav-stacked nav-inq">
                            <li class="{{ request()->is('admin') ? 'active' : '' }}">
                                <a href="{{ url('admin') }}"><i class="fa fa-home"></i> <span
                                        class="nav-label">Dashboards</span></a>
                            </li>

                            @if (Auth::user()->role == 'pimpinan')
                                <li
                                    class="{{ request()->is('admin/laporan-tiket-gwd', 'admin/laporan-tiket-gwd/*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/laporan-tiket-gwd') }}"><i class="fa fa-newspaper-o"></i>
                                        <span class="nav-label">Tiket GWD & Tabuhan</span></a>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'content-geopark')
                                <li
                                    class="{{ request()->is('admin/geopark-destination', 'admin/geopark-destination/*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/geopark-destination') }}"><i class="fa fa-image"></i>
                                        <span class="nav-label">Destination</span></a>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'content')
                                <li
                                    class="{{ request()->is('admin/destination','admin/destination/*','admin/setting-kuota','admin/setting-kuota/*','admin/destination-tiket','admin/destination-tiket/*','admin/destination-booking','admin/destination-booking/*','admin/destination-category','admin/destination-category/*','admin/booking-gwd','admin/booking-gwd/*','admin/destination-user','admin/destination-user/*','admin/harga-tiket-gwd','admin/harga-tiket-gwd/*')? 'active': '' }} nav-parent">
                                    <a href="#"><i class="fa fa-map-signs"></i> <span
                                            class="nav-label">Destination</span></a>
                                    <ul class="children nav">
                                        <li><a href="{{ url('admin/destination-category') }}">Destination
                                                Category</a></li>
                                        <li><a href="{{ url('admin/destination') }}">Destination Management</a></li>

                                        @if (Auth::user()->role == 'admin')
                                            <li>
                                                <a href="{{ url('admin/setting-kuota') }}">
                                                    Setting Kuota & Hari Libur
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('admin/destination-booking') }}">
                                                    Booking Online
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('admin/booking-gwd') }}">
                                                    Booking GWD
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                                <li
                                    class="{{ request()->is('admin/festival', 'admin/festival/*') ? 'active' : '' }} nav-parent">
                                    <a href="#"><i class="fa fa-calendar"></i> <span
                                            class="nav-label">Event</span></a>
                                    <ul class="children nav">
                                        <li><a href="{{ url('admin/festival') }}">Event Management</a></li>
                                        <li><a href="#">Add Image Event</a></li>
                                    </ul>
                                </li>
                                <li
                                    class="{{ request()->is('admin/culinary', 'admin/culinary/*') ? 'active' : '' }} nav-parent">
                                    <a href="#"><i class="fa fa-coffee"></i> <span
                                            class="nav-label">Cullinary</span></a>
                                    <ul class="children nav">
                                        <li><a href="{{ url('admin/culinary') }}">Culinary Management</a></li>
                                        <li><a href="#">Add Imagee Culinary</a></li>
                                    </ul>
                                </li>
                                <li
                                    class="{{ request()->is('admin/produk_ppkm', 'admin/produk_ppkm/*') ? 'active' : '' }} nav-parent">
                                    <a href="#"><i class="fa fa-gift"></i> <span class="nav-label">Produk
                                            PPKM</span></a>
                                    <ul class="children nav">
                                        <li><a href="{{ url('admin/produk_ppkm') }}">Data Produk</a></li>
                                        <li><a href="#">Add Imagee Produk</a></li>
                                    </ul>
                                </li>
                                <li
                                    class="{{ request()->is('admin/handcraft', 'admin/handcraft/*') ? 'active' : '' }} nav-parent">
                                    <a href="#"><i class="fa fa-gift"></i> <span
                                            class="nav-label">Handcraft</span></a>
                                    <ul class="children nav">
                                        <li><a href="{{ url('admin/handcraft') }}">Handcraft Management</a></li>
                                        <li><a href="#">Add Imagee Handcraft</a></li>
                                    </ul>
                                </li>
                                <li class="{{ request()->is('admin/news', 'admin/news/*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/news') }}"><i class="fa fa-newspaper-o"></i> <span
                                            class="nav-label">News</span></a>
                                </li>
                                <li class="{{ request()->is('admin/hotline', 'admin/hotline/*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/hotline') }}"><i class="fa fa-tty"></i> <span
                                            class="nav-label">Hotline</span></a>
                                </li>

                                <li class="___class_+?44___">
                                    <a href="#"><i class="fa fa-newspaper-o"></i> <span
                                            class="nav-label">Comment</span></a>
                                    <ul class="children nav">
                                        <li><a href="#">Comment Management</a></li>
                                    </ul>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'operator' || Auth::user()->role == 'admin')
                                <li
                                    class="{{ request()->is('admin/laporan-tiket-harian','admin/laporan-tiket-harian/*','admin/laporan-tiket-bulanan','admin/laporan-tiket-bulanan/*','admin/tracking-admin-etax','admin/tracking-admin-etax/*','admin/kelola-admin-etax','admin/kelola-admin-etax/*','admin/admin-etax','admin/admin-etax/*','admin/list-tiket','admin/list-tiket/*')? 'active': '' }} nav-parent">
                                    <a href="#"><i class="fa fa-map-signs"></i> <span
                                            class="nav-label">Eticketing</span></a>
                                    <ul class="children nav">

                                        <li>
                                            <a href="{{ url('admin/laporan-tiket-harian') }}">
                                                Laporan Tiket Harian
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/laporan-tiket-bulanan') }}">
                                                Laporan Tiket Bulanan
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/list-tiket') }}">
                                                Data Tiket
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/tracking-admin-etax') }}">
                                                Tracking User
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/kelola-admin-etax') }}">Kelola Admin</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/admin-etax') }}">Pengajuan Admin</a>
                                        </li>
                                    </ul>
                                </li>

                                <li
                                    class="{{ request()->is('admin/festival-booking', 'admin/festival-booking/*') ? 'active' : '' }} nav-parent">
                                    <a href="#"><i class="fa fa-gift"></i> <span class="nav-label">Festival
                                            Booking</span></a>
                                    <ul class="children nav">
                                        <li><a href="{{ url('admin/festival-booking/price') }}">Ticket Prices</a>
                                        </li>
                                        <li><a href="{{ url('admin/festival-booking/transaction') }}">Tiket
                                                Transactions</a>
                                        </li>
                                        <li><a href="{{ url('admin/festival-booking/pop') }}">Proof of Payment</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                            @if (Auth::user()->role == 'admin')
                                <li
                                    class="{{ request()->is('admin/language', 'admin/language/*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/language') }}"><i class="fa fa-language"></i> <span
                                            class="nav-label">Language</span></a>
                                </li>
                                <li class="{{ request()->is('admin/users', 'admin/users/*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/users') }}"><i class="fa fa-users"></i> <span
                                            class="nav-label">User</span></a>
                                </li>
                            @endif

                            {{-- <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();" id="btn-logout" >
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </li>

                            <form id="formLogout" method="POST" action="{{ route('logout') }}" style="display: block;">
                                {{ csrf_field() }}
                            </form> --}}
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
