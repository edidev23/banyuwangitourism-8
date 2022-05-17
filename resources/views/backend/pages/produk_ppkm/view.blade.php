@extends('backend/layouts/template')

@section('title', 'Produk PPKM')

@section('bread')
<h2>Produk PPKM Management</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li class="active"><strong>Produk PPKM Management</strong></li>
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
                <h5>Data Produk PPKM</h5>
                <br><br>
                <a href="{{ url('admin/produk_ppkm/create') }}" class="btn btn-success">Add Produk PPKM</a>
            </div>
            <div class="inqbox-content">
                <div class="table-responsive">
                    <table id="datatable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Whatsapp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Whatsapp</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($produk_ppkm as $d)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->category }}</td>
                                    <td>{{ $d->address }}</td>
                                    <td>{{ $d->whatsapp }}</td>
                                    <td align="center">
                                        <a href="{{ url('admin/produk_ppkm/' . $d->id . '/edit') }}"
                                            class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="delete btn btn-danger" data-id="{{ $d->id }}"><i
                                                class="fa fa-trash"></i></a>

                                        <form id="formDelete-{{ $d->id }}"
                                            action="{{ url('admin/produk_ppkm', $d->id) }}" method="post"
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

    $('.delete').click(function(e) {
        e.preventDefault();
        var data_id = $(this).attr('data-id');

        if (confirm('Are you sure you want to delete this entry?')) {
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
