@extends('backend/layouts/template')

@section('title', 'Dashboard')

@section('bread')
    <h2>Dashboard</h2>
@endsection

@section('css')
    <style>
        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .angka {
            font-size: 24px;
            line-height: 1;
            font-weight: bold;
            color: #00695f;
        }

    </style>
@endsection

@section('main')
    <div class="row">
        <div class="col-lg-4">
            <div class="inqbox">
                <div class="inqbox-content flex">
                    <div>
                        <h3>Total Handcraft</h3>
                        <div class="angka">
                            {{ $data['handcraft'] }} Data
                        </div>
                    </div>
                    <div>
                        <a href="{{ url('admin/handcraft') }}" class="btn btn-info">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="inqbox">
                <div class="inqbox-content flex">
                    <div>
                        <h3>Total Culinary</h3>
                        <div class="angka">
                            {{ $data['culinary'] }} Data
                        </div>
                    </div>
                    <div>
                        <a href="{{ url('admin/culinary') }}" class="btn btn-success">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="inqbox">
                <div class="inqbox-content flex">
                    <div>
                        <h3>Total Hotline</h3>
                        <div class="angka">
                            {{ $data['hotline'] }} Data
                        </div>
                    </div>

                    <div>
                        <a href="{{ url('admin/hotline') }}" class="btn btn-warning">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="inqbox">
                <div class="inqbox-content">
                    <div class="flex" style="margin-bottom: 12px">
                        <h3>Jumlah Berita TH {{ date('Y') }}</h3>
                        <a href="{{ url('admin/news') }}" class="btn">
                            Detail
                        </a>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>Bulan</th>
                            <th>Total</th>
                        </tr>
                        @foreach ($data['bulan'] as $bulan)
                            <tr>
                                <td width="80%">{{ $bulan['nama'] }}</td>
                                <td align="center">
                                    @foreach ($data['news'] as $news)
                                        @if ($news->bulan == $bulan['id'])
                                            {{ $news->total }} @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="inqbox">
                <div class="inqbox-content">
                    <div class="flex" style="margin-bottom: 12px">
                        <h3>Jumlah Festival TH {{ date('Y') }}</h3>
                        <a href="{{ url('admin/festival') }}">
                            Detail
                        </a>
                    </div>
                    <table class=" table table-striped table-bordered table-hover">
                        <tr>
                            <th>Bulan</th>
                            <th>Total</th>
                        </tr>
                        @foreach ($data['bulan'] as $bulan)
                            <tr>
                                <td width="80%">{{ $bulan['nama'] }}</td>
                                <td align="center">
                                    @foreach ($data['festival'] as $festival)
                                        @if ($festival->bulan == $bulan['id'])
                                            {{ $festival->total }} @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="inqbox">
                <div class="inqbox-content">
                    <div class="flex" style="margin-bottom: 12px">
                        <h3>Total Destinasi per Kategori</h3>
                        <a href="{{ url('admin/destination') }}" class="btn">
                            Detail
                        </a>
                    </div>


                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>Kategori</th>
                            <th>Total</th>
                        </tr>
                        @foreach ($data['destination_category'] as $category)
                            <tr>
                                <td width="80%">{{ $category->name }}</td>
                                <td align="center">
                                    @foreach ($data['destination'] as $destination)
                                        @if ($destination->category == $category->destination_category_id)
                                            {{ $destination->total }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
