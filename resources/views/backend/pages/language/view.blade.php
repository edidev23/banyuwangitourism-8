@extends('backend/layouts/template')

@section('title', "Languages Management")

@section('bread')
<h2>Languages Management</h2>
<ol class="breadcrumb">
  <li><a href="{{ url('admin') }}">Dashboard</a></li>
  <li class="active"><strong>Languages Management</strong></li>
</ol>
@endsection
@section('main')

<div class="row">
  <div class="col-lg-12">
    <div class="inqbox">
      <div class="inqbox-title border-top-success">
        <h5>Languages Management Table</h5>
        <br><br>
        <a href="{{ url('admin/language/create') }}" class="btn btn-success">Add Language</a>
      </div>
      <div class="inqbox-content">
        <div class="table-responsive">
          <table id="tbl" class="table table-striped table-bordered table-hover dataTables-example">
            <thead>
              <tr>
                <th>ID</th>
                <th>Languages Management</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($language as $d )
              <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->created_at }}</td>
                <td>{{ $d->updated_at ? $d->updated_at : 'Belum diupdate' }}</td>
                <td align="center">
                  @if($d->status)
                  <a href="{{ url('admin/language/status/' . $d->id . '/0') }}" class="btn btn-success">ON</a>
                  @else
                  <a href="{{ url('admin/language/status/' . $d->id . '/1') }}" class="btn btn-secondary"
                    style="border: 1px solid #c6c9ca; color: black">OFF</a>
                  @endif


                  <a href="{{ url('admin/language/'. $d->id .'/edit')}}" class="btn btn-info">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a href="#" class="delete btn btn-danger" data-id="{{$d->id}}"><i class="fa fa-trash"></i></a>

                  <form id="formDelete-{{ $d->id }}" action="{{url('admin/language', $d->id)}}" method="post"
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