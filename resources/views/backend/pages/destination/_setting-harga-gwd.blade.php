@extends('backend/layouts/template')

@section('title', 'Setting Harga Tiket GWD')

@section('bread')
    <h2>Setting Harga Tiket GWD</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/booking-gwd') }}">Booking GWD</a></li>
        <li class="active"><strong>Setting Harga Tiket GWD</strong></li>
    </ol>
@endsection

@section('main')

    <div class="row">
        <div class="col-lg-12">
            <div class="inqbox">
                <div class="inqbox-title border-top-success">
                    <h5>Setting Harga GWD</h5>
                    <br>
                </div>
                <div class="inqbox-content">
                    <form action="{{ url('admin/harga-tiket-gwd') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group @if ($errors->has('tiket_tabuhan')) has-error @endif">
                                    <label class="control-label" for="tiket_tabuhan">Tiket Tabuhan</label>
                                    <input id="tiket_tabuhan" type="number" name="tiket_tabuhan" class="form-control"
                                        placeholder="Tiket Tabuhan" value="@if (count($errors) > 0){{ old('tiket_tabuhan') }}@else{{ $tiket->tiket_tabuhan }}@endif" />

                                    @if ($errors->has('tiket_tabuhan'))
                                        <span for="tiket_tabuhan"
                                            class="help-block">{{ $errors->first('tiket_tabuhan') }}</span>
                                    @endif
                                </div>

                                <div class="form-group @if ($errors->has('tiket_glass_bottom')) has-error @endif">
                                    <label class="control-label" for="tiket_glass_bottom">Tiket Glass Bottom</label>
                                    <input id="tiket_glass_bottom" type="number" name="tiket_glass_bottom" class="form-control"
                                        placeholder="Tiket Glass Bottom" value="@if (count($errors) > 0){{ old('tiket_glass_bottom') }}@else{{ $tiket->tiket_glass_bottom }}@endif" />

                                    @if ($errors->has('tiket_glass_bottom'))
                                        <span for="tiket_glass_bottom"
                                            class="help-block">{{ $errors->first('tiket_glass_bottom') }}</span>
                                    @endif
                                </div>

                                <div class="form-group @if ($errors->has('tiket_mandi_bola')) has-error @endif">
                                    <label class="control-label" for="tiket_mandi_bola">Tiket Mandi Bola</label>
                                    <input id="tiket_mandi_bola" type="number" name="tiket_mandi_bola" class="form-control"
                                        placeholder="Tiket Mandi Bola" value="@if (count($errors) > 0){{ old('tiket_mandi_bola') }}@else{{ $tiket->tiket_mandi_bola }}@endif" />

                                    @if ($errors->has('tiket_mandi_bola'))
                                        <span for="tiket_mandi_bola"
                                            class="help-block">{{ $errors->first('tiket_mandi_bola') }}</span>
                                    @endif
                                </div>

                                <div class="form-group @if ($errors->has('tiket_kano')) has-error @endif">
                                    <label class="control-label" for="tiket_kano">Tiket Kano</label>
                                    <input id="tiket_kano" type="number" name="tiket_kano" class="form-control"
                                        placeholder="Tiket Kano" value="@if (count($errors) > 0){{ old('tiket_kano') }}@else{{ $tiket->tiket_kano }}@endif" />

                                    @if ($errors->has('tiket_kano'))
                                        <span for="tiket_kano"
                                            class="help-block">{{ $errors->first('tiket_kano') }}</span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="section">
                            <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                                <i class="fa fa-check"></i> Save
                            </button>

                            <a href="{{ url('admin/booking-gwd') }}" class="btn btn-danger">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
