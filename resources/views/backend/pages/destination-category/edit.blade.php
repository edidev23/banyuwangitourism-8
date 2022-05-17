@extends('backend/layouts/template')
@section('title', "Edit Destination Category")
@section('bread')
<h2>Edit Destination Category</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/destination') }}">Destinations</a></li>
    <li class="active">
        <strong>Edit Destination Category</strong>
    </li>
</ol>
@endsection
@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/destination-category', $destinationCategory->id )}}" method="post"
                    enctype="multipart/form-data">
                    {{ method_field('PUT') }}
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
                            <?php $i = 0; ?>
                            @foreach ($lang as $l)

                            @if(isset($destinationCategory->destinationCategoryTranslation[$i]->id))
                            {{-- update data --}}
                            <input type="hidden" name="destination_category_translation_id{{ $l->id }}"
                                value="{{ $destinationCategory->destinationCategoryTranslation[$i]->id }}">
                            <div id="{{ $l->id }}" class="tab-pane fade in @if($l->id == 'ID') active @endif">
                                <br>
                                <div class="form-group @if($errors->has('name'.$l->id)) has-error @endif">
                                    <label class="control-label" for="name{{ $l->id }}">Category Name</label>
                                    <input id="name{{ $l->id }}" type="text" name="name{{ $l->id }}"
                                        class="form-control" placeholder="Category Name"
                                        value="@if(count($errors) > 0){{old('name'. $l->id )}}@else{{ $destinationCategory->destinationCategoryTranslation[$i]->name }}@endif" />

                                    @if ($errors->has('name'. $l->id))
                                    <span for="name{{ $l->id }}"
                                        class="help-block">{{ $errors->first('name'. $l->id) }}</span>
                                    @endif
                                </div>
                            </div>
                            @else
                            {{-- insert baru --}}
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
                            @endif

                            <?php $i = $i + 1 ?>
                            @endforeach
                        </div>
                    </div>

                    <hr>
                    <div class="section">
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