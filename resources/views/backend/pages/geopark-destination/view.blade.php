@extends('backend/layouts/template')

@section('title', 'Destination Geopark Management')

@section('bread')
    <h2>Destination Geopark Management</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li class="active"><strong>Destination Geopark</strong></li>
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
                    <h5>Data Destination Geopark</h5>
                    <br><br>
                    <a href="{{ url('admin/geopark-destination/create') }}" class="btn btn-success">Add Destination</a>
                </div>
                <div class="inqbox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Destination</th>
                                    <th width="300px">QRCODE</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Destination</th>
                                    <th>QRCODE</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($destination as $d)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>
                                            {{ url("geopark/". $d->slug) }}  <br>
                                            <a href="#" target="_blank" rel="noopener noreferrer">
                                                Download QRCODE
                                            </a>
                                        </td>
                                        <td>{{ tanggal_id($d->created_at) }}</td>
                                        <td align="center">
                                            <a href="{{ url('admin/geopark-destination/' . $d->id . '/edit') }}"
                                                class="btn btn-info">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" class="delete btn btn-danger" data-id="{{ $d->id }}"><i
                                                    class="fa fa-trash"></i></a>

                                            <form id="formDelete-{{ $d->id }}"
                                                action="{{ url('admin/geopark-destination', $d->id) }}" method="post"
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
