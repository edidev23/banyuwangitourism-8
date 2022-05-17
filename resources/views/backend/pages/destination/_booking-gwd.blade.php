@extends('backend/layouts/template')

@section('title', 'Booking GWD')

@section('bread')
    <h2>Booking GWD</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Booking GWD</strong></li>
    </ol>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/datepicker.css') }}" />

    <style>
        .box-botton-right {
            display: flex;
            align-items: end;
            height: 66px;
            justify-content: end;
        }

    </style>
@endsection

@section('main')

    <div class="row">
        <div class="col-lg-12">
            <div class="inqbox">
                <div class="inqbox-title border-top-success">
                    <h5>Laporan Bulan {{ bulanString($dataReturn->bulan) }} - Tiket GWD</h5>
                </div>
                <div class="inqbox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('admin/booking-gwd') }}" method="get">
                                <div class="row" style="margin-bottom: 10px; margin-left: 0;">
                                    <div class="col-md-4 datepicker">
                                        <label for="month">Pilih Bulan</label>
                                        <select name="month" id="month" class="form-control">
                                            <option value="01" @if($dataReturn->bulan == "01") selected @endif>Januari</option>
                                            <option value="02" @if($dataReturn->bulan == "02") selected @endif>Februari</option>
                                            <option value="03" @if($dataReturn->bulan == "03") selected @endif>Maret</option>
                                            <option value="04" @if($dataReturn->bulan == "04") selected @endif>April</option>
                                            <option value="05" @if($dataReturn->bulan == "05") selected @endif>Mei</option>
                                            <option value="06" @if($dataReturn->bulan == "06") selected @endif>Juni</option>
                                            <option value="07" @if($dataReturn->bulan == "07") selected @endif>Juli</option>
                                            <option value="08" @if($dataReturn->bulan == "08") selected @endif>Agustus</option>
                                            <option value="09" @if($dataReturn->bulan == "09") selected @endif>September</option>
                                            <option value="10" @if($dataReturn->bulan == "10") selected @endif>Oktober</option>
                                            <option value="11" @if($dataReturn->bulan == "11") selected @endif>Nopember</option>
                                            <option value="12" @if($dataReturn->bulan == "12") selected @endif>Desember</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 28px">
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 box-botton-right">
                            <div class="mt-3">
                                <a href="{{ url('admin/booking-gwd/list-tiket') }}" class="btn btn-info mr-2">
                                    Data Tiket
                                </a>

                                <a href="{{ url('admin/harga-tiket-gwd') }}" class="btn btn-info">
                                    Setting Harga
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th width="100px">Tanggal</th>
                                    <th>Pengunjung Tabuhan</th>
                                    <th>Tiket Tabuhan</th>
                                    <th>Glass Bottom [Wahana]</th>
                                    <th>Tiket Glass Bottom [Wahana]</th>
                                    <th>Mandi Bola [Wahana]</th>
                                    <th>Tiket Mandi Bola [Wahana]</th>
                                    <th>Kano [Wahana]</th>
                                    <th>Tiket Kano [Wahana]</th>
                                    <th>Total Pengunjung</th>
                                    <th>Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $jml_pengunjung = 0;
                                $total_tiket = 0;

                                $jml_tabuhan = 0;
                                $total_tabuhan = 0;

                                $jml_glass_bottom = 0;
                                $total_glass_bottom = 0;
                                
                                $jml_mandi_bola = 0;
                                $total_mandi_bola = 0;
                                
                                $jml_kano = 0;
                                $total_kano = 0;
                                

                                ?>

                                @foreach ($dataReturn->tiket as $d)
                                    <?php
                                    $jml_pengunjung = $jml_pengunjung + $d['jml_pengunjung'];
                                    $total_tiket = $total_tiket + $d['total_tiket'];

                                    $jml_tabuhan = $jml_tabuhan + $d['jml_tabuhan'];
                                    $total_tabuhan = $total_tabuhan + $d['tiket_tabuhan'];
                                    $jml_glass_bottom = $jml_glass_bottom + $d['jml_glass_bottom'];
                                    $total_glass_bottom = $total_glass_bottom + $d['tiket_glass_bottom'];
                                    $jml_mandi_bola = $jml_mandi_bola + $d['jml_mandi_bola'];
                                    $total_mandi_bola = $total_mandi_bola + $d['tiket_mandi_bola'];
                                    $jml_kano = $jml_kano + $d['jml_kano'];
                                    $total_kano = $total_kano + $d['tiket_kano'];
                                    
                                    ?>

                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ tanggal_id($d['tanggal']) }}</td>
                                        <td>{{ $d['jml_tabuhan'] }} Orang</td>
                                        <td>{{ rupiah($d['tiket_tabuhan']) }}</td>
                                        <td>{{ $d['jml_glass_bottom'] }} Orang</td>
                                        <td>{{ rupiah($d['tiket_glass_bottom']) }}</td>
                                        <td>{{ $d['jml_mandi_bola'] }} Orang</td>
                                        <td>{{ rupiah($d['tiket_mandi_bola']) }}</td>
                                        <td>{{ $d['jml_kano'] }} Orang</td>
                                        <td>{{ rupiah($d['tiket_kano']) }}</td>
                                        <td>{{ $d['jml_pengunjung'] }} Orang</td>
                                        <td>{{ rupiah($d['total_tiket']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="inbox" style="margin-bottom: 20px">
                <div class="inqbox-title border-top-success">
                    <h5>Rekap Bulan {{ bulanString($dataReturn->bulan) }}</h5>
                </div>
                <div class="inqbox-content">
                    <table class="table table-bordered">
                        <tr>
                            <th>Jumlah Pengunjung Tabuhan</th>
                            <td>{{ $jml_tabuhan }} Orang</td>
                            <th>Pendapatan Tabuhan</th>
                            <td>{{ rupiah($total_tabuhan) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Pengunjung Glass Bottom</th>
                            <td>{{ $jml_glass_bottom }} Orang</td>
                            <th>Pendapatan Glass Bottom</th>
                            <td>{{ rupiah($total_glass_bottom) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Pengunjung Mandi Bola</th>
                            <td>{{ $jml_mandi_bola }} Orang</td>
                            <th>Pendapatan Mandi Bola</th>
                            <td>{{ rupiah($total_mandi_bola) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Pengunjung Kano</th>
                            <td>{{ $jml_kano }} Orang</td>
                            <th>Pendapatan Kano</th>
                            <td>{{ rupiah($total_kano) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Orang Berkunjung</th>
                            <td>{{ $jml_pengunjung }} Orang</td>
                            <th>Total Pembayaran Tiket</th>
                            <td>{{ rupiah($total_tiket) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>

    <script type="text/javascript">
        $('.delete').click(function(e) {
            e.preventDefault();
            var data_id = $(this).attr('data-id');

            if (confirm('Anda yakin menghapus data ini secara permanen ?')) {
                $('#formDelete-' + data_id).submit();
                return false;
            }
        });
    </script>

@endsection
