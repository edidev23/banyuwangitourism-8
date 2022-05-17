@extends('backend/layouts/template')
@section('title', "Edit Festival")
@section('bread')
<h2>Edit Festival</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/festival') }}">Festival</a></li>
    <li class="active">
        <strong>Edit Festival</strong>
    </li>
</ol>
@endsection

@section('css')
<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
    integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/festival', $festival->id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
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

                            @if(isset($festival->festivalTranslation[$i]->id))
                            {{-- update data --}}
                            <input type="hidden" name="festival_translation_id{{ $l->id }}"
                                value="{{ $festival->festivalTranslation[$i]->id }}">
                            <div id="{{ $l->id }}" class="tab-pane fade in @if($l->id == 'ID') active @endif">
                                <br>
                                <div class="form-group @if($errors->has('title'.$l->id)) has-error @endif">
                                    <label class="control-label" for="title{{ $l->id }}">Title Event</label>
                                    <input id="title{{ $l->id }}" type="text" name="title{{ $l->id }}"
                                        class="form-control" placeholder="Title Event"
                                        value="@if(count($errors) > 0){{old('title'. $l->id )}}@else{{ $festival->festivalTranslation[$i]->title }}@endif" />

                                    @if ($errors->has('title'. $l->id))
                                    <span for="title{{ $l->id }}"
                                        class="help-block">{{ $errors->first('title'. $l->id) }}</span>
                                    @endif
                                </div>


                                <div class="form-group @if($errors->has('description'.$l->id)) has-error @endif">
                                    <label class="control-label" for="description{{ $l->id }}">Description</label>
                                    <textarea class="form-control" name="description{{ $l->id }}"
                                        id="description{{ $l->id }}"
                                        rows="3">@if(count($errors) > 0){{old('description'. $l->id )}}@else{{ $festival->festivalTranslation[$i]->description }}@endif</textarea>

                                    @if ($errors->has('description'. $l->id))
                                    <span for="description{{ $l->id }}"
                                        class="help-block">{{ $errors->first('description'. $l->id) }}</span>
                                    @endif
                                </div>
                                <div class="form-group @if($errors->has('address'.$l->id)) has-error @endif">
                                    <label class="control-label" for="address{{ $l->id }}">Address</label>
                                    <textarea class="form-control" name="address{{ $l->id }}" id="address{{ $l->id }}"
                                        rows="3">@if(count($errors) > 0){{old('address'. $l->id )}}@else{{ $festival->festivalTranslation[$i]->address }}@endif</textarea>

                                    @if ($errors->has('address'. $l->id))
                                    <span for="address{{ $l->id }}"
                                        class="help-block">{{ $errors->first('address'. $l->id) }}</span>
                                    @endif
                                </div>
                            </div>

                            @else
                            {{-- insert new --}}
                            <div id="{{ $l->id }}" class="tab-pane fade in @if($l->id == 'ID') active @endif">
                                <br>
                                <div class="form-group @if($errors->has('title'.$l->id)) has-error @endif">
                                    <label class="control-label" for="title{{ $l->id }}">Title Festival</label>
                                    <input id="title{{ $l->id }}" type="text" name="title{{ $l->id }}"
                                        class="form-control" placeholder="Title Festival"
                                        value="@if(count($errors) > 0){{old('title'. $l->id )}}@endif" />

                                    @if ($errors->has('title'. $l->id))
                                    <span for="title{{ $l->id }}"
                                        class="help-block">{{ $errors->first('title'. $l->id) }}</span>
                                    @endif
                                </div>


                                <div class="form-group @if($errors->has('description'.$l->id)) has-error @endif">
                                    <label class="control-label" for="description{{ $l->id }}">Description</label>
                                    <textarea class="form-control" name="description{{ $l->id }}"
                                        id="description{{ $l->id }}"
                                        rows="3">@if(count($errors) > 0){{old('description'. $l->id )}}@endif</textarea>

                                    @if ($errors->has('description'. $l->id))
                                    <span for="description{{ $l->id }}"
                                        class="help-block">{{ $errors->first('description'. $l->id) }}</span>
                                    @endif
                                </div>
                                <div class="form-group @if($errors->has('address'.$l->id)) has-error @endif">
                                    <label class="control-label" for="address{{ $l->id }}">Address</label>
                                    <textarea class="form-control" name="address{{ $l->id }}" id="address{{ $l->id }}"
                                        rows="3">@if(count($errors) > 0){{old('address'. $l->id )}}@endif</textarea>

                                    @if ($errors->has('address'. $l->id))
                                    <span for="address{{ $l->id }}"
                                        class="help-block">{{ $errors->first('address'. $l->id) }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <?php $i = $i + 1 ?>
                            @endforeach

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group @if($errors->has('lat')) has-error @endif">
                                        <label class="control-label" for="lat">Latitude</label>
                                        <input id="lat" type="text" name="lat" class="form-control"
                                            placeholder="Latitude"
                                            value="@if(count($errors) > 0){{old('lat')}}@else{{ $festival->lat }}@endif" />

                                        @if ($errors->has('lat'))
                                        <span for="lat" class="help-block">{{ $errors->first('lat') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('lng')) has-error @endif">
                                        <label class="control-label" for="lng">Longitude</label>
                                        <input id="lng" type="text" name="lng" class="form-control"
                                            placeholder="Longitude"
                                            value="@if(count($errors) > 0){{old('lng')}}@else{{ $festival->lng }}@endif" />

                                        @if ($errors->has('lng'))
                                        <span for="lng" class="help-block">{{ $errors->first('lng') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('location')) has-error @endif">
                                        <label class="control-label" for="location">Location</label>
                                        <textarea class="form-control" name="location" id="location"
                                            rows="3">@if(count($errors) > 0){{old('location')}}@else{{ $festival->location }}@endif</textarea>

                                        @if ($errors->has('location'))
                                        <span for="location" class="help-block">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 col-lg-4">
                                            <div class="form-group @if($errors->has('event_date_from')) has-error @endif"">
                                                <label class=" control-label" for="event_date_from">Event Date
                                                From</label>
                                                <div class="input-group date" id="datetimepicker">
                                                    <input id="event_date_from" type="text" name="event_date_from"
                                                        class="form-control" placeholder="Event Date From"
                                                        value="@if(count($errors) > 0){{old('event_date_from')}}@else{{ $festival->event_date_from }}@endif" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-lg-4">
                                            <div class="form-group @if($errors->has('event_date_from')) has-error @endif"">
                                                <label class=" control-label" for="event_date_to">Event Date To</label>
                                                <div class="input-group date" id="datetimepicker2">
                                                    <input id="event_date_to" type="text" name="event_date_to"
                                                        class="form-control" placeholder="Event Date To"
                                                        value="@if(count($errors) > 0){{old('event_date_to')}}@else{{ $festival->event_date_to }}@endif" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group @if($errors->has('fee')) has-error @endif">
                                                <label class="control-label" for="fee">Fee</label>
                                                <select name="fee" id="fee" class="form-control">
                                                    <option value="">-- Select --</option>
                                                    <option value="free" @if((count($errors)> 0 && old('fee') == 'free')
                                                        ||
                                                        $festival->fee == "free") selected @endif>Free</option>
                                                    <option value="pay" @if((count($errors)> 0 && old('fee') == 'pay')
                                                        ||
                                                        $festival->fee == "pay") selected @endif>Pay</option>
                                                </select>

                                                @if ($errors->has('fee'))
                                                <span for="fee" class="help-block">{{ $errors->first('fee') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group @if($errors->has('kuota')) has-error @endif">
                                                <label class="control-label" for="kuota">Kuota</label>
                                                <input id="kuota" type="number" name="kuota" class="form-control"
                                                    placeholder="Kuota"
                                                    value="@if(count($errors) > 0){{old('kuota')}}@else{{ $festival->kuota }}@endif" />

                                                @if ($errors->has('kuota'))
                                                <span for="kuota"
                                                    class="help-block">{{ $errors->first('kuota') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group @if($errors->has('url')) has-error @endif">
                                        <label class="control-label" for="url">External URL</label>
                                        <input id="url" type="text" name="url" class="form-control"
                                            placeholder="External URL"
                                            value="@if(count($errors) > 0){{old('url')}}@else{{ $festival->url }}@endif" />

                                        @if ($errors->has('url'))
                                        <span for="url" class="help-block">{{ $errors->first('url') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('youtube')) has-error @endif">
                                        <label class="control-label" for="youtube">Link Youtube</label>
                                        <input id="youtube" type="text" name="youtube" class="form-control"
                                            placeholder="Link Youtube"
                                            value="@if(count($errors) > 0){{old('youtube')}}@else{{ $festival->youtube }}@endif" />

                                        @if ($errors->has('youtube'))
                                        <span for="youtube" class="help-block">{{ $errors->first('youtube') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image-foto" style="display: block">Image Festival</label>
                                        <img id="image-display"
                                            src="@if($festival->foto){{ asset('upload/festival/'. $festival->foto) }}@else{{ asset('assets/images/600x400.png') }}@endif"
                                            alt="{{ $festival->foto }}" class="img-thumbnail"
                                            style="max-height: 300px; width: auto">
                                    </div>

                                    <div class="form-group @if($errors->has('image')) has-error @endif">
                                        <label class="control-label" for="image-foto">Upload Image</label>
                                        <input type="file" name="image" id="image-foto" class="image form-control"
                                            value="@if(count($errors) > 0){{old('image')}}@endif">

                                        @if ($errors->has('image'))
                                        <span for="image" class="help-block">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="foto" id="foto"
                                        value="@if(count($errors) > 0){{old('foto')}}@else{{ $festival->foto }}@endif">
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/festival') }}" class="btn btn-danger">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Upload image for add festival</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-7">
                            <img id="image" src="{{ asset('assets/images/600x400.png')}}">
                        </div>
                        <div class="col-md-5">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('assets/js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
    integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

<script>
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var imageDisplay = document.getElementById('image-display');
    var cropper;

    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 4 / 3,
            viewMode: 1,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 600,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{url('admin/festival/image-cropper/upload')}}",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data,
                        'festival_id': {{ $festival->id }}
                    },
                    success: function(data) {
                        $modal.modal('hide');

                        document.getElementById("foto").value = data.filename;
                        imageDisplay.src = "{{ asset('upload/festival/') }}" + '/' + data.filename;
                        Swal.fire(
                            'Good job!',
                            'You Image as been crop!',
                            'success'
                        )
                    }
                });
            }
        });
    });

    // datepicker
    $(function() {
        $('#datetimepicker').datetimepicker();
        $('#datetimepicker2').datetimepicker();
    });
</script>

@endsection