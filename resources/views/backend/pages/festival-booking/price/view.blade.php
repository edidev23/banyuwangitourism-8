@extends('backend/layouts/template')

@section('title', "Price Festival")

@section('bread')
<h2>Price Festival</h2>
@endsection

@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="inqbox">
            <div class="inqbox-title border-top-success">
                <h5>Price Management</h5>
            </div>
            <div class="inqbox-content">
                <div class="table-responsive">
                    <table id="tbl" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Kuota</th>
                                <th>Status Fee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Kuota</th>
                                <th>Status Fee</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($festival as $d)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $d->title }}</td>
                                <td>{{ $d->location }}</td>
                                <td>{{ $d->kuota ? $d->kuota : 'Unlimited' }}</td>
                                <td>{{ $d->fee == 'free' ? 'Gratis' : 'Berbayar' }}</td>
                                <td>
                                    @if($d->fee == 'free')
                                    <a href="{{ url('admin/festival-booking/price/fee/' . $d->id . '/pay') }}"
                                        class="btn btn-success">Pay</a>
                                    @else
                                    <a href="{{ url('admin/festival-booking/price/fee/' . $d->id . '/free') }}"
                                        class="btn btn-secondary"
                                        style="border: 1px solid #c6c9ca; color: black">Free</a>
                                    @endif

                                    @if($d->fee == 'pay')
                                    <a href="{{ url('admin/festival-booking/price/'. $d->id .'/edit')}}"
                                        class="btn btn-info">
                                        <i class="fa fa-pencil"></i>
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