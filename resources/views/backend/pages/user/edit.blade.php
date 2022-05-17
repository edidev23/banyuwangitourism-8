@extends('backend/layouts/template')
@section('title', "Edit User")
@section('bread')
<h2>Edit User</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }} ">Dashboard</a></li>
    <li><a href="{{ url('admin/users') }} ">User</a></li>
    <li class="active">
        <strong>Edit User</strong>
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
                <form action="{{url('admin/users', $user->id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group @if($errors->has('name')) has-error @endif">
                                <label class="control-label" for="name">Name user</label>
                                <input name="name" type="text" class="form-control" placeholder="Name user"
                                    value="@if(count($errors) > 0){{old('name')}}@else{{$user->name}}@endif" />

                                @if ($errors->has('name'))
                                <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('email')) has-error @endif">
                                <label class="control-label" for="email">Email </label>
                                <input id="email" type="text" name="email" class="form-control" placeholder="Email"
                                    value="@if(count($errors) > 0){{old('email')}}@else{{$user->email}}@endif" />

                                @if ($errors->has('email'))
                                <span for="email" class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('role')) has-error @endif">
                                <label class="control-label" for="role">Role Access </label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin" @if(count($errors)> 0 && old('role') == 'admin' || $user->role
                                        == 'admin') selected
                                        @endif>Administrator
                                    </option>
                                    <option value="content" @if(count($errors)> 0 && old('role') == 'content' ||
                                        $user->role == 'content') selected
                                        @endif>Content
                                        Writer</option>
                                    <option value="operator" @if(count($errors)> 0 && old('role') ==
                                        'operator' || $user->role == 'operator') selected @endif>Operator
                                    </option>
                                    <option value="pimpinan" @if(count($errors)> 0 && old('role') ==
                                        'pimpinan' || $user->role == 'pimpinan') selected @endif>Pimpinan
                                    </option>
                                </select>

                                @if ($errors->has('role'))
                                <span for="role" class="help-block">{{ $errors->first('role') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="image-foto" style="display: block">Image user</label>
                                <img id="image-display"
                                    src="@if($user->foto){{ asset('upload/user/large/'. $user->foto) }}@else{{ asset('assets/images/600x400.png') }}@endif"
                                    alt="{{ $user->foto }}" class="img-thumbnail"
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
                                value="@if(count($errors) > 0){{old('foto')}}@else{{ $user->foto }}@endif">
                        </div>
                    </div>

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/users') }}" class="btn btn-danger">
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
            aspectRatio: 1 / 1,
            viewMode: 1,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
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
                    url: "{{url('admin/users/image-cropper/upload')}}",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data,
                        'user_id': {{ $user->id }}
                    },
                    success: function(data) {
                        $modal.modal('hide');

                        document.getElementById("foto").value = data.filename;
                        imageDisplay.src = "{{ asset('upload/user/large/') }}" + '/' + data.filename;
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