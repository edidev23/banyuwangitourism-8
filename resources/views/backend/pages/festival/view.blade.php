@extends('backend/layouts/template')

@section('title', 'Festival Management')

@section('bread')
<h2>Festival Management</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li class="active"><strong>Festival Management</strong></li>
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
                <h5>Festival Management Data</h5>
                <br><br>
                <a href="{{ url('admin/festival/create') }}" class="btn btn-success">Add Event</a>
            </div>
            <div class="inqbox-content">
                <div class="table-responsive">
                    <table id="datatable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Event</th>
                                <th>Location</th>
                                <th>Event Date From</th>
                                <th>Event Date To</th>
                                {{-- <th>Created At</th> --}}
                                <th>Best Festival</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Event</th>
                                <th>Location</th>
                                <th>Event Date From</th>
                                <th>Event Date To</th>
                                {{-- <th>Created At</th> --}}
                                <th>Best Festival</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($festival as $d)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $d->title }}</td>
                                    <td>{{ $d->location }}</td>
                                    <td>{{ $d->event_date_from }}</td>
                                    <td>{{ $d->event_date_to }}</td>
                                    {{-- <td>{{ $d->created_at }}</td> --}}
                                    <td>
                                        @if ($d->best_festival)
                                            <a href="{{ url('admin/festival/change-best-festival/' . $d->festival_id . '/0') }}"
                                                class="btn btn-success">YES</a>
                                        @else
                                            <a href="{{ url('admin/festival/change-best-festival/' . $d->festival_id . '/1') }}"
                                                class="btn btn-secondary"
                                                style="border: 1px solid #c6c9ca; color: black">NO</a>
                                        @endif

                                    </td>
                                    <td align="center">
                                        <a href="{{ url('admin/festival/' . $d->festival_id . '/edit') }}"
                                            class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="delete btn btn-danger" data-id="{{ $d->festival_id }}"><i
                                                class="fa fa-trash"></i></a>

                                        <form id="formDelete-{{ $d->festival_id }}"
                                            action="{{ url('admin/festival', $d->festival_id) }}" method="post"
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
