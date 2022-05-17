@extends('backend/layouts/template')

@section('title', "Destination Category")

@section('bread')
<h2>Destination Category</h2>
<ol class="breadcrumb">
  <li><a href="{{ url('admin') }}">Dashboard</a></li>
  <li><a href="{{ url('admin/destination') }}">Destinations</a></li>
  <li class="active"><strong>Destination Category</strong></li>
</ol>
@endsection

@section('main')

<div class="row">
  <div class="col-lg-12">
    <div class="inqbox">
      <div class="inqbox-title border-top-success">
        <h5>Destination Category Table</h5>
        <br><br>
        <a href="{{ url('admin/destination-category/create') }}" class="btn btn-success">Add Destination Category</a>
      </div>
      <div class="inqbox-content">
        <div class="table-responsive">
          <table id="tbl" class="table table-striped table-bordered table-hover dataTables-example">
            <thead>
              <tr>
                <th>No</th>
                <th>Destination Category</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Destination Category</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($destination_category as $d)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->created_at }}</td>
                <td>{{ $d->updated_at }}</td>
                <td align="center">
                  <a href="{{ url('admin/destination-category/'. $d->destination_category_id .'/edit')}}"
                    class="btn btn-info">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a href="#" class="delete btn btn-danger" data-id="{{$d->destination_category_id}}"><i
                      class="fa fa-trash"></i></a>

                  <form id="formDelete-{{ $d->destination_category_id }}"
                    action="{{url('admin/destination-category', $d->destination_category_id)}}" method="post"
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