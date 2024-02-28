@extends('layouts.layoutDashboard')

@section('title', 'Ringkasan dan PAD')

@section('link')

@endsection

@section('style')

    <style media="screen">
        .letter .col-8 {
            text-align: center;
        }

        .letter img {
            height: 80px;
        }

        .letter b {
            text-transform: uppercase;
            font-weight: bold;
            color: #333333;
        }

        .letter-footer {
            text-align: center;
            font-size: 11px;
        }

        .letter-footer b {
            text-decoration: underline;
        }

        #table_id th,
        td {
            font-size: 12px !important;
            border: solid 1px black;
        }

        #table_id th {
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            .letter img {
                height: 40px;
            }
        }
    </style>

@endsection

@section('navigation')

@endsection

@section('content')

    <div class="d-flex flex-row">
        <!--begin::Content-->
        <div class="flex-row-fluid">
            <!--begin::Card-->

            <div class="card card-custom card-stretch">
                <!--begin::Header-->
                <div class="card-header py-3">
                    <div class="card-title mt-5">
                        <span class="card-icon mr-5">
                            <span class="svg-icon svg-icon-md svg-icon-primary">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
                                <i class="fa fa-book" style="color:#3699ff; font-size:28px"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                        <h3 class="card-label">
                            Ringkasan dan PAD
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item text-muted">
                                    <a href="#" class="text-muted">Laporan</a>
                                </li>
                                <li class="breadcrumb-item text-muted active">
                                    <a href="#" class="text-muted">Ringkasan dan PAD</a>
                                </li>
                            </ul>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        @if ($start_date == true && Auth::user()->role->reports_summary_print == 1)
                            <a href="/report/summary/export?change={{ $change }}&type={{ $type }}&start_date={{ $start_date }}&end_date={{ $end_date }}"
                                class="btn btn-success font-weight-bolder mr-2 mb-2">
                                <i class="fa fa-file-excel"></i>Excel
                            </a>
                            <a href="#" class="btn btn-primary font-weight-bolder mr-2 mb-2" id="printButton">
                                <i class="fa fa-print"></i>Print
                            </a>
                        @endif
                        <a href="#" class="btn btn-primary font-weight-bolder mb-2" id="filterButton">
                            <i class="fa fa-filter"></i>Filter
                        </a>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <!--begin::Body-->
                <div class="card-body">

                    <div class="letter mt-2 mb-4">
                        <div class="row">
                            <div class="col-2">
                                <img src="/images/logo-tabalong.jpeg" alt="Logo">
                            </div>
                            <div class="col-8">
                                <b>
                                    @if ($type == 'rekapitulasi_laporan_bulanan_hijau')
                                        REKAPITULASI LAPORAN BULANAN<br>
                                        PENDAPATAN DAERAH KABUPATEN TABALONG<br>
                                        TAHUN ANGGARAN {{ Auth::user()->year }}<br><br>
                                        WAKTU: {{ $start_date }} S/D {{ $end_date }} {{ Auth::user()->year }}
                                    @elseif($type == 'laporan_bulanan_merah')
                                        LAPORAN BULANAN <br>
                                        PENDAPATAN DAERAH KABUPATEN TABALONG <br>
                                        TAHUN ANGGARAN {{ Auth::user()->year }} <br><br>
                                        WAKTU: {{ $start_date }} S/D {{ $end_date }} {{ Auth::user()->year }}
                                    @else
                                        LAPORAN BULANAN PENDAPATAN ASLI DAERAH, DANA PERIMBANGAN DAN <br>
                                        LAIN-LAIN PENDAPATAN YANG SAH KABUPATEN TABALONG <br><br>
                                        WAKTU: {{ $start_date }} S/D {{ $end_date }} {{ Auth::user()->year }}
                                    @endif
                                </b>
                            </div>
                        </div>
                    </div>

                    <table id="table_id" width="100%" class="display compact table-responsive">
                        <thead>
                            <tr>
                                <th style="display: none;">Akun Order No</th>
                                <th rowspan="2">Kode Rekening</th>
                                <th rowspan="2">Uraian Pendapatan</th>
                                <th rowspan="2">Target</th>
                                @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                    <th rowspan="1" colspan="2">Realisasi S/D Bulan Lalu</th>
                                    <th rowspan="1" colspan="2">Realisasi Bulan Ini</th>
                                    <th rowspan="1" colspan="2">Realisasi S/D Bulan Ini</th>
                                    <th rowspan="2">Total S/D Bulan Ini</th>
                                    <th rowspan="2">%</th>
                                @endif
                                @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                    <th>Realisasi S/D Bulan Ini</th>
                                    <th rowspan="2">%</th>
                                    <th rowspan="2">Dasar Hukum</th>
                                    <th rowspan="2">Keterangan</th>
                                @endif
                            </tr>
                            @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                <tr>
                                    <th>Tahun Lalu</th>
                                    <th>Tahun Berjalan</th>
                                    <th>Tahun Lalu</th>
                                    <th>Tahun Berjalan</th>
                                    <th>Tahun Lalu</th>
                                    <th>Tahun Berjalan</th>
                                </tr>
                            @else
                                <!--<th>Tahun Lalu</th>-->
                                <!--<th>Tahun Berjalan</th>-->
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($account as $item_1)
                                @if ($type == 'laporan_bulanan_merah')
                                    @if ($item_1->mark_2 == 1)
                                        @if (count($item_1->children) > 0)
                                            @foreach ($array_summary as $item_2)
                                                <tr>
                                                    @if ($item_1->id == $item_2['id'])
                                                        <td style="display: none;"><b>{{ $item_2['order_number'] }}</b>
                                                        </td>
                                                        <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                                                        <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['target'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_last_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_last_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_this_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_this_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            @php
                                                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                                                if ($total != 0 && $item_2['target'] != 0) {
                                                                    $persen = ($total / $item_2['target']) * 100;
                                                                } else {
                                                                    $persen = 0;
                                                                }
                                                            @endphp
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($total, 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <b>{{ number_format($persen, 2) }}</b>
                                                            </td>
                                                        @endif
                                                        @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                                            @php
                                                                $total = $item_2['realisasi_until_last_month_before'] + $item_2['realisasi_this_month_before'] + $item_2['realisasi_this_month_after'] + $item_2['realisasi_until_last_month_after'];
                                                                if ($total != 0 && $item_2['target'] != 0) {
                                                                    $persen = ($total / $item_2['target']) * 100;
                                                                } else {
                                                                    $persen = 0;
                                                                }
                                                            @endphp
                                                            <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ',', '.') ?? '0' }}</b></td>-->
                                                            <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ',', '.') ?? '0' }}</b></td>-->
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($total, 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <b>{{ number_format($persen, 2) }}</b>
                                                            </td>
                                                            <td><b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                                                            <td><b>{{ $item_2['description'] ?? '-' }}</b></td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="display: none;">{{ $item_1->order_number }}</td>
                                                <td style="text-align: left;">{{ $item_1->number }}</td>
                                                <td style="text-align: left;">{{ $item_1->name }}</td>
                                                <td style="text-align: right;">
                                                    @if ($change == 'sebelum_perubahan')
                                                        {{ number_format($item_1->target_before, 2, ',', '.') ?? '0' }}
                                                    @elseif($change == 'sesudah_perubahan')
                                                        {{ number_format($item_1->target_after, 2, ',', '.') ?? '0' }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    @php
                                                        $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                                                        if ($change == 'sebelum_perubahan') {
                                                            $target = $item_1->target_before;
                                                        } elseif ($change == 'sesudah_perubahan') {
                                                            $target = $item_1->target_after;
                                                        } else {
                                                            $target = 0;
                                                        }
                                                        if ($total != 0 && $target != 0) {
                                                            $persen = ($total / $target) * 100;
                                                        } else {
                                                            $persen = 0;
                                                        }
                                                    @endphp
                                                    <td style="text-align: right;">
                                                        {{ number_format($total, 2, ',', '.') ?? '0' }}</td>
                                                    <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                                                @endif
                                                @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                                    @php
                                                        $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                                                        if ($change == 'sebelum_perubahan') {
                                                            $target = $item_1->target_before;
                                                        } elseif ($change == 'sesudah_perubahan') {
                                                            $target = $item_1->target_after;
                                                        } else {
                                                            $target = 0;
                                                        }
                                                        if ($total != 0 && $target != 0) {
                                                            $persen = ($total / $target) * 100;
                                                        } else {
                                                            $persen = 0;
                                                        }
                                                    @endphp
                                                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                    <td style="text-align: right;">
                                                        {{ number_format($total, 2, ',', '.') ?? '0' }}</td>
                                                    <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                                                    <td><b>{{ $item_1->legal_basis ?? '-' }}</b></td>
                                                    <td><b>{{ $item_1->description ?? '-' }}</b></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endif
                                @endif
                                @if ($type == 'rekapitulasi_laporan_bulanan_hijau')
                                    @if ($item_1->mark_1 == 1)
                                        @if (count($item_1->children) > 0)
                                            @foreach ($array_summary as $item_2)
                                                <tr>
                                                    @if ($item_1->id == $item_2['id'])
                                                        <td style="display: none;"><b>{{ $item_2['order_number'] }}</b>
                                                        </td>
                                                        <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                                                        <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['target'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_last_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_last_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_this_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_this_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            @php
                                                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                                                if ($total != 0 && $item_2['target'] != 0) {
                                                                    $persen = ($total / $item_2['target']) * 100;
                                                                } else {
                                                                    $persen = 0;
                                                                }
                                                            @endphp
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($total, 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <b>{{ number_format($persen, 2) }}</b>
                                                            </td>
                                                        @endif
                                                        @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                                            @php
                                                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                                                if ($total != 0 && $item_2['target'] != 0) {
                                                                    $persen = ($total / $item_2['target']) * 100;
                                                                } else {
                                                                    $persen = 0;
                                                                }
                                                            @endphp
                                                            <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ',', '.') ?? '0' }}</b></td>-->
                                                            <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ',', '.') ?? '0' }}</b></td>-->
                                                            <td style="text-align: right;">
                                                                <b>{{ number_format($total, 2, ',', '.') ?? '0' }}</b>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <b>{{ number_format($persen, 2) }}</b>
                                                            </td>
                                                            <td><b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                                                            <td><b>{{ $item_2['description'] ?? '-' }}</b></td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="display: none;">{{ $item_1->order_number }}</td>
                                                <td style="text-align: left;">{{ $item_1->number }}</td>
                                                <td style="text-align: left;">{{ $item_1->name }}</td>
                                                <td style="text-align: right;">
                                                    @if ($change == 'sebelum_perubahan')
                                                        {{ number_format($item_1->target_before, 2, ',', '.') ?? '0' }}
                                                    @elseif($change == 'sesudah_perubahan')
                                                        {{ number_format($item_1->target_after, 2, ',', '.') ?? '0' }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                    </td>
                                                    @php
                                                        $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                                                        if ($change == 'sebelum_perubahan') {
                                                            $target = $item_1->target_before;
                                                        } elseif ($change == 'sesudah_perubahan') {
                                                            $target = $item_1->target_after;
                                                        } else {
                                                            $target = 0;
                                                        }
                                                        if ($total != 0 && $target != 0) {
                                                            $persen = ($total / $target) * 100;
                                                        } else {
                                                            $persen = 0;
                                                        }
                                                    @endphp
                                                    <td style="text-align: right;">
                                                        {{ number_format($total, 2, ',', '.') ?? '0' }}</td>
                                                    <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                                                @endif
                                                @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                                    @php
                                                        $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                                                        if ($change == 'sebelum_perubahan') {
                                                            $target = $item_1->target_before;
                                                        } elseif ($change == 'sesudah_perubahan') {
                                                            $target = $item_1->target_after;
                                                        } else {
                                                            $target = 0;
                                                        }
                                                        if ($total != 0 && $target != 0) {
                                                            $persen = ($total / $target) * 100;
                                                        } else {
                                                            $persen = 0;
                                                        }
                                                    @endphp
                                                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                    <td style="text-align: right;">
                                                        {{ number_format($total, 2, ',', '.') ?? '0' }}</td>
                                                    <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                                                    <td><b>{{ $item_1->legal_basis ?? '-' }}</b></td>
                                                    <td><b>{{ $item_1->description ?? '-' }}</b></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endif
                                @endif
                                @if ($type == 'laporan_bulanan_pad')
                                    @if (count($item_1->children) > 0)
                                        @foreach ($array_summary as $item_2)
                                            <tr>
                                                @if ($item_1->id == $item_2['id'])
                                                    <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                                                    <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                                                    <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                                                    <td style="text-align: right;">
                                                        <b>{{ number_format($item_2['target'], 2, ',', '.') ?? '0' }}</b>
                                                    </td>
                                                    @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['realisasi_until_last_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['realisasi_until_last_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>

                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['realisasi_this_month_before'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['realisasi_this_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>

                                                        <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                        <td style="text-align: right;">
                                                            {{ number_format($item_2['realisasi_until_last_month_before'] + $item_2['realisasi_this_month_before'], 2, ',', '.') ?? '0' }}
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($item_2['realisasi_until_last_month_after'] + $item_2['realisasi_this_month_after'], 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        @php
                                                            $total = $item_2['realisasi_until_last_month_before'] + $item_2['realisasi_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                                            if ($total != 0 && $item_2['target'] != 0) {
                                                                $persen = ($total / $item_2['target']) * 100;
                                                            } else {
                                                                $persen = 0;
                                                            }
                                                        @endphp
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($total, 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <b>{{ number_format($persen, 2) }}</b>
                                                        </td>
                                                    @endif
                                                    @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                                        @php
                                                            $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                                            if ($total != 0 && $item_2['target'] != 0) {
                                                                $persen = ($total / $item_2['target']) * 100;
                                                            } else {
                                                                $persen = 0;
                                                            }
                                                        @endphp
                                                        <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ',', '.') ?? '0' }}</b></td>-->
                                                        <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ',', '.') ?? '0' }}</b></td>-->
                                                        <td style="text-align: right;">
                                                            <b>{{ number_format($total, 2, ',', '.') ?? '0' }}</b>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <b>{{ number_format($persen, 2) }}</b>
                                                        </td>
                                                        <td><b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                                                        <td><b>{{ $item_2['description'] ?? '-' }}</b></td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td style="display: none;">{{ $item_1->order_number }}</td>
                                            <td style="text-align: left;">{{ $item_1->number }}</td>
                                            <td style="text-align: left;">{{ $item_1->name }}</td>
                                            <td style="text-align: right;">
                                                @if ($change == 'sebelum_perubahan')
                                                    {{ number_format($item_1->target_before, 2, ',', '.') ?? '0' }}
                                                @elseif($change == 'sesudah_perubahan')
                                                    {{ number_format($item_1->target_after, 2, ',', '.') ?? '0' }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            @if ($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                                                <td style="text-align: right;">
                                                    {{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                </td>
                                                <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                <td style="text-align: right;">
                                                    {{ number_format($item_1->realisasi_this_month_before->sum('value') + $item_1->realisasi_until_last_month_before->sum('value'), 2, ',', '.') ?? '0' }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}
                                                </td>
                                                @php
                                                    $total = $item_1->realisasi_this_month_before->sum('value') + $item_1->realisasi_until_last_month_before->sum('value') + $item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value');
                                                    if ($change == 'sebelum_perubahan') {
                                                        $target = $item_1->target_before;
                                                    } elseif ($change == 'sesudah_perubahan') {
                                                        $target = $item_1->target_after;
                                                    } else {
                                                        $target = 0;
                                                    }
                                                    if ($total != 0 && $target != 0) {
                                                        $persen = ($total / $target) * 100;
                                                    } else {
                                                        $persen = 0;
                                                    }
                                                @endphp
                                                <td style="text-align: right;">
                                                    {{ number_format($total, 2, ',', '.') ?? '0' }}</td>
                                                <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                                            @endif
                                            @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                                @php

                                                    $total = $item_1->realisasi_this_month_before->sum('value') + $item_1->realisasi_until_last_month_before->sum('value') + $item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value');
                                                    if ($change == 'sebelum_perubahan') {
                                                        $target = $item_1->target_before;
                                                    } elseif ($change == 'sesudah_perubahan') {
                                                        $target = $item_1->target_after;
                                                    } else {
                                                        $target = 0;
                                                    }
                                                    if ($total != 0 && $target != 0) {
                                                        $persen = ($total / $target) * 100;
                                                    } else {
                                                        $persen = 0;
                                                    }
                                                @endphp
                                                <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ',', '.') ?? '0' }}</td>-->
                                                <td style="text-align: right;">
                                                    {{ number_format($total, 2, ',', '.') ?? '0' }}</td>
                                                <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                                                <td><b>{{ $item_1->legal_basis ?? '-' }}</b></td>
                                                <td><b>{{ $item_1->description ?? '-' }}</b></td>
                                            @endif
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    <div class="letter-footer mt-12">
                        <div class="row">
                            <div class="col-6">
                                @if ($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                    MENGETAHUI: <br><br>
                                    AN. BUPATI TABALONG : <br>
                                    SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                                    <b> HJ. HAMIDA MUNAWARAH, S.T., M.T </b><br>
                                    <small> Pembina Utama Muda </small><br>
                                    <small> NIP. 19670518 199803 2004 </small>
                                @endif
                            </div>
                            <div class="col-6">
                                <br><br>
                                Tempat, Tanggal <br>
                                KEPALA BADAN PENDAPATAN DAERAH KABUPATEN TABALONG<br><br><br><br>
                                <b> Drs. H. NANANG MULKANI, M.Si </b><br>
                                <small> Pembina Utama Muda </small><br>
                                <small> NIP. 19720306 199203 1 004 </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
        <!--end::Form-->
    </div>
    </div>
    <!--end::Content-->
    </div>

@endsection

@section('modal')

    <!--begin::Modal Filter-->
    <div class="modal fade" id="filterModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title text-white">Filter data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"
                        aria-label="Close">&times;</button>
                </div>
                <form action="/report/summary" method="get">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="">Perubahan</label>
                            <select name="change" class="form-control" required>
                                @if ($change != null)
                                    @if ($change == 'sebelum_perubahan')
                                        <option value="sebelum_perubahan" hidden>Sebelum Perubahan</option>
                                    @else
                                        <option value="sesudah_perubahan" hidden>Sesudah Perubahan</option>
                                    @endif
                                @endif
                                <option value="sebelum_perubahan">Sebelum Perubahan</option>
                                <option value="sesudah_perubahan">Sesudah Perubahan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Tipe</label>
                            <select name="type" class="form-control" required id="type">
                                @if ($type != null)
                                    @if ($type == 'laporan_bulanan_pad')
                                        @if (Auth::user()->role->reports_summary_all == 1)
                                            <option value="laporan_bulanan_pad" hidden>Laporan Bulanan PAD</option>
                                        @endif
                                    @elseif($type == 'laporan_bulanan_merah')
                                        <option value="laporan_bulanan_merah" hidden>Laporan Bulanan (Merah)</option>
                                    @else
                                        <option value="rekapitulasi_laporan_bulanan_hijau" hidden>Rekapitulasi Laporan
                                            Bulanan (Hijau)</option>
                                    @endif
                                @endif
                                @if (Auth::user()->role->reports_summary_all == 1)
                                    <option value="laporan_bulanan_pad">Laporan Bulanan PAD</option>
                                @endif
                                <option value="laporan_bulanan_merah">Laporan Bulanan (Merah)</option>
                                <option value="rekapitulasi_laporan_bulanan_hijau">Rekapitulasi Laporan Bulanan (Hijau)
                                </option>
                            </select>
                        </div>

                        <div class="form-group" id="date-group-start">
                            <label for="">Tanggal Mulai</label>
                            @if (Auth::user()->year)
                                <input type="text" name="start_date" value="{{ Auth::user()->year }}-01-01"
                                    id="kt_datepicker_start" class="form-control" required placeholder="Pilih Tanggal"
                                    autocomplete="off">
                            @else
                                <input type="text" name="start_date" value="" id="kt_datepicker_start" value="{{ $start_date }}"
                                    class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                            @endif
                        </div>

                        <div class="form-group" id="date-group-end">
                            <label for="">Tanggal Akhir</label>
                            <input type="text" name="end_date" value="{{ $end_date }}" id="kt_datepicker_end"
                                class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-outline-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal Filter-->

    <!--begin::Modal Print-->
    <div class="modal fade" id="printModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title text-white">Print data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"
                        aria-label="Close">&times;</button>
                </div>
                <form action="{{ route('report.summary.print') }}" method="get" target="_blank">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="change" value="{{ $change }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="start_date" value="{{ $start_date }}">
                        <input type="hidden" name="end_date" value="{{ $end_date }}">

                        <div class="form-group">
                            <label for="">Tempat/Tanggal</label>
                            <input type="text" class="form-control" name="ttgl"
                                placeholder="Masukkan Tempat, Tanggal" maxlength="250">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-outline-primary openPrint">Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal Print-->


@endsection

@section('script')

    <script src="/assets/printPage.js" charset="utf-8"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_id').DataTable({
                "pageLength": 1000,
                "bLengthChange": false,
                "bFilter": true,
                "paging": false,
                "ordering": [0, 'asc'],
                "bInfo": false,
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on("click", "#filterButton", function() {
            $("#filterModal").modal();
        });

        $(document).on("click", "#printButton", function() {
            $("#printModal").modal();
        });
    </script>

    <script type="text/javascript">
        // Class definition

        var KTBootstrapDatepicker = function() {

            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            // Private functions
            var datepicker = function() {
                // minimum setup
                $('#kt_datepicker_start').datepicker({
                    rtl: KTUtil.isRTL(),
                    format: 'yyyy-mm-dd',
                    viewMode: "days",
                    minViewMode: "days",
                    orientation: "bottom left",
                    templates: arrows,
                    //   startDate: '{{ Auth::user()->year }} 01',
                    //   endDate: '{{ Auth::user()->year }} 12',
                    //   defaultViewDate: {
                    //     year: '{{ Auth::user()->year }}',
                    //   },
                });
            }
            var datepickers = function() {
                // minimum setup
                $('#kt_datepicker_end').datepicker({
                    rtl: KTUtil.isRTL(),
                    format: 'yyyy-mm-dd',
                    viewMode: "days",
                    minViewMode: "days",
                    orientation: "bottom left",
                    templates: arrows,
                    //   startDate: '{{ Auth::user()->year }} 01',
                    //   endDate: '{{ Auth::user()->year }} 12',
                    //   defaultViewDate: {
                    //     year: '{{ Auth::user()->year }}',
                    //   },
                });
            }

            return {
                // public functions
                init: function() {
                    datepicker();
                    datepickers();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTBootstrapDatepicker.init();
        });
    </script>

    <script>
        var menu_link_1 = document.getElementById("kt_header_menu_2");
        menu_link_1.classList.add("active");

        var menu_link_2 = document.getElementById("kt_header_menu_mobile_2");
        menu_link_2.classList.add("active");

        var menu_link_3 = document.getElementById("kt_header_tab_2");
        menu_link_3.classList.add("active");
        menu_link_3.classList.add("show");

        var menu_link_4 = document.getElementById("menu_summary");
        menu_link_4.classList.add("menu-item-active");


        let type = document.getElementById('type');
        let tglMulai = document.getElementById('date-group-start');
        let tglAkhir = document.getElementById('date-group-end');
        let removeStart = document.getElementById('kt_datepicker_start');
        let removeEnd = document.getElementById('kt_datepicker_end');

        function handleTypeChange() {
            if (type.value == "laporan_bulanan_merah" || type.value == "rekapitulasi_laporan_bulanan_hijau") {
                tglMulai.classList.add('d-none');
                tglAkhir.classList.add('d-none');
                removeStart.removeAttribute('required');
                removeEnd.removeAttribute('required');
                removeEnd.value='';
            } else {
                tglMulai.classList.remove('d-none');
                tglAkhir.classList.remove('d-none');
                removeStart.setAttribute('required', 'true');
                removeEnd.setAttribute('required', 'true');
            }
        }

        window.addEventListener('load', handleTypeChange);

        type.addEventListener('change', handleTypeChange);
    </script>

@endsection
