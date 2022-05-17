@extends('backend/layouts/template')
@section('title', "Add Language")
@section('bread')
<h2>Add Language</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }} ">Dashboard</a></li>
    <li><a href="{{ url('admin/language') }} ">Language</a></li>
    <li class="active">
        <strong>Add Language</strong>
    </li>
</ol>
@endsection
@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/language')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group @if($errors->has('id')) has-error @endif">
                        <label class="control-label" for="id">ID Language</label>
                        <input id="id" type="text" name="id" class="form-control" placeholder="ID Language"
                            value="@if(count($errors) > 0){{old('id')}}@endif" />

                        @if ($errors->has('id'))
                        <span for="id" class="help-block">{{ $errors->first('id') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                        <label class="control-label" for="name">Name Language</label>
                        <input id="name" type="text" name="name" class="form-control" placeholder="Name Language"
                            value="@if(count($errors) > 0){{old('name')}}@endif" />

                        @if ($errors->has('name'))
                        <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_add_another" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Add Another
                        </button>
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/language') }}" class="btn btn-danger">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection