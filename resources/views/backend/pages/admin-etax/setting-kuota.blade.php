@extends('backend/layouts/template')

@section('title', 'Setting Kuota dan Hari Libur')

@section('bread')
    <h2>Setting Kuota dan Hari Libur</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/destination') }}">Destination</a></li>
        <li class="active"><strong>Setting Kuota dan Hari Libur</strong></li>
    </ol>
@endsection

@section('main')

    <div class="row">
        <div class="col-lg-12">
            <div class="inqbox">
                <div class="inqbox-title border-top-success">
                    <h5>Setting Kuota</h5>
                    <br>
                </div>
                <div class="inqbox-content">
                    <form action="{{ url('admin/setting-kuota') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group @if ($errors->has('name')) has-error @endif">
                                    <label class="control-label" for="status_kuota">Status Kuota</label>
                                    <select name="status_kuota" id="status_kuota" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="1" @if ((count($errors) > 0 && old('status_kuota') == 1) || $tiket->status_kuota == 1) selected @endif>Aktif</option>
                                        <option value="0" @if ((count($errors) > 0 && old('status_kuota') == 0) || $tiket->status_kuota == 0) selected @endif>Non Aktif</option>
                                    </select>

                                    @if ($errors->has('status_kuota'))
                                        <span for="status_kuota"
                                            class="help-block">{{ $errors->first('status_kuota') }}</span>
                                    @endif
                                </div>
                                <div class="form-group @if ($errors->has('limit_kuota')) has-error @endif">
                                    <label class="control-label" for="limit_kuota">Limit Kuota</label>
                                    <input id="limit_kuota" type="number" name="limit_kuota" class="form-control"
                                        placeholder="Limit Kuota" value="@if (count($errors) > 0){{ old('limit_kuota') }}@else{{ $tiket->limit_kuota }}@endif" />

                                    @if ($errors->has('limit_kuota'))
                                        <span for="limit_kuota"
                                            class="help-block">{{ $errors->first('limit_kuota') }}</span>
                                    @endif
                                </div>

                                <div>
                                    <label for="">Hari Libur</label> <br>
                                    @foreach ($list_hari as $item)
                                        <div class="form-check" style="display: inline-block; margin-right: 20px">
                                            <input type="checkbox" class="form-check-input" id="{{ $item }}"
                                                name="hari_libur[]" @if (checkHariLibur($hari_libur, $loop->index + 1)) checked @endif
                                                value="{{ $loop->index + 1 }}">
                                            <label class="form-check-label" for="{{ $item }}">{{ $item }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="section">
                            <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                                <i class="fa fa-check"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
