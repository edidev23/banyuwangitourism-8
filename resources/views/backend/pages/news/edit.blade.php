@extends('backend/layouts/template')
@section('title', "Edit News")
@section('bread')
<h2>Edit News</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Dashboard</a></li>
    <li><a href="{{ url('admin/news') }}">News</a></li>
    <li class="active">
        <strong>Edit News</strong>
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
                <form action="{{url('admin/news', $news->id)}}" method="post" enctype="multipart/form-data">
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

                            @if(isset($news->newsTranslation[$i]->id))
                            {{-- update data --}}
                            <input type="hidden" name="news_translation_id{{ $l->id }}"
                                value="{{ $news->newsTranslation[$i]->id }}">
                            <div id="{{ $l->id }}" class="tab-pane fade in @if($l->id == 'ID') active @endif">
                                <br>
                                <div class="form-group @if($errors->has('title'.$l->id)) has-error @endif">
                                    <label class="control-label" for="title{{ $l->id }}">Title news</label>
                                    <input id="title{{ $l->id }}" type="text" name="title{{ $l->id }}"
                                        class="form-control" placeholder="Title news"
                                        value="@if(count($errors) > 0){{old('title'. $l->id )}}@else{{ $news->newsTranslation[$i]->title }}@endif" />

                                    @if ($errors->has('title'. $l->id))
                                    <span for="title{{ $l->id }}"
                                        class="help-block">{{ $errors->first('title'. $l->id) }}</span>
                                    @endif
                                </div>


                                {{-- <div class="form-group @if($errors->has('text'.$l->id)) has-error @endif">
                                    <label class="control-label" for="text{{ $l->id }}">Text</label>
                                    <textarea class="form-control" name="text{{ $l->id }}" id="text{{ $l->id }}"
                                        rows="3">@if(count($errors) > 0){{old('text'. $l->id )}}@else{{ $news->newsTranslation[$i]->text }}@endif</textarea>

                                    @if ($errors->has('text'. $l->id))
                                    <span for="text{{ $l->id }}"
                                        class="help-block">{{ $errors->first('text'. $l->id) }}</span>
                                    @endif
                                </div> --}}
                                <div class="form-group @if($errors->has('text'.$l->id)) has-error @endif">
                                    <label class="control-label" for="text{{ $l->id }}">Teks</label>
                                    <textarea class="ckeditor" name="text{{ $l->id }}" id="text{{ $l->id }}">@if(count($errors) > 0){{old('text'. $l->id )}}@else{{ $news->newsTranslation[$i]->text }}@endif</textarea>

                                    @if ($errors->has('text'. $l->id))
                                    <span for="text{{ $l->id }}"
                                        class="help-block">{{ $errors->first('text'. $l->id) }}</span>
                                    @endif
                                </div>
                            </div>

                            @else
                            {{-- insert new --}}
                            <div id="{{ $l->id }}" class="tab-pane fade in @if($l->id == 'ID') active @endif">
                                <br>
                                <div class="form-group @if($errors->has('title'.$l->id)) has-error @endif">
                                    <label class="control-label" for="title{{ $l->id }}">Title news</label>
                                    <input id="title{{ $l->id }}" type="text" name="title{{ $l->id }}"
                                        class="form-control" placeholder="Title news"
                                        value="@if(count($errors) > 0){{old('title'. $l->id )}}@endif" />

                                    @if ($errors->has('title'. $l->id))
                                    <span for="title{{ $l->id }}"
                                        class="help-block">{{ $errors->first('title'. $l->id) }}</span>
                                    @endif
                                </div>


                                <div class="form-group @if($errors->has('text'.$l->id)) has-error @endif">
                                    <label class="control-label" for="text{{ $l->id }}">Text</label>
                                    <textarea class="form-control" name="text{{ $l->id }}" id="text{{ $l->id }}"
                                        rows="3">@if(count($errors) > 0){{old('text'. $l->id )}}@endif</textarea>

                                    @if ($errors->has('text'. $l->id))
                                    <span for="text{{ $l->id }}"
                                        class="help-block">{{ $errors->first('text'. $l->id) }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <?php $i = $i + 1 ?>
                            @endforeach

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group @if($errors->has('category')) has-error @endif">
                                        <label class="control-label" for="category">Category</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <option value="lokal" @if(count($errors)> 0 && old('category') == 'lokal' ||
                                                $news->category == 'lokal') selected @endif>Lokal</option>
                                            <option value="nasional" @if(count($errors)> 0 && old('category') ==
                                                'nasional' || $news->category == 'nasional') selected @endif>Nasional
                                            </option>
                                            <option value="manca" @if(count($errors)> 0 && old('category') == 'manca' ||
                                                $news->category == 'manca') selected @endif>Manca Negara</option>
                                        </select>

                                        @if ($errors->has('category'))
                                        <span for="category" class="help-block">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('sumber')) has-error @endif">
                                        <label class="control-label" for="sumber">Sumber</label>
                                        <input id="sumber" type="text" name="sumber" class="form-control"
                                            placeholder="Sumber"
                                            value="@if(count($errors) > 0){{old('sumber')}}@else{{ $news->sumber }}@endif" />

                                        @if ($errors->has('sumber'))
                                        <span for="sumber" class="help-block">{{ $errors->first('sumber') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image-foto" style="display: block">Image news</label>
                                        <img id="image-display"
                                            src="@if($news->foto){{ asset('upload/news/'. $news->foto) }}@else{{ asset('assets/images/600x400.png') }}@endif"
                                            alt="{{ $news->foto }}" class="img-thumbnail"
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
                                        value="@if(count($errors) > 0){{old('foto')}}@else{{ $news->foto }}@endif">
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin/news') }}" class="btn btn-danger">
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
                <h5 class="modal-title" id="modalLabel">Upload image for add news</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">??</span>
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
                    url: "{{url('admin/news/image-cropper/upload')}}",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data,
                        'news_id': {{ $news->id }}
                    },
                    success: function(data) {
                        $modal.modal('hide');

                        document.getElementById("foto").value = data.filename;
                        imageDisplay.src = "{{ asset('upload/news/') }}" + '/' + data.filename;
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