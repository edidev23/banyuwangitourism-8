@extends('backend/layouts/template')

@section('title', 'Booking Destination Online')

@section('bread')
    <h2>Booking Destination Online</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Booking Destination</strong></li>
    </ol>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
@endsection

@section('main')

    <div class="row">
        <div class="col-lg-12">
            <div class="inqbox">
                <div class="inqbox-title border-top-success">
                    <h5>Booking Destination Online</h5>
                </div>
                <div class="inqbox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Visit</th>
                                    <th>Tanggal Booking</th>
                                    <th>Invoice</th>
                                    <th>Destination</th>
                                    <th>Jumlah</th>
                                    <th>Total Pembayaran</th>
                                    <th>Status</th>
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
                                    $total_tiket = $total_tiket + $d->harga_tiket;
                                    $total_parkir = $total_parkir + $d->harga_parkir;

                                    $destination = count($d->destination->destinationTranslation);
                                    $category = count($d->destination->destinationCategory->destinationCategoryTranslation);

                                    if($destination == 0 || $category == 0) {
                                        continue;
                                    }
                                    ?>

                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ tanggal_id($d->created_at) }}
                                        </td>
                                        <td>
                                            {{ tanggal_id($d->tgl_booking) }}
                                        </td>
                                        <td>{{ $d->invoice }}</td>
                                        <td>
                                            {{ $d->destination->destinationTranslation[0]->title }} / <br>

                                            {{ $d->destination->destinationCategory->destinationCategoryTranslation[0]->name }}
                                        </td>
                                        <td>
                                            {{ $d->jml_orang }} Org [ {{ $d->jns_tiket }} ] <br>
                                            @if ($d->jns_kendaraan != 'JALAN')
                                                {{ $d->jml_kendaraan }} {{ $d->jns_kendaraan }}
                                            @endif
                                        </td>
                                        <td>{{ rupiah($d->total_tiket + $d->total_parkir) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $d->status == 'SUCCESS' ? 'badge-success' : 'badge-warning' }}">{{ $d->status }}</span>
                                        </td>
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
