@extends('backend/layouts/template')

@section('title', 'Tracking Aktivitas Admin')

@section('bread')
    <h2>Tracking Aktivitas Admin</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Tracking Aktivitas Admin</strong></li>
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
                    <h5>Tracking Aktivitas Admin</h5>
                    <br>
                </div>
                <div class="inqbox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Kontak</th>
                                    <th>Destinasi</th>
                                    <th>Device</th>
                                    <th>Brand</th>
                                    <th>Status Login</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $d)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td>{{ $d->email }} <br> {{ $d->no_whatsapp }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>{{ $d->device }}</td>
                                        <td>{{ $d->brand }}</td>
                                        <td>
                                            @if ($d->is_login)
                                                <span class="badge badge-success">Sudah Login</span>
                                            @else
                                                <span class="badge badge-info">Belum Login</span>
                                            @endif
                                        </td>
                                        <td>{{ $d->time_login }}</td>
                                        <td>
                                            @if ($d->status == 'ACCEPT')
                                                <span class="badge badge-success">AKTIF</span>
                                            @elseif($d->status == 'NONAKTIF')
                                                <span class="badge badge-danger">{{ $d->status }}</span>
                                            @endif
                                        </td>
                                        <td align="right">
                                            @if ($d->status == 'ACCEPT')
                                                <a href="{{ url('admin/tracking-admin-etax/status/' . $d->id . '/NONAKTIF') }}"
                                                    class="btn btn-warning">
                                                    Non Aktifkan
                                                </a>
                                            @endif

                                            @if ($d->status == 'NONAKTIF')
                                                <a href="{{ url('admin/tracking-admin-etax/status/' . $d->id . '/ACCEPT') }}"
                                                    class="btn btn-info">
                                                    Aktifkan
                                                </a>
                                            @endif

                                            @if ($d->is_login)
                                                <a href="{{ url('admin/tracking-admin-etax/status-login/' . $d->id . '/LOGOUT') }}"
                                                    class="btn btn-danger">
                                                    Logout
                                                </a>
                                            @endif

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
