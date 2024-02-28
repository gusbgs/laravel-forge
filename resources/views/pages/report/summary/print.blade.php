@extends('layouts.layoutPrint')

@section('title', 'Ringkasan dan PAD')

@section('link')

@endsection

@section('style')

  <style>

  table{
    width: 100% !important;
  }

  td, th{
    padding: 14px 0 !important;
  }

  .letter .col-8{
    text-align: center;
  }

  .letter img{
    height: 80px;
  }

  .letter b{
    text-transform: uppercase;
    font-weight: bold;
    color: #333333;
  }

  .letter-footer{
    text-align: center;
    font-size: 11px;
  }

  .letter-footer b{
    text-decoration: underline;
  }

  table.dataTable.no-footer{
    border-bottom: none !important;
  }

  .preview-header{
    background: white;
    display: inline-block;
    width: 100%;
  }

  .preview-header b{
    font-size: 20px;
  }
/*
  #table_id{
    margin-left: -12px;
  } */

  #table_id th, td{
    @if($type == 'rekapitulasi_laporan_bulanan_hijau')
      font-size: 12px !important;
    @elseif($type == 'laporan_bulanan_merah')
      font-size: 10px !important;
    @else
      font-size: 10px !important;
    @endif
    border: solid 1px black;
  }

  #table_id th{
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
  }

  @media only screen and (max-width: 600px) {
    .letter img{
      height: 40px;
    }
  }

</style>

<style media="print">
body
{
  margin: 0mm 10mm 0mm 10mm;
}

td, th{
  padding: 14px 0 !important;
}

  .preview-header{
    display: none;
  }

  .#table_id th, td{
    @if($type == 'rekapitulasi_laporan_bulanan_hijau')
      font-size: 10px !important;
    @elseif($type == 'laporan_bulanan_merah')
      font-size: 10px !important;
    @else
      font-size: 6px !important;
    @endif
    border: solid 1px black;
  }
</style>

@endsection

@section('navigation')

@endsection

@section('content')
  <div class="preview-header mt-4 mb-8 px-10 py-10">
    <div class="container-fluid">
      <b>Preview Print</b>
      <button class="btn btn-primary" onclick="window.print()" style="float:right">Print Halaman Ini</button>
    </div>
  </div>

  <div class="d-flex flex-row">
    <!--begin::Content-->
    <div class="flex-row-fluid">
      <!--begin::Card-->

      <div class="card card-custom card-stretch">

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
                  @if($type == 'rekapitulasi_laporan_bulanan_hijau')
                    REKAPITULASI LAPORAN BULANAN<br>
                    PENDAPATAN DAERAH KABUPATEN TABALONG<br>
                    TAHUN ANGGARAN {{ Auth::user()->year }}<br><br>
                    WAKTU: {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }}
                  @elseif($type == 'laporan_bulanan_merah')
                    LAPORAN BULANAN <br>
                    PENDAPATAN DAERAH KABUPATEN TABALONG <br>
                    TAHUN ANGGARAN {{ Auth::user()->year }} <br><br>
                    WAKTU: {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }}
                  @else
                    LAPORAN BULANAN PENDAPATAN ASLI DAERAH, DANA PERIMBANGAN DAN <br>
                    LAIN-LAIN PENDAPATAN YANG SAH KABUPATEN TABALONG <br><br>
                    WAKTU: {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }}
                  @endif
                </b>
              </div>
            </div>
          </div>
          <table id="table_id" width="100%" class="compact d-lg-table">
            <thead>
              <tr>
                <th style="display: none;">Akun Order No</th>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Uraian Pendapatan</th>
                <th rowspan="2">Target</th>
                @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                  <th rowspan="1" colspan="2">Realisasi S/D Bulan Lalu</th>
                  <th rowspan="1" colspan="2">Realisasi Bulan Ini</th>
                  <th rowspan="1" colspan="2">Realisasi S/D Bulan Ini</th>
                  <th rowspan="2">Total S/D Bulan Ini</th>
                  <th rowspan="2">%</th>
                @endif
                @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                  <th>Realisasi S/D Bulan Ini</th>
                  <th rowspan="2">%</th>
                  <th rowspan="2">Dasar Hukum</th>
                  <th rowspan="2">Keterangan</th>
                @endif
              </tr>
              @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
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
              @foreach($account as $item_1)
                @if($type == 'laporan_bulanan_merah')
                  @if($item_1->mark_2 == 1)
                    @if(count($item_1->children) > 0)
                      @foreach($array_summary as $item_2)
                        <tr>
                          @if($item_1->id == $item_2['id'])
                            <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                            <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                            <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($item_2['target'], 2, ",", ".") ?? '0' }}</b></td>
                            @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                              @php
                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                if($total != 0 && $item_2['target'] != 0)
                                {
                                  $persen = $total / $item_2['target']  * 100;
                                }else{
                                  $persen = 0;
                                }
                              @endphp
                              <td style="text-align: right;"><b>{{ number_format($total, 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: center;"><b>{{ number_format($persen, 2) }}</b></td>
                            @endif
                            @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                              @php
                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                if($total != 0 && $item_2['target'] != 0)
                                {
                                  $persen = $total / $item_2['target']  * 100;
                                }else{
                                  $persen = 0;
                                }
                              @endphp
                              <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>-->
                              <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>-->
                              <td style="text-align: right;"><b>{{ number_format($total, 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: center;"><b>{{ number_format($persen, 2) }}</b></td>
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
                          @if($change == 'sebelum_perubahan')
                            {{ number_format($item_1->target_before, 2, ",", ".") ?? '0' }}
                          @elseif($change == 'sesudah_perubahan')
                            {{ number_format($item_1->target_after, 2, ",", ".") ?? '0' }}
                          @else
                            0
                          @endif
                        </td>
                        @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          @php
                            $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                            if($change == 'sebelum_perubahan')
                            {
                              $target = $item_1->target_before;
                            }
                            elseif($change == 'sesudah_perubahan')
                            {
                              $target = $item_1->target_after;
                            }
                            else
                            {
                              $target = 0;
                            }
                            if($total != 0 && $target != 0)
                            {
                              $persen = $total / $target  * 100;
                            }else{
                              $persen = 0;
                            }
                          @endphp
                          <td style="text-align: right;">{{ number_format($total, 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                        @endif
                        @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                          @php
                            $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                            if($change == 'sebelum_perubahan')
                            {
                              $target = $item_1->target_before;
                            }
                            elseif($change == 'sesudah_perubahan')
                            {
                              $target = $item_1->target_after;
                            }
                            else
                            {
                              $target = 0;
                            }
                            if($total != 0 && $target != 0)
                            {
                              $persen = $total / $target  * 100;
                            }else{
                              $persen = 0;
                            }
                          @endphp
                          <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                          <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                          <td style="text-align: right;">{{ number_format($total, 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                          <td><b>{{ $item_1->legal_basis ?? '-' }}</b></td>
                          <td><b>{{ $item_1->description ?? '-' }}</b></td>
                        @endif
                      </tr>
                    @endif
                  @endif
                @endif
                @if($type == 'rekapitulasi_laporan_bulanan_hijau')
                  @if($item_1->mark_1 == 1)
                    @if(count($item_1->children) > 0)
                      @foreach($array_summary as $item_2)
                        <tr>
                          @if($item_1->id == $item_2['id'])
                            <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                            <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                            <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($item_2['target'], 2, ",", ".") ?? '0' }}</b></td>
                            @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                              @php
                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                if($total != 0 && $item_2['target'] != 0)
                                {
                                  $persen = $total / $item_2['target']  * 100;
                                }else{
                                  $persen = 0;
                                }
                              @endphp
                              <td style="text-align: right;"><b>{{ number_format($total, 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: center;"><b>{{ number_format($persen, 2) }}</b></td>
                            @endif
                            @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                              @php
                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                if($total != 0 && $item_2['target'] != 0)
                                {
                                  $persen = $total / $item_2['target']  * 100;
                                }else{
                                  $persen = 0;
                                }
                              @endphp
                              <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>-->
                              <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>-->
                              <td style="text-align: right;"><b>{{ number_format($total, 2, ",", ".") ?? '0' }}</b></td>
                              <td style="text-align: center;"><b>{{ number_format($persen, 2) }}</b></td>
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
                          @if($change == 'sebelum_perubahan')
                            {{ number_format($item_1->target_before, 2, ",", ".") ?? '0' }}
                          @elseif($change == 'sesudah_perubahan')
                            {{ number_format($item_1->target_after, 2, ",", ".") ?? '0' }}
                          @else
                            0
                          @endif
                        </td>
                        @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                          @php
                            $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                            if($change == 'sebelum_perubahan')
                            {
                              $target = $item_1->target_before;
                            }
                            elseif($change == 'sesudah_perubahan')
                            {
                              $target = $item_1->target_after;
                            }
                            else
                            {
                              $target = 0;
                            }
                            if($total != 0 && $target != 0)
                            {
                              $persen = $total / $target  * 100;
                            }else{
                              $persen = 0;
                            }
                          @endphp
                          <td style="text-align: right;">{{ number_format($total, 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                        @endif
                        @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                          @php
                            $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                            if($change == 'sebelum_perubahan')
                            {
                              $target = $item_1->target_before;
                            }
                            elseif($change == 'sesudah_perubahan')
                            {
                              $target = $item_1->target_after;
                            }
                            else
                            {
                              $target = 0;
                            }
                            if($total != 0 && $target != 0)
                            {
                              $persen = $total / $target  * 100;
                            }else{
                              $persen = 0;
                            }
                          @endphp
                          <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                          <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                          <td style="text-align: right;">{{ number_format($total, 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                          <td><b>{{ $item_1->legal_basis ?? '-' }}</b></td>
                          <td><b>{{ $item_1->description ?? '-' }}</b></td>
                        @endif
                      </tr>
                    @endif
                  @endif
                @endif
                @if($type == 'laporan_bulanan_pad')
                  @if(count($item_1->children) > 0)
                    @foreach($array_summary as $item_2)
                      <tr>
                        @if($item_1->id == $item_2['id'])
                          <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                          <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                          <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                          <td style="text-align: right;"><b>{{ number_format($item_2['target'], 2, ",", ".") ?? '0' }}</b></td>
                          @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                            <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_after'], 2, ",", ".") ?? '0' }}</b></td>

                            <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>
                            <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>

                            <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                            <td style="text-align: right;">{{ number_format($item_2['realisasi_until_last_month_before'] +$item_2['realisasi_this_month_before'], 2, ",", ".") ?? '0' }}</td>
                            <td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_last_month_after'] + $item_2['realisasi_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>
                            @php
                              $total = $item_2['realisasi_until_last_month_before'] +$item_2['realisasi_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                              if($total != 0 && $item_2['target'] != 0)
                              {
                                $persen = $total / $item_2['target']  * 100;
                              }else{
                                $persen = 0;
                              }
                            @endphp
                            <td style="text-align: right;"><b>{{ number_format($total, 2, ",", ".") ?? '0' }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($persen, 2) }}</b></td>
                          @endif
                          @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                            @php
                              $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                              if($total != 0 && $item_2['target'] != 0)
                              {
                                $persen = $total / $item_2['target']  * 100;
                              }else{
                                $persen = 0;
                              }
                            @endphp
                                    <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>-->
                            <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>-->
                            <td style="text-align: right;"><b>{{ number_format($total, 2, ",", ".") ?? '0' }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($persen, 2) }}</b></td>
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
                        @if($change == 'sebelum_perubahan')
                          {{ number_format($item_1->target_before, 2, ",", ".") ?? '0' }}
                        @elseif($change == 'sesudah_perubahan')
                          {{ number_format($item_1->target_after, 2, ",", ".") ?? '0' }}
                        @else
                          0
                        @endif
                      </td>
                      @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
                        <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                        <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                        <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                        <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                        <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                        <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_before->sum('value') + $item_1->realisasi_until_last_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                        <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                        @php
                          $total = $item_1->realisasi_this_month_before->sum('value') + $item_1->realisasi_until_last_month_before->sum('value') + $item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value');
                          if($change == 'sebelum_perubahan')
                          {
                            $target = $item_1->target_before;
                          }
                          elseif($change == 'sesudah_perubahan')
                          {
                            $target = $item_1->target_after;
                          }
                          else
                          {
                            $target = 0;
                          }
                          if($total != 0 && $target != 0)
                          {
                            $persen = $total / $target  * 100;
                          }else{
                            $persen = 0;
                          }
                        @endphp
                        <td style="text-align: right;">{{ number_format($total, 2, ",", ".") ?? '0' }}</td>
                        <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                      @endif
                      @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                        @php

                          $total = $item_1->realisasi_this_month_before->sum('value') + $item_1->realisasi_until_last_month_before->sum('value') + $item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value');
                          if($change == 'sebelum_perubahan')
                          {
                            $target = $item_1->target_before;
                          }
                          elseif($change == 'sesudah_perubahan')
                          {
                            $target = $item_1->target_after;
                          }
                          else
                          {
                            $target = 0;
                          }
                          if($total != 0 && $target != 0)
                          {
                            $persen = $total / $target  * 100;
                          }else{
                            $persen = 0;
                          }
                        @endphp
                                <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                        <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                        <td style="text-align: right;">{{ number_format($total, 2, ",", ".") ?? '0' }}</td>
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

          <div class="letter-footer mt-12" style="break-inside: avoid;">
            <div class="row">
              <div class="col-6">
                @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
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
                {{ $ttgl }} <br>
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

@section('script')

  <script type="text/javascript">
    $(document).ready( function () {
      $('#table_id').DataTable({
        "pageLength": 1000,
        "bLengthChange": false,
        "bFilter": false,
        "paging": false,
        "ordering": [0, 'asc'],
        "bInfo": false,
      });
    } );
  </script>

@endsection
