@extends('backend/layouts/template')

@section('title', 'Culinary Management')

@section('bread')
<h2>Culinary Management</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li class="active"><strong>Culinary Management</strong></li>
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
                <h5>Culinary Management Data</h5>
                <br><br>
                <a href="{{ url('admin/culinary/create') }}" class="btn btn-success">Add Culinary</a>
            </div>
            <div class="inqbox-content">
                <div class="table-responsive">
                    <table id="datatable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Culinary</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Culinary</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($culinary as $d)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $d->title }}</td>
                                    <td>{{ $d->description }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>{{ $d->updated_at }}</td>
                                    <td align="center">
                                        <a href="{{ url('admin/culinary/' . $d->culinary_id . '/edit') }}"
                                            class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="delete btn btn-danger" data-id="{{ $d->culinary_id }}"><i
                                                class="fa fa-trash"></i></a>

                                        <form id="formDelete-{{ $d->culinary_id }}"
                                            action="{{ url('admin/culinary', $d->culinary_id) }}" method="post"
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
        //     $('#formDelete-' + data_id).submit();
        //     Swal.close();
        //   }
        // });
    });
</script>

@endsection
