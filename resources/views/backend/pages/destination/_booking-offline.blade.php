@extends('backend/layouts/template')

@section('title', 'Laporan Harian Eticketing')

@section('bread')
    <h2>Laporan Harian Eticketing</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Laporan Harian Eticketing</strong></li>
    </ol>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/css/datepicker.css') }}" />
@endsection

@section('main')

    <div class="row">
        <div class="col-lg-12">
            <div class="inqbox">
                <div class="inqbox-title border-top-success">
                    <h5>Laporan Harian Destinasi (Tiket Offline)</h5>
                </div>
                <div class="inqbox-content">
                    <form action="{{ url('admin/laporan-tiket-harian') }}" method="get">
                        <div class="row" style="margin-bottom: 10px; justify-content: right">
                            <div class="col-md-2 datepicker">
                                <label for="tanggal">Pilih Tanggal</label>
                                <input type="text" name="created" value="{{ $created }}" id="datepicker"
                                    placeholder="tanggal" class="form-control">

                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="col-md-2" style="margin-top: 28px">
                                <button type="submit" class="btn btn-info">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Booking</th>
                                    <th>Destination</th>
                                    <th>Pengunjung</th>
                                    <th>Kendaraan</th>
                                    <th>Tiket</th>
                                    <th>Parkir</th>
                                    <th>Pendapatan</th>
                                    <th>Pajak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jml_orang = 0;
                                $total_tiket = 0;
                                $total_parkir = 0;
                                ?>
                                @foreach ($data_booking as $d)

                                    <?php
                                    $jml_orang = $jml_orang + $d->jml_orang;
                                    $total_tiket = $total_tiket + $d->total_tiket;
                                    $total_parkir = $total_parkir + $d->total_parkir;
                                    ?>

                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ tanggal_id($created) }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>{{ $d->jml_orang }}</td>
                                        <td>{{ $d->jml_kendaraan }}</td>
                                        <td>{{ rupiah($d->total_tiket) }}</td>
                                        <td>{{ rupiah($d->total_parkir) }}</td>
                                        <td>{{ rupiah($d->total_tiket + $d->total_parkir) }}</td>

                                        <td>{{ rupiah((($d->total_tiket + $d->total_parkir) * 10) / 100) }}</td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="inbox" style="margin-bottom: 20px">
                <div class="inqbox-title border-top-success">
                    <h5>Rekap Seluruh Destinasi</h5>
                </div>
                <div class="inqbox-content">
                    <table class="table table-bordered">
                        <tr>
                            <th>Jumlah Orang Berkunjung</th>
                            <td>{{ $jml_orang }}</td>
                        </tr>
                        <tr>
                            <th>Total Pembayaran Tiket</th>
                            <td>{{ rupiah($total_tiket) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Pembayaran Parkir</th>
                            <td>{{ rupiah($total_parkir) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>

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

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            minDate: '2021-12-12',
            autoclose: true
        });

        $("#datepicker").datepicker().on('show', function(e) {
            $('.prev').text('<<<');
            $('.next').text(">>>");
        });
    </script>

@endsection
