@extends('backend/layouts/template')
@section('title', "Edit Price")
@section('bread')
<h2>Edit Price</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/festival-booking/price') }}">Festival Price</a></li>
    <li class="active">
        <strong>Edit price</strong>
    </li>
</ol>
@endsection

@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/festival-booking/price', $festival->id)}}" method="post"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">

                        @foreach($festival->ticketPrice as $price)
                        <input type="hidden" name="id_{{ $price->type }}" value="{{ $price->id }}">
                        <div class="col-md-3 col-12">
                            <div class="form-group @if($errors->has('adult')) has-error @endif">
                                <label class="control-label" for="{{ $price->type }}">Price {{ $price->type }}</label>
                                <input id="{{ $price->type }}" type="number" name="{{ $price->type }}"
                                    class="form-control" placeholder="{{ $price->type }}"
                                    value="@if(count($errors) > 0){{old( $price->type )}}@else{{ $price->price }}@endif" />

                                @if ($errors->has( $price->type ))
                                <span for="{{ $price->type }}"
                                    class="help-block">{{ $errors->first( $price->type ) }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/festival-booking/price') }}" class="btn btn-danger">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection