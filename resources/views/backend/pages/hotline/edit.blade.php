@extends('backend/layouts/template')
@section('title', "Edit Language")
@section('bread')
<h2>Edit Language</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }} ">Dashboard</a></li>
    <li><a href="{{ url('admin/language') }} ">Language</a></li>
    <li class="active">
        <strong>Edit Language</strong>
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
                <form action="{{url('admin/hotline', $hotline->id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group @if($errors->has('name')) has-error @endif">
                                <label class="control-label" for="name">Name Hotline</label>
                                <input name="name" type="text" class="form-control" placeholder="Name Hotline"
                                    value="@if(count($errors) > 0){{old('name')}}@else{{$hotline->name}}@endif" />

                                @if ($errors->has('name'))
                                <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('category')) has-error @endif">
                                <label class="control-label" for="category">Code Category </label>
                                <input id="category" type="text" name="category" class="form-control"
                                    placeholder="Code Category"
                                    value="@if(count($errors) > 0){{old('category')}}@else{{$hotline->category}}@endif" />

                                @if ($errors->has('category'))
                                <span for="category" class="help-block">{{ $errors->first('category') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('category_name')) has-error @endif">
                                <label class="control-label" for="category_name">Category Hotline </label>
                                <input id="category_name" type="text" name="category_name" class="form-control"
                                    placeholder="Category Name"
                                    value="@if(count($errors) > 0){{old('category_name')}}@else{{$hotline->category_name}}@endif" />

                                @if ($errors->has('category_name'))
                                <span for="category_name"
                                    class="help-block">{{ $errors->first('category_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('address')) has-error @endif">
                                <label class="control-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address"
                                    rows="3">@if(count($errors) > 0){{old('address')}}@else{{$hotline->address}}@endif</textarea>

                                @if ($errors->has('address'))
                                <span for="address" class="help-block">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('phone')) has-error @endif">
                                <label class="control-label" for="phone">Phone </label>
                                <input id="phone" type="text" name="phone" class="form-control"
                                    placeholder="Phone Hotline"
                                    value="@if(count($errors) > 0){{old('phone')}}@else{{$hotline->phone}}@endif" />

                                @if ($errors->has('phone'))
                                <span for="phone" class="help-block">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="image-foto" style="display: block">Image hotline</label>
                                <img id="image-display"
                                    src="@if($hotline->foto){{ asset('upload/hotline/'. $hotline->foto) }}@else{{ asset('assets/images/600x400.png') }}@endif"
                                    alt="{{ $hotline->foto }}" class="img-thumbnail"
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
                                value="@if(count($errors) > 0){{old('foto')}}@else{{ $hotline->foto }}@endif">
                        </div>
                    </div>

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/hotline') }}" class="btn btn-danger">
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
                <h5 class="modal-title" id="modalLabel">Upload image for add handcraft</h5>
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
                    url: "{{url('admin/hotline/image-cropper/upload')}}",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data,
                        'hotline_id': {{ $hotline->id }}
                    },
                    success: function(data) {
                        $modal.modal('hide');

                        document.getElementById("foto").value = data.filename;
                        imageDisplay.src = "{{ asset('upload/hotline/') }}" + '/' + data.filename;
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

</script>

@endsection