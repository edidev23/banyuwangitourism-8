@extends('backend/layouts/template')

@section('title', 'Booking Destination Online')

@section('bread')
    <h2>Data Tiket Grand Watudodol</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Tiket Grand Watudodol</strong></li>
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
                    <h5>Data Tiket Grand Watudodol</h5>
                </div>
                <div class="inqbox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Tiket</th>
                                    <th>Invoice</th>
                                    <th>Jenis Tiket</th>
                                    <th>Jml Pengunjung</th>
                                    <th>Total Pembayaran</th>
                                    <th>Email Admin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jml_orang = 0;
                                $total_tiket = 0;
                                $total_parkir = 0;
                                ?>
                                @foreach ($all_tiket as $d)
                                    <?php
                                    $jml_orang = $jml_orang + $d->jml_orang;
                                    ?>

                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ tanggal_id($d->created_at) }}
                                            - {{ formatJamFestival($d->created_at) }}
                                        </td>
                                        <td>{{ $d->invoice }}</td>
                                        <td>
                                            @if ($d->jns_tiket == 'WAHANA')
                                                {{ $d->jns_tiket }} - {{ $d->sub_tiket }}
                                            @else
                                                {{ $d->jns_tiket }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $d->jml_orang }} Org
                                        </td>
                                        <td>{{ rupiah($d->total) }}</td>
                                        <td>
                                            {{ $d->email_admin }}
                                        </td>
                                        <td>
                                            <a href="#" class="delete btn btn-danger"
                                                data-id="{{ $d->id }}"><i class="fa fa-trash"></i></a>

                                            <form id="formDelete-{{ $d->id }}"
                                                action="{{ url('admin/booking-gwd/delete', $d->id) }}" method="post"
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
