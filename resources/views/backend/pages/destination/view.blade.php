@extends('backend/layouts/template')

@section('title', 'Destination Management')

@section('bread')
<h2>Destination Management</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li class="active"><strong>Destination Management</strong></li>
</ol>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
@endsection

@section('main')


@if (Auth::user()->role == 'admin')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox">
            <div class="inqbox-title border-top-success">
                <h5>Destination Management Data</h5>
                <br><br>
                <a href="{{ url('admin/destination/create') }}" class="btn btn-success">Add Destination</a>
            </div>
            <div class="inqbox-content">
                <div class="table-responsive">
                    <table id="datatable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Destination</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Email Admin</th>
                                <th>Verified</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Destination</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Email Admin</th>
                                <th>Verified</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($destination as $d)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $d->title }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->address }}</td>
                                    <td>{{ $d->hp }}</td>
                                    <td>{{ $d->email_admin }}</td>
                                    <td>{{ $d->verified }}</td>
                                    <td>
                                        @if($d->publish == 1)
                                        <span class="badge badge-success">Publish</span>
                                        @else
                                        <span class="badge badge-warning">Pending </span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="{{ url('admin/destination/status/'. $d->destination_id .'/1')}}" class="btn btn-success">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <a href="{{ url('admin/destination/status/'. $d->destination_id .'/0')}}" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </a>

                                        <a href="{{ url('admin/destination-tiket/' . $d->destination_id) }}"
                                            class="btn btn-success">
                                            <i class="fa fa-money"></i>
                                        </a>
                                        <a href="{{ url('admin/destination/' . $d->destination_id . '/edit') }}"
                                            class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="delete btn btn-danger"
                                            data-id="{{ $d->destination_id }}"><i class="fa fa-trash"></i></a>

                                        <form id="formDelete-{{ $d->destination_id }}"
                                            action="{{ url('admin/destination', $d->destination_id) }}" method="post"
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

@else
<div class="row">
    <div class="col-lg-12">
        <div class="inqbox">
            <div class="inqbox-title border-top-success">
                <h5>Destination Management Data</h5>
                <br><br>
                <a href="{{ url('admin/destination/create') }}" class="btn btn-success">Add Destination</a>
            </div>
            <div class="inqbox-content">
                <div class="table-responsive">
                    <table id="datatable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Destination</th>
                                <th>Category</th>
                                <th>Rate</th>
                                <th>Verified</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Destination</th>
                                <th>Category</th>
                                <th>Rate</th>
                                <th>Verified</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($destination as $d)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $d->title }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->rating_score ? $d->rating_score : 'Belum ada' }}</td>
                                    <td>{{ $d->verified }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>
                                        @if($d->publish == 1)
                                        <span class="badge badge-success">Publish</span>
                                        @else
                                        <span class="badge badge-warning">Pending </span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        
                                        @if($d->publish != 1)
                                        <a href="{{ url('admin/destination/' . $d->destination_id . '/edit') }}"
                                            class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="delete btn btn-danger"
                                            data-id="{{ $d->destination_id }}"><i class="fa fa-trash"></i></a>

                                        <form id="formDelete-{{ $d->destination_id }}"
                                            action="{{ url('admin/destination', $d->destination_id) }}" method="post"
                                            style="display: inline-block;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
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
@endif

@endsection


@section('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    // $(document).ready(function() {
    //     $('#datatable').DataTable();
    // });
    $(document).ready(function() {
    $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script type="text/javascript">
    $('.delete').click(function(e) {
        e.preventDefault();
        var data_id = $(this).attr('data-id');

        if (confirm('Anda yakin menghapus data ini secara permanen ?')) {
            $('#formDelete-' + data_id).submit();
            return false;
        }
        // Swal.fire({
        //   title: 'Confirm Delete',
        //   text: "Are you sure you want to permanently remove this post ?",
        //   icon: 'warning',
        //   showCancelButton: true,
        //   confirmButtonColor: '#3085d6',
        //   cancelButtonColor: '#d33',
        //   confirmButtonText: 'Delete'
        // }).then((result) => {
        //   if (result.value) {
        //     $('#formDelete-' + data_id).submit()
        //   }
        //   Swal.close();
        // });
    });
</script>

@endsection
