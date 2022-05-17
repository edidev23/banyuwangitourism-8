@extends('backend/layouts/template')
@section('title', "Add Destination")
@section('bread')
<h2>Add Destination Geopark</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/geopark-destination') }}">Destinations</a></li>
    <li class="active">
        <strong>Add Destination Geopark</strong>
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
                <form action="{{url('admin/geopark-destination')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group @if($errors->has('title')) has-error @endif">
                                <label class="control-label" for="title">Title</label>
                                <input id="title" type="text" name="title" class="form-control"
                                    placeholder="Title"
                                    value="@if(count($errors) > 0){{old('title')}}@endif" />

                                @if ($errors->has('title'))
                                <span for="title" class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('description')) has-error @endif">
                                <label class="control-label" for="description">Description</label>
                                <input id="description" type="text" name="description" class="form-control"
                                    placeholder="Description"
                                    value="@if(count($errors) > 0){{old('description')}}@endif" />

                                @if ($errors->has('description'))
                                <span for="description" class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('text')) has-error @endif">
                                <label class="control-label" for="text">Teks</label>
                                <textarea class="ckeditor" name="text" id="text">@if(count($errors) > 0){{old('text')}}@endif</textarea>

                                @if ($errors->has('text'))
                                <span for="text"
                                    class="help-block">{{ $errors->first('text') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="image-foto" style="display: block">Image Destination</label>
                                <img id="image-display"
                                    src="@if(count($errors) > 0){{ asset('assets/images/600x400.png') }}@else{{ asset('assets/images/600x400.png') }}@endif"
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

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_add_another" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Add Another
                        </button>
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/geopark-destination') }}" class="btn btn-danger">
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
<script src="{{ asset('assets/functions/ckeditor/ckeditor.js') }}"></script>
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
                    url: "{{url('admin/geopark-destination/image-cropper/upload')}}",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data
                    },
                    success: function(data) {
                        $modal.modal('hide');

                        document.getElementById("foto").value = data.filename;
                        imageDisplay.src = "{{ asset('upload/geopark-destination/') }}" + '/' + data.filename;
                        // Swal.fire(
                        //     'Good job!',
                        //     'You Image as been crop!',
                        //     'success'
                        // )
                    }
                });
            }
        });
    })
</script>

@endsection