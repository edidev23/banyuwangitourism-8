@extends('backend/layouts/template')
@section('title', 'Edit Destination')
@section('bread')
    <h2>Edit Destination</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/destination') }}">Destinations</a></li>
        <li class="active">
            <strong>Edit Destination</strong>
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
                    <form action="{{ url('admin/destination-tiket', $tiket->id) }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group @if ($errors->has('tiket_domestik')) has-error @endif">
                            <label class="control-label" for="tiket_domestik">Tiket Domestik</label>
                            <input id="tiket_domestik" type="number" name="tiket_domestik" class="form-control" placeholder="Tiket Domestik"
                                value="@if (count($errors)> 0){{ old('tiket_domestik') }}@else{{$tiket->tiket_domestik}}@endif" />

                            @if ($errors->has('tiket_domestik'))
                                <span for="tiket_domestik" class="help-block">{{ $errors->first('tiket_domestik') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('tiket_manca')) has-error @endif">
                            <label class="control-label" for="tiket_manca">Tiket Manca</label>
                            <input id="tiket_manca" type="number" name="tiket_manca" class="form-control" placeholder="Tiket Manca"
                                value="@if (count($errors)> 0){{ old('tiket_manca') }}@else{{$tiket->tiket_manca}}@endif" />

                            @if ($errors->has('tiket_manca'))
                                <span for="tiket_manca" class="help-block">{{ $errors->first('tiket_manca') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('tiket_weekend')) has-error @endif">
                            <label class="control-label" for="tiket_weekend">Tiket Weekend</label>
                            <input id="tiket_weekend" type="number" name="tiket_weekend" class="form-control" placeholder="Tiket Weekend"
                                value="@if (count($errors)> 0){{ old('tiket_weekend') }}@else{{$tiket->tiket_weekend}}@endif" />

                            @if ($errors->has('tiket_weekend'))
                                <span for="tiket_weekend" class="help-block">{{ $errors->first('tiket_weekend') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('parkir_roda_dua')) has-error @endif">
                            <label class="control-label" for="parkir_roda_dua">Parkir Roda Dua</label>
                            <input id="parkir_roda_dua" type="number" name="parkir_roda_dua" class="form-control" placeholder="Parkir Roda Dua"
                                value="@if (count($errors)> 0){{ old('parkir_roda_dua') }}@else{{$tiket->parkir_roda_dua}}@endif" />

                            @if ($errors->has('parkir_roda_dua'))
                                <span for="parkir_roda_dua" class="help-block">{{ $errors->first('parkir_roda_dua') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('parkir_roda_empat')) has-error @endif">
                            <label class="control-label" for="parkir_roda_empat">Parkir Roda Empat</label>
                            <input id="parkir_roda_empat" type="number" name="parkir_roda_empat" class="form-control" placeholder="Parkir Roda Empat"
                                value="@if (count($errors)> 0){{ old('parkir_roda_empat') }}@else{{$tiket->parkir_roda_empat}}@endif" />

                            @if ($errors->has('parkir_roda_empat'))
                                <span for="parkir_roda_empat" class="help-block">{{ $errors->first('parkir_roda_empat') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('parkir_bus')) has-error @endif">
                            <label class="control-label" for="parkir_bus">Parkir Bus</label>
                            <input id="parkir_bus" type="number" name="parkir_bus" class="form-control" placeholder="Parkir Bus"
                                value="@if (count($errors)> 0){{ old('parkir_bus') }}@else{{$tiket->parkir_bus}}@endif" />

                            @if ($errors->has('parkir_bus'))
                                <span for="parkir_bus" class="help-block">{{ $errors->first('parkir_bus') }}</span>
                            @endif
                        </div>

                        <hr>
                        <div class="section">
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

@endsection

@section('js')


@endsection
