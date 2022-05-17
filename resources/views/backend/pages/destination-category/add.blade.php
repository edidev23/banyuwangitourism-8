@extends('backend/layouts/template')
@section('title', "Add Destination Category")
@section('bread')
<h2>Add Destination Category</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/destination') }}">Destinations</a></li>
    <li class="active">
        <strong>Add Destination Category</strong>
    </li>
</ol>
@endsection
@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/destination-category')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div id="form" class="tab-pane fade in active">
                        <ul class="nav nav-tabs" id="languageTabs">
                            @foreach ($lang as $l)
                            <li class="@if($l->id == 'ID') active @endif">
                                <a class="{{ $l->id }}" href="#{{ $l->id }}" data-toggle="tab">{{ $l->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($lang as $l)
                            <div id="{{ $l->id }}" class="tab-pane fade in @if($l->id == 'ID') active @endif">
                                <br>
                                <div class="form-group @if($errors->has('name'.$l->id)) has-error @endif">
                                    <label class="control-label" for="name{{ $l->id }}">Category Name</label>
                                    <input id="name{{ $l->id }}" type="text" name="name{{ $l->id }}"
                                        class="form-control" placeholder="Category Name"
                                        value="@if(count($errors) > 0){{old('name'. $l->id )}}@endif" />

                                    @if ($errors->has('name'. $l->id))
                                    <span for="name{{ $l->id }}"
                                        class="help-block">{{ $errors->first('name'. $l->id) }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_add_another" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Add Another
                        </button>
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/destination-category') }}" class="btn btn-danger">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection