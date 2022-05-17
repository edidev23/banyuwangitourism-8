@extends('backend/layouts/template')

@section('title', 'Data Tiket Offline')

@section('bread')
    <h2>Data Tiket Offline</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Data Tiket Offline</strong></li>
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
                    <h5>Data Tiket Offline semua destinasi</h5>
                </div>
                <div class="inqbox-content">
                    {{-- <form action="{{ url('admin/laporan-tiket-harian') }}" method="get">
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
                    </form> --}}
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice</th>
                                    <th>Tanggal Booking</th>
                                    <th>Destinasi</th>
                                    <th>Tiket</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_booking as $d)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $d->invoice }}</td>
                                        <td>{{ $d->created_at }}</td>
                                        <td>{{ $d->destinasi }}</td>
                                        <td>
                                            {{ $d->jns_tiket }} {{ $d->jml_orang }}* {{ rupiah($d->harga_tiket) }}
                                            <br>
                                            {{ $d->jns_kendaraan }} {{ $d->jml_kendaraan }}*
                                            {{ rupiah($d->harga_parkir) }}

                                        </td>
                                        <td>{{ rupiah($d->total_tiket + $d->total_parkir) }}</td>

                                        <td>
                                            <a href="#" class="delete btn btn-danger" data-id="{{ $d->id }}"><i
                                                    class="fa fa-trash"></i></a>

                                            <form id="formDelete-{{ $d->id }}"
                                                action="{{ url('admin/delete-tiket-offline', $d->id) }}" method="post"
                                                style="display: inline-block;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
