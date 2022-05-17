@extends('backend/layouts/template')
@section('title', 'Edit Produk PPKM')
@section('bread')
    <h2>Edit Produk PPKM</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/produk_ppkm') }}">Produk PPKM</a></li>
        <li class="active">
            <strong>Edit Produk PPKM</strong>
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
                    <form action="{{ url('admin/produk_ppkm', $produk_ppkm->id) }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div id="form" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        <label class="control-label" for="name">Name (*)</label>
                                        <input id="name" type="text" name="name" class="form-control" placeholder="Name"
                                            value="@if (count($errors) > 0) {{ old('name') }}@else{{ $produk_ppkm->name }}@endif" />

                                        @if ($errors->has('name'))
                                            <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('category')) has-error @endif">
                                        <label class="control-label" for="category">Category (*)</label>
                                        <select class="form-control" id="category" name="category">
                                            <option value="">-- Select --</option>
                                            <option value="makanan" @if ((count($errors) > 0 && old('category') == 'makanan') || $produk_ppkm->category == 'makanan') selected @endif>Makanan & Minuman</option>
                                            <option value="kerajinan" @if ((count($errors) > 0 && old('category') == 'kerajinan') || $produk_ppkm->category == 'kerajinan') selected @endif>Kerajinan</option>
                                        </select>

                                        @if ($errors->has('category'))
                                            <span for="category"
                                                class="help-block">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="control-label" for="description">Description (*)</label>
                                        <textarea class="form-control" name="description"
                                            rows="3">@if (count($errors) > 0) {{ old('description') }}@else{{ $produk_ppkm->description }}@endif</textarea>

                                        @if ($errors->has('description'))
                                            <span for="description"
                                                class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('address')) has-error @endif">
                                        <label class="control-label" for="address">Address (*)</label>
                                        <textarea class="form-control" name="address"
                                            rows="3">@if (count($errors) > 0) {{ old('address') }}@else{{ $produk_ppkm->address }}@endif</textarea>

                                        @if ($errors->has('address'))
                                            <span for="address" class="help-block">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('lat')) has-error @endif">
                                        <label class="control-label" for="lat">Latitude (*)</label>
                                        <input id="lat" type="text" name="lat" class="form-control" placeholder="Latitude"
                                            value="@if (count($errors) > 0){{ old('lat') }}@else{{ $produk_ppkm->lat }}@endif" />

                                        @if ($errors->has('lat'))
                                            <span for="lat" class="help-block">{{ $errors->first('lat') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('lng')) has-error @endif">
                                        <label class="control-label" for="lng">Longitude (*)</label>
                                        <input id="lng" type="text" name="lng" class="form-control" placeholder="Longitude"
                                            value="@if (count($errors) > 0){{ old('lng') }}@else{{ $produk_ppkm->lng }}@endif" />

                                        @if ($errors->has('lng'))
                                            <span for="lng" class="help-block">{{ $errors->first('lng') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('whatsapp')) has-error @endif">
                                        <label class="control-label" for="whatsapp">Whatsapp (*)</label>
                                        <input id="whatsapp" type="text" name="whatsapp" class="form-control"
                                            placeholder="Whatsapp" value="@if (count($errors) > 0) {{ old('whatsapp') }}@else{{ $produk_ppkm->whatsapp }}@endif" />

                                        @if ($errors->has('whatsapp'))
                                            <span for="whatsapp"
                                                class="help-block">{{ $errors->first('whatsapp') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('website')) has-error @endif">
                                        <label class="control-label" for="website">Website</label>
                                        <input id="website" type="text" name="website" class="form-control"
                                            placeholder="Website" value="@if (count($errors) > 0) {{ old('website') }}@else{{ $produk_ppkm->website }}@endif" />

                                        @if ($errors->has('website'))
                                            <span for="website" class="help-block">{{ $errors->first('website') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('instagram')) has-error @endif">
                                        <label class="control-label" for="instagram">instagram</label>
                                        <input id="instagram" type="text" name="instagram" class="form-control"
                                            placeholder="instagram" value="@if (count($errors) > 0) {{ old('instagram') }}@else{{ $produk_ppkm->instagram }}@endif" />

                                        @if ($errors->has('instagram'))
                                            <span for="instagram"
                                                class="help-block">{{ $errors->first('instagram') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('facebook')) has-error @endif">
                                        <label class="control-label" for="facebook">Facebook</label>
                                        <input id="facebook" type="text" name="facebook" class="form-control"
                                            placeholder="Facebook" value="@if (count($errors) > 0) {{ old('facebook') }}@else{{ $produk_ppkm->facebook }}@endif" />

                                        @if ($errors->has('facebook'))
                                            <span for="facebook"
                                                class="help-block">{{ $errors->first('facebook') }}</span>
                                        @endif
                                    </div>


                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image-foto" style="display: block">Image Produk PPKM</label>
                                        <img id="image-display" src="@if ($produk_ppkm->foto) {{ asset('upload/produk_ppkm/' . $produk_ppkm->foto) }}@else{{ 'https://via.placeholder.com/580x700' }}@endif"
                                            alt="{{ $produk_ppkm->foto }}" class="img-thumbnail"
                                            style="max-height: 300px; width: auto">
                                    </div>

                                    <div class="form-group @if ($errors->has('image')) has-error @endif">
                                        <label class="control-label" for="image-foto">Upload Image</label>
                                        <input type="file" name="image" id="image-foto" class="image form-control"
                                            value="@if (count($errors) > 0) {{ old('image') }}@endif">

                                        @if ($errors->has('image'))
                                            <span for="image" class="help-block">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="foto" id="foto" value="@if (count($errors) > 0) {{ old('foto') }}@else{{ $produk_ppkm->foto }}@endif">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="section">
                            <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                                <i class="fa fa-check"></i> Save & Back
                            </button>
                            <a href="{{ url('admin/produk_ppkm') }}" class="btn btn-danger">
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
                    <h5 class="modal-title" id="modalLabel">Upload image for add produk PPKM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-7">
                                <img id="image" src="https://via.placeholder.com/580x700" class="img-thumbnail">
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
                aspectRatio: 580 / 700,
                viewMode: 1,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 580,
                height: 700,
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
                        url: "{{ url('admin/produk_ppkm/image-cropper/upload') }}",
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data,
                            'produk_id': {{ $produk_ppkm->id }}
                        },
                        success: function(data) {
                            $modal.modal('hide');

                            document.getElementById("foto").value = data.filename;
                            imageDisplay.src = "{{ asset('upload/produk_ppkm/') }}" +
                                '/' +
                                data.filename;
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
