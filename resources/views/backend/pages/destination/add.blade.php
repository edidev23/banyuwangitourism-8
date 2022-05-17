@extends('backend/layouts/template')
@section('title', "Add Destination")
@section('bread')
<h2>Add Destination</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/destination') }}">Destinations</a></li>
    <li class="active">
        <strong>Add Destination</strong>
    </li>
</ol>
@endsection

@section('css')
<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
    integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
@endsection

@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/destination')}}" method="post" enctype="multipart/form-data">
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
                                <div class="form-group @if($errors->has('title'.$l->id)) has-error @endif">
                                    <label class="control-label" for="title{{ $l->id }}">Title Destination</label>
                                    <input id="title{{ $l->id }}" type="text" name="title{{ $l->id }}"
                                        class="form-control" placeholder="Title Destination"
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
                            @endforeach

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group @if($errors->has('lat')) has-error @endif">
                                        <label class="control-label" for="lat">Latitude</label>
                                        <input id="lat" type="text" name="lat" class="form-control"
                                            placeholder="Latitude"
                                            value="@if(count($errors) > 0){{old('lat')}}@endif" />

                                        @if ($errors->has('lat'))
                                        <span for="lat" class="help-block">{{ $errors->first('lat') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('lng')) has-error @endif">
                                        <label class="control-label" for="lng">Longitude</label>
                                        <input id="lng" type="text" name="lng" class="form-control"
                                            placeholder="Longitude"
                                            value="@if(count($errors) > 0){{old('lng')}}@endif" />

                                        @if ($errors->has('lng'))
                                        <span for="lng" class="help-block">{{ $errors->first('lng') }}</span>
                                        @endif
                                    </div>

                                    <div
                                        class="form-group @if($errors->has('destination_category_id')) has-error @endif">
                                        <label class="control-label" for="destination_category_id">Category
                                            Destination</label>
                                        <select name="destination_category_id" id="destination_category_id"
                                            class="form-control">
                                            <option value="">-- Select --</option>

                                            @foreach ($category as $cat)
                                            <option value="{{ $cat->destination_category_id }}" @if(count($errors)> 0 &&
                                                old('destination_category_id') == $cat->destination_category_id)
                                                selected @endif>{{ $cat->name }}</option>
                                            @endforeach

                                        </select>

                                        @if ($errors->has('destination_category_id'))
                                        <span for="destination_category_id"
                                            class="help-block">{{ $errors->first('destination_category_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('hp')) has-error @endif">
                                        <label class="control-label" for="hp">Telephone</label>
                                        <input id="hp" type="text" name="hp" class="form-control"
                                            placeholder="Telephone"
                                            value="@if(count($errors) > 0){{old('hp')}}@endif" />

                                        @if ($errors->has('hp'))
                                        <span for="hp" class="help-block">{{ $errors->first('hp') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group @if($errors->has('verified')) has-error @endif">
                                        <label class="control-label" for="verified">Verified</label>
                                        <select name="verified" id="verified" class="form-control">
                                            <option value="">-- Select --</option>
                                            <option value="verified" @if(count($errors)> 0 && old('verified') ==
                                                'verified') selected @endif>Verified</option>
                                            <option value="belum verified" @if(count($errors)> 0 && old('verified') ==
                                                'belum verified') selected @endif>Belum Verified</option>
                                        </select>

                                        @if ($errors->has('verified'))
                                        <span for="verified" class="help-block">{{ $errors->first('verified') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('view_360')) has-error @endif">
                                        <label class="control-label" for="view_360">Link View 360</label>
                                        <input id="view_360" type="text" name="view_360" class="form-control"
                                            placeholder="Link View 360"
                                            value="@if(count($errors) > 0){{old('view_360')}}@endif" />

                                        @if ($errors->has('view_360'))
                                        <span for="view_360" class="help-block">{{ $errors->first('view_360') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image-foto" style="display: block">Image Destination</label>
                                        <img id="image-display"
                                            src="@if(count($errors) > 0){{asset('upload/destination/'. old('foto'))}}@else{{ asset('assets/images/600x400.png') }}@endif"
                                            alt="Image destination" class="img-thumbnail">
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
                                        value="@if(count($errors) > 0){{old('foto')}}@endif">
                                </div>
                            </div>
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
                        <a href="{{ url('admin/destination') }}" class="btn btn-danger">
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
                <h5 class="modal-title" id="modalLabel">Upload image for add destination</h5>
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
            aspectRatio: 4 /3,
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
                    url: "{{url('admin/destination/image-cropper/upload')}}",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data
                    },
                    success: function(data) {
                        $modal.modal('hide');

                        document.getElementById("foto").value = data.filename;
                        imageDisplay.src = "{{ asset('upload/destination/') }}" + '/' + data.filename;
                        Swal.fire(
                            'Good job!',
                            'You Image as been crop!',
                            'success'
                        )
                    }
                });
            }
        });
    })
</script>

@endsection