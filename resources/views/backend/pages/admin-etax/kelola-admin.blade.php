@extends('backend/layouts/template')

@section('title', 'Kelola Data Admin Eticketing')

@section('bread')
    <h2>Kelola Data Admin Eticketing</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Kelola Data Admin Eticketing</strong></li>
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
                    <h5>Kelola Data Admin Eticketing</h5>
                    <br>
                </div>
                <div class="inqbox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>No Whatsapp</th>
                                    <th>Destinasi</th>
                                    <th>Device</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $d)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ tanggal_id($d->created_at) }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->no_whatsapp }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>{{ $d->device }}</td>
                                        <td>{{ $d->brand }}</td>
                                        <td>
                                            @if ($d->status == 'ACCEPT')
                                                <span class="badge badge-success">AKTIF</span>
                                            @elseif($d->status == 'REJECT')
                                                <span class="badge badge-danger">{{ $d->status }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ $d->status }}</span>
                                            @endif
                                        </td>
                                        <td align="right">
                                            @if ($d->status == 'ACCEPT')
                                                <a href="{{ url('admin/kelola-admin-etax/status/' . $d->id . '/NONAKTIF') }}"
                                                    class="btn btn-warning">
                                                    NonAktifkan
                                                </a>
                                            @endif

                                            @if ($d->status == 'REJECT')
                                                <a href="{{ url('admin/kelola-admin-etax/status/' . $d->id . '/ACCEPT') }}"
                                                    class="btn btn-info">
                                                    Setujui
                                                </a>
                                            @elseif ($d->status == 'NONAKTIF')
                                                <a href="{{ url('admin/kelola-admin-etax/status/' . $d->id . '/ACCEPT') }}"
                                                    class="btn btn-info">
                                                    Aktifkan
                                                </a>
                                            @endif

                                            <a href="#" class="delete btn btn-danger" data-id="{{ $d->id }}"><i
                                                    class="fa fa-trash"></i></a>

                                            <form id="formDelete-{{ $d->id }}"
                                                action="{{ url('admin/kelola-admin-etax', $d->id) }}" method="post"
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
