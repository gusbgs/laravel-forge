@extends('layouts.layoutPrint')

@section('title', 'Laporan Keseluruhan')

@section('link')

@endsection

@section('style')

<style>

.pagebreak {
  page-break-before: always;
  }

table{
  width: 100% !important;
}

td, th{
  padding: 14px 0 !important;
}

.summary-table .letter .col-8{
  text-align: center;
}

.summary-table .letter img{
  height: 80px;
}

.summary-table .letter b{
  text-transform: uppercase;
  font-weight: bold;
  color: #333333;
}

.summary-table .letter-footer{
  text-align: center;
  font-size: 11px;
}

.summary-table .letter-footer b{
  text-decoration: underline;
}

.income-table .letter .col-8{
  text-align: center;
}

.income-table .letter img{
  height: 80px;
}

.income-table .letter b{
  text-transform: uppercase;
  font-weight: bold;
  color: #333333;
}

.income-table .letter-2{
  font-weight: bold;
}

.income-table .letter-footer{
  text-align: center;
  font-size: 11px;
}

.income-table .letter-footer b{
  text-decoration: underline;
}

table.dataTable.no-footer{
  border-bottom: none !important;
}


.table_id th{
  font-weight: bold;
  text-transform: uppercase;
  text-align: center;
}

.preview-header{
  background: white;
  display: inline-block;
  width: 100%;
}

.preview-header b{
  font-size: 20px;
}

/* #table_id_1, #table_id_2, #table_id_3, #table_id_4{
  margin-left: -12px;
} */

#table_id_1 th, #table_id_1 td{
  font-size: 6px;
  border: solid 1px black;
}

#table_id_2 th, #table_id_2 td{
  font-size: 13px;
  border: solid 1px black;
}

#table_id_3 th, #table_id_3 td{
  font-size: 12px;
  border: solid 1px black;
}

#table_id_4 th, #table_id_4 td{
  font-size: 12px;
  border: solid 1px black;
}

@media only screen and (max-width: 600px) {
  .summary-table .letter img{
    height: 40px;
  }
}

</style>

<style media="print">
body
{
  margin: 0mm 10mm 0mm 10mm;
}

#table_id_1 th, #table_id_1 td{
  font-size: 6px;
}

#table_id_2 th, #table_id_2 td{
  font-size: 10px;
}

#table_id_3 th, #table_id_3 td{
  font-size: 10px;
}

#table_id_4 th, #table_id_4 td{
  font-size: 10px;
}

td, th{
  padding: 14px 0 !important;
}

  .preview-header{
    display: none;
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

  {{-- ///////////////////////////////Tabel Ringkasan dan PAD////////////////////////////////// --}}


  <!--begin::Content-->
  <div class="d-flex flex-row summary-table mb-6">
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

                  LAPORAN BULANAN PENDAPATAN ASLI DAERAH, DANA PERIMBANGAN DAN <br>
                  LAIN-LAIN PENDAPATAN YANG SAH KABUPATEN TABALONG <br><br>
                  WAKTU: {{ $start_date_summary}} S/D {{ $end_date_summary}}
                </b>
              </div>
            </div>
          </div>

          <table width="100%" id="table_id_1" class="compact table_id">
            <thead>
              <tr>
                <th style="display: none;">Akun Order No</th>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Uraian Pendapatan</th>
                <th rowspan="2">Target</th>
                <th rowspan="1" colspan="2">Realisasi S/D Bulan Lalu</th>
                <th rowspan="1" colspan="2">Realisasi Bulan Ini</th>
                <th rowspan="1" colspan="2">Realisasi S/D Bulan Ini</th>
                <th rowspan="2">Total S/D Bulan Ini</th>
                <th rowspan="2">%</th>
                <!--<th rowspan="2">Dasar Hukum</th>-->
              </tr>
              <tr>
                <th>Tahun Lalu</th>
                <th>Tahun Berjalan</th>
                <th>Tahun Lalu</th>
                <th>Tahun Berjalan</th>
                <th>Tahun Lalu</th>
                <th>Tahun Berjalan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($account_summary_all as $item_1)
                @if(count($item_1->children) > 0)
                  @foreach($array_summary_all as $item_2)
                    <tr>
                      @if($item_1->id == $item_2['id'])
                        <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                        <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                        <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                        <td style="text-align: right;"><b>{{ number_format($item_2['target'], 2, ",", ".") ?? '0' }}</b></td>
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
                        <!--<td><b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>-->
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td style="display: none;">{{ $item_1->order_number }}</td>
                    <td style="text-align: left;">{{ $item_1->number }}</td>
                    <td style="text-align: left;">{{ $item_1->name }}</td>
                    <td style="text-align: right;">
                      @if($change_summary_all == 'sebelum_perubahan')
                        {{ number_format($item_1->target_before, 2, ",", ".") ?? '0' }}
                      @elseif($change_summary_all == 'sesudah_perubahan')
                        {{ number_format($item_1->target_after, 2, ",", ".") ?? '0' }}
                      @else
                        0
                      @endif
                    </td>
                    <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item_1->realisasi_until_last_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item_1->realisasi_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>
                    @php
                      $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                      if($change_summary_all == 'sebelum_perubahan')
                      {
                        $target = $item_1->target_before;
                      }
                      elseif($change_summary_all == 'sesudah_perubahan')
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
                    <!--<td>{{ $item_1->legal_basis ?? '-' }}</td>-->
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>

          <div class="letter-footer mt-12" style="break-inside: avoid;">
            <div class="row">
              <div class="col-6">
                <!--MENGETAHUI: <br><br>-->
                <!--AN. BUPATI TABALONG : <br>-->
                <!--SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>-->
                <!--<b> Drs. H.A. MUTHALIB SANGADJI, M,Si </b><br>-->
                <!--<small> Pembina Utama Muda </small><br>-->
                <!--<small> NIP. 19630129 198503 1 005 </small>-->
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
  <!--end::Content-->


  {{-- ///////////////////////////////Tabel Laporan Bulanan (Merah)////////////////////////////////// --}}

  <div class="pagebreak"> </div>
  <!--begin::Content-->
  <div class="d-flex flex-row summary-table mb-6">
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
                  LAPORAN BULANAN <br>
                  PENDAPATAN DAERAH KABUPATEN TABALONG <br>
                  TAHUN ANGGARAN {{ Auth::user()->year }} <br><br>
                  WAKTU: {{ $start_date_summary_red}} S/D {{ $end_date_summary_red}}
                </b>
              </div>
            </div>
          </div>

          <table width="100%" id="table_id_2" class="compact d-lg-table table_id">
            <thead>
              <tr>
                <th style="display: none;">Akun Order No</th>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Uraian Pendapatan</th>
                <th rowspan="2">Target</th>
                <!--<th rowspan="1" colspan="2">Realisasi S/D Bulan Lalu</th>-->
                <!--<th rowspan="1" colspan="2">Realisasi Bulan Ini</th>-->
                <th>Realisasi S/D Bulan Ini</th>
                <!--<th rowspan="2">Total S/D Bulan Ini</th>-->
                <th rowspan="2">%</th>
                <th rowspan="2">Dasar Hukum</th>
                <th rowspan="2">Keterangan</th>
              </tr>
              <tr>
                <!--  <th>Tahun Lalu</th>-->
                <!--  <th>Tahun Berjalan</th>-->
                <!--  <th>Tahun Lalu</th>-->
                <!--  <th>Tahun Berjalan</th>-->
                <!--<th>Tahun Lalu</th>-->
                <!--<th>Tahun Berjalan</th>-->
              </tr>
            </thead>
            <tbody>
              @foreach($account_summary_red as $item_1)
              @if($item_1->mark_2 == 1)
                @if(count($item_1->children) > 0)
                  @foreach($array_summary_red as $item_2)
                  @if($item_2['mark'] == 1)
                    <tr>
                      @if($item_1->id == $item_2['id'])
                        <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                        <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                        <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                        <td style="text-align: right;"><b>{{ number_format($item_2['target'], 2, ",", ".") ?? '0' }}</b></td>
                        <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>-->
                        <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>-->
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
                        <td><b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                        <td><b>{{ $item_2['description'] ?? '-' }}</b></td>
                      @endif
                    </tr>
                  @endif
                  @endforeach
                @else
                  <tr>
                    <td style="display: none;">{{ $item_1->order_number }}</td>
                    <td style="text-align: left;">{{ $item_1->number }}</td>
                    <td style="text-align: left;">{{ $item_1->name }}</td>
                    <td style="text-align: right;">
                      @if($change_summary_red == 'sebelum_perubahan')
                        {{ number_format($item_1->target_before, 2, ",", ".") ?? '0' }}
                      @elseif($change_summary_red == 'sesudah_perubahan')
                        {{ number_format($item_1->target_after, 2, ",", ".") ?? '0' }}
                      @else
                        0
                      @endif
                    </td>
                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                    @php
                      $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                      if($change_summary_red == 'sebelum_perubahan')
                      {
                        $target = $item_1->target_before;
                      }
                      elseif($change_summary_red == 'sesudah_perubahan')
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
                    <td>{{ $item_1->legal_basis ?? '-' }}</td>
                    <td>{{ $item_1->description ?? '-' }}</td>
                  </tr>
                @endif
              @endif
              @endforeach
            </tbody>
          </table>

          <div class="letter-footer mt-12" style="break-inside: avoid;">
            <div class="row">
              <div class="col-6">
                MENGETAHUI: <br><br>
                AN. BUPATI TABALONG : <br>
                SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                <b> Drs. H.A. MUTHALIB SANGADJI, M,Si </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19630129 198503 1 005 </small>
              </div>
              <div class="col-6">
                <br><br>
                {{ $ttgl }} <br>
                KEPALA BADAN PENDAPATAN DAERAH <br>
                KABUPATEN TABALONG, <br><br><br><br>
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
  <!--end::Content-->


  {{-- ///////////////////////////////Tabel Rekapitulasi Laporan Bulanan (Hijau)////////////////////////////////// --}}

  <div class="pagebreak"> </div>
  <!--begin::Content-->
  <div class="d-flex flex-row summary-table mb-6">
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
                  REKAPITULASI LAPORAN BULANAN<br>
                  PENDAPATAN DAERAH KABUPATEN TABALONG<br>
                  TAHUN ANGGARAN {{ Auth::user()->year }}<br><br>
                  WAKTU: {{ $start_date_summary_green}} S/D {{ $end_date_summary_green}}
                </b>
              </div>
            </div>
          </div>

          <table width="100%" id="table_id_3" class="compact d-lg-table table_id">
            <thead>
              <tr>
                <th style="display: none;">Akun Order No</th>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Uraian Pendapatan</th>
                <th rowspan="2">Target</th>
                <!--<th rowspan="1" colspan="2">Realisasi S/D Bulan Lalu</th>-->
                <!--<th rowspan="1" colspan="2">Realisasi Bulan Ini</th>-->
                <th>Realisasi S/D Bulan Ini</th>
                <!--<th rowspan="2">Total S/D Bulan Ini</th>-->
                <th rowspan="2">%</th>
                <th rowspan="2">Dasar Hukum</th>
                <th rowspan="2">Keterangan</th>
              </tr>
              <tr>
                <!--<th>Tahun Lalu</th>-->
                <!--<th>Tahun Berjalan</th>-->
                <!--  <th>Tahun Lalu</th>-->
                <!--  <th>Tahun Berjalan</th>-->
                <!--  <th>Tahun Lalu</th>-->
                <!--  <th>Tahun Berjalan</th>-->
              </tr>
            </thead>
            <tbody>
              @foreach($account_summary_green as $item_1)
              @if($item_1->mark_1 == 1)
                @if(count($item_1->children) > 0)
                  @foreach($array_summary_green as $item_2)
                  @if($item_2['mark'] == 1)
                    <tr>
                      @if($item_1->id == $item_2['id'])
                        <td style="display: none;"><b>{{ $item_2['order_number'] }}</b></td>
                        <td style="text-align: left;"><b>{{ $item_2['number'] }}</b></td>
                        <td style="text-align: left;"><b>{{ $item_2['name'] }}</b></td>
                        <td style="text-align: right;"><b>{{ number_format($item_2['target'], 2, ",", ".") ?? '0' }}</b></td>
                        <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_before'], 2, ",", ".") ?? '0' }}</b></td>-->
                        <!--<td style="text-align: right;"><b>{{ number_format($item_2['realisasi_until_this_month_after'], 2, ",", ".") ?? '0' }}</b></td>-->
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
                        <td><b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                        <td><b>{{ $item_2['description'] ?? '-' }}</b></td>
                      @endif
                    </tr>
                  @endif
                  @endforeach
                @else
                  <tr>
                    <td style="display: none;">{{ $item_1->order_number }}</td>
                    <td style="text-align: left;">{{ $item_1->number }}</td>
                    <td style="text-align: left;">{{ $item_1->name }}</td>
                    <td style="text-align: right;">
                      @if($change_summary_green == 'sebelum_perubahan')
                        {{ number_format($item_1->target_before, 2, ",", ".") ?? '0' }}
                      @elseif($change_summary_green == 'sesudah_perubahan')
                        {{ number_format($item_1->target_after, 2, ",", ".") ?? '0' }}
                      @else
                        0
                      @endif
                    </td>
                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_before->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                    <!--<td style="text-align: right;">{{ number_format($item_1->realisasi_until_this_month_after->sum('value'), 2, ",", ".") ?? '0' }}</td>-->
                    @php
                      $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                      if($change_summary_green == 'sebelum_perubahan')
                      {
                        $target = $item_1->target_before;
                      }
                      elseif($change_summary_green)
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
                    <td>{{ $item_1->legal_basis ?? '-' }}</td>
                    <td>{{ $item_1->description ?? '-' }}</td>
                  </tr>
                @endif
              @endif
              @endforeach
            </tbody>
          </table>

          <div class="letter-footer mt-12" style="break-inside: avoid;">
            <div class="row">
              <div class="col-6">
                MENGETAHUI: <br><br>
                AN. BUPATI TABALONG : <br>
                SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                <b> HJ. HAMIDA MUNAWARAH, S.T., M.T </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19670518 199803 2004 </small>
              </div>
              <div class="col-6">
                <br><br>
                {{ $ttgl }} <br>
                KEPALA BADAN PENDAPATAN DAERAH <br>
                KABUPATEN TABALONG, <br><br><br><br>
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
  <!--end::Content-->
  
  {{-- ///////////////////////////////Tabel Pendapatan////////////////////////////////// --}}
    
    @foreach($income as $item_1)
    <div class="pagebreak"> </div>
    <!--begin::Content-->
    <div class="d-flex flex-row income-table mb-6">
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
                    LAPORAN REALISASI PENERIMAAN PENDAPATAN PER SKPD  <br>
                    LINGKUP PEMERINTAH KABUPATEN TABALONG <br>
                    Tahun Anggaran {{ Auth::user()->year }} <br>
                  </b>
                </div>
              </div>
            </div>
    
            <div class="letter-2 mt-6 mb-4">
              <div class="row">
                <div class="col-2">
                  SKPD
                </div>
                <div class="col-10">
                  : {{ $item_1[0] }}
                </div>
              </div>
    
              <div class="row">
                <div class="col-2">
                  Waktu
                </div>
                <div class="col-10">
                  : {{ $start_date_income}} S/D {{ $end_date_income}}
                </div>
              </div>
            </div>
    
            <table width="100%" id="table_id_4" class="table_id compact d-lg-table">
              <thead>
                <tr>
                  <th style="display: none;">Akun Order No</th>
                  <th>Kode Rekening</th>
                  <th>Uraian Pendapatan</th>
                  <th>Target</th>
                  <th>Realisasi S/D Bulan Lalu</th>
                  <th>Realisasi Bulan Ini</th>
                  <th>Realisasi S/D Bulan Ini</th>
                  <th>%</th>
                </tr>
              </thead>
              <tbody>
                @foreach($item_1[1] as $item)
                  @php
                    if($item['realisasi_until_this_month'] != 0 && $item['target'] != 0)
                    {
                      $persen = $item['realisasi_until_this_month'] / $item['target']  * 100;
                    }else{
                      $persen = 0;
                    }
                  @endphp
                  <tr>
                    <td style="display: none;">{{ $item['order_number'] }}</td>
                    <td style="text-align: left;">{{ $item['number'] }}</td>
                    <td style="text-align: left;">{{ $item['name'] }}</td>
                    <td style="text-align: right;">{{ number_format($item['target'], 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item['realisasi_until_last_month'], 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item['realisasi_this_month'], 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: right;">{{ number_format($item['realisasi_until_this_month'], 2, ",", ".") ?? '0' }}</td>
                    <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
    
            <div class="letter-footer mt-6" style="break-inside: avoid;">
              <div class="row">
                <div class="col-8">
                </div>
                <div class="col-4">
                  <br><br>
                  Kepala Bidang Pengendalian  <br><br><br><br>
                  <b> LYNA HOLWATI, S.STP </b><br>
                  <small> NIP. 19840918 200312 2 001  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end::Body-->
      <!--end::Form-->
    </div>
    <!--end::Content-->
    @endforeach


@endsection

@section('script')

  <script type="text/javascript">
    $(document).ready( function () {
      $('#table_id_1').DataTable({
        "pageLength": 1000,
        "bLengthChange": false,
        "bFilter": false,
        "paging": false,
        "ordering": [0, 'asc'],
        "bInfo": false,
      });
    });

    $(document).ready( function () {
      $('#table_id_2').DataTable({
        "pageLength": 1000,
        "bLengthChange": false,
        "bFilter": false,
        "paging": false,
        "ordering": [0, 'asc'],
        "bInfo": false,
      });
    });

    $(document).ready( function () {
      $('#table_id_3').DataTable({
        "pageLength": 1000,
        "bLengthChange": false,
        "bFilter": false,
        "paging": false,
        "ordering": [0, 'asc'],
        "bInfo": false,
      });
    });

    $(document).ready( function () {
      $('#table_id_4').DataTable({
        "pageLength": 1000,
        "bLengthChange": false,
        "bFilter": false,
        "paging": false,
        "ordering": [0, 'asc'],
        "bInfo": false,
      });
    });
  </script>

@endsection
