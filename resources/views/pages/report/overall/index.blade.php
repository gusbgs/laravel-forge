@extends('layouts.layoutDashboard')

@section('title', 'Laporan Keseluruhan')

@section('link')

@endsection

@section('style')

  <style>

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

  #table_id_1 th, #table_id_1 td{
    border: solid 1px black;
  }

  #table_id_2 th, #table_id_2 td{
    border: solid 1px black;
  }

  #table_id_3 th, #table_id_3 td{
    border: solid 1px black;
  }

  #table_id_4 th, #table_id_4 td{
    border: solid 1px black;
  }

  @media only screen and (max-width: 600px) {
    .summary-table .letter img{
      height: 40px;
    }
  }

</style>

@endsection

@section('navigation')

@endsection

@section('content')

  {{-- ///////////////////////////////Header////////////////////////////////// --}}


  <!--begin::Content-->
  <div class="d-flex flex-row mb-6">
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
              Laporan Keseluruhan
              <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                <li class="breadcrumb-item text-muted">
                  <a href="#" class="text-muted">Laporan</a>
                </li>
                <li class="breadcrumb-item text-muted active">
                  <a href="#" class="text-muted">Keseluruhan</a>
                </li>
              </ul>
            </h3>
          </div>
          <div class="card-toolbar">
            <!--begin::Button-->
            @if ($start_date_income == true && Auth::user()->role->reports_overall_print == 1)
              <a href="/report/overall/export?change_summary_all={{ $change_summary_all }}&start_date_summary={{ $start_date_summary }}&end_date_summary={{ $end_date_summary }}&change_summary_red={{ $change_summary_red }}&start_date_summary_red={{ $start_date_summary_red }}&end_date_summary_red={{ $end_date_summary_red }}&change_summary_green={{ $change_summary_green }}&start_date_summary_green={{ $start_date_summary_green }}&end_date_summary_green={{ $end_date_summary_green }}&change_income={{ $change_income }}&start_date_income={{ $start_date_income }}&end_date_income={{ $end_date_income }}" class="btn btn-success font-weight-bolder mr-2 mb-2" id="excelButton">
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
      </div>
    </div>
  </div>
  <!--end::Content-->


  {{-- ///////////////////////////////Tabel Ringkasan dan PAD////////////////////////////////// --}}


  <!--begin::Content-->
  <div class="d-flex flex-row summary-table mb-6">
    <div class="flex-row-fluid">
      <!--begin::Card-->

      <div class="card card-custom" data-card="true">
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
            </h3>
          </div>
          <div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Toggle Card">
				<i class="ki ki-arrow-down icon-nm"></i>
			</a>
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

                  LAPORAN BULANAN PENDAPATAN ASLI DAERAH, DANA PERIMBANGAN DAN <br>
                  LAIN-LAIN PENDAPATAN YANG SAH KABUPATEN TABALONG <br><br>
                  WAKTU: {{ $start_date_summary }} S/D {{$end_date_summary}} {{ Auth::user()->year }}
                </b>
              </div>
            </div>
          </div>

          <table width="100%" id="table_id_1" class="display compact table-responsive table_id">
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

          <div class="letter-footer mt-12">
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
                Tempat, Tanggal <br>
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


  {{-- ///////////////////////////////Tabel Laporan Bulanan (Merah)////////////////////////////////// --}}


  <!--begin::Content-->
  <div class="d-flex flex-row summary-table mb-6">
    <div class="flex-row-fluid">
      <!--begin::Card-->

      <div class="card card-custom" data-card="true">
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
              Laporan Bulanan (Merah)
            </h3>
          </div>
          <div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Toggle Card">
				<i class="ki ki-arrow-down icon-nm"></i>
			</a>
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
                  LAPORAN BULANAN <br>
                  PENDAPATAN DAERAH KABUPATEN TABALONG <br>
                  TAHUN ANGGARAN {{ Auth::user()->year }} <br><br>
                  WAKTU: {{ $start_date_summary_red }} S/D {{$end_date_summary_red}} {{ Auth::user()->year }}
                </b>
              </div>
            </div>
          </div>

          <table width="100%" id="table_id_2" class="display compact d-lg-table table-responsive table_id">
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

          <div class="letter-footer mt-12">
            <div class="row">
              <div class="col-6">
                MENGETAHUI: <br><br>
                AN. BUPATI TABALONG : <br>
                SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                <b>HJ. HAMIDA MUNAWARAH, S.T., M.T</b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19670518 199803 2004 </small>
              </div>
              <div class="col-6">
                <br><br>
                Tempat, Tanggal <br>
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


  <!--begin::Content-->
  <div class="d-flex flex-row summary-table mb-6">
    <div class="flex-row-fluid">
      <!--begin::Card-->

      <div class="card card-custom" data-card="true">
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
              Rekapitulasi Laporan Bulanan (Hijau) <br>
            </h3>
          </div>
          <div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Toggle Card">
				<i class="ki ki-arrow-down icon-nm"></i>
			</a>
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
                  REKAPITULASI LAPORAN BULANAN<br>
                  PENDAPATAN DAERAH KABUPATEN TABALONG<br>
                  TAHUN ANGGARAN {{ Auth::user()->year }}<br><br>
                  WAKTU: {{ $start_date_summary_green }} S/D {{$end_date_summary_green}} {{ Auth::user()->year }}
                </b>
              </div>
            </div>
          </div>

          <table width="100%" id="table_id_3" class="display compact d-lg-table table-responsive table_id">
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

          <div class="letter-footer mt-12">
            <div class="row">
              <div class="col-6">
                MENGETAHUI: <br><br>
                AN. BUPATI TABALONG : <br>
                SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                 <b>HJ. HAMIDA MUNAWARAH, S.T., M.T</b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19670518 199803 2004 </small>
              </div>
              <div class="col-6">
                <br><br>
                Tempat, Tanggal <br>
                KEPALA BADAN PENDAPATAN DAERAH KABUPATEN TABALONG <br><br><br><br>
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

  <!--begin::Content-->
      @foreach($income as $item_1)
        <div class="d-flex flex-row income-table mb-6">
            <div class="flex-row-fluid">
              <!--begin::Card-->

              <div class="card card-custom" data-card="true">
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
                      Pendapatan ({{ $item_1[0] }})
                    </h3>
                  </div>
                  <div class="card-toolbar">
        			<a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Toggle Card">
        				<i class="ki ki-arrow-down icon-nm"></i>
        			</a>
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
                        : {{ $start_date_income }} S/D {{$end_date_income}}  {{ Auth::user()->year }}
                      </div>
                    </div>
                  </div>

                  <table width="100%" id="table_id_4" class="table_id display compact d-lg-table table-responsive">
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
                          $total_realisasi_until_this_month = $item['realisasi_until_last_month'] + $item['realisasi_this_month'];
                          if($total_realisasi_until_this_month != 0 && $item['target'] != 0)
                          {
                            $persen = $total_realisasi_until_this_month / $item['target']  * 100;
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
                          <td style="text-align: right;">{{ number_format($total_realisasi_until_this_month, 2, ",", ".") ?? '0' }}</td>
                          <td style="text-align: center;">{{ number_format($persen, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>

                  <div class="letter-footer mt-6">
                    <div class="row">
                      <div class="col-8">
                      </div>
                      <div class="col-4">
                        <br><br>
                        Kepala Bidang Pengendalian  <br><br><br><br>
                        <b> IRWANSYAH BUDIMAN, SE, MM </b><br>
                        <small> NIP. 19840414 200804 1 001  </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end::Body-->
            <!--end::Form-->
          </div>
      @endforeach
  <!--end::Content-->

@endsection

@section('modal')

  <!--begin::Modal Filter-->
  <div class="modal fade" id="filterModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <h5 class="modal-title text-white">Filter data</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="{{ route('report.overall') }}" method="get">
          @csrf
          <div class="modal-body">

            <div>
              {{-- Ringkasan dan PAD --}}
              <div class="form-group">
                <h5>Ringkasan dan PAD</h5>
              </div>

              <div class="form-group">
                <label for="">Perubahan</label>
                <select name="change_summary_all" class="form-control" required>
                  @if($change_summary_all != null)
                    @if($change_summary_all == 'sebelum_perubahan')
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
                  <label for="">Tanggal Mulai</label>
                  <input type="text" name="start_date_summary" value="{{ $start_date_summary }}" id="kt_datepicker_start" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">Tanggal Akhir</label>
                  <input type="text" name="end_date_summary" value="{{ $end_date_summary }}" id="kt_datepicker_end" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>

              <hr class="mt-10 mb-10">
            </div>

            <div>
              {{-- Laporan Bulanan (Merah) --}}
              <div class="form-group">
                <h5>Laporan Bulanan (Merah)</h5>
              </div>

              <div class="form-group">
                <label for="">Perubahan</label>
                <select name="change_summary_red" class="form-control" required>
                  @if($change_summary_red != null)
                    @if($change_summary_red == 'sebelum_perubahan')
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
                  <label for="">Tanggal Mulai</label>
                  <input type="text" name="start_date_summary_red" value="{{ $start_date_summary_red }}" id="kt_datepicker_start_2" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">Tanggal Akhir</label>
                  <input type="text" name="end_date_summary_red" value="{{ $end_date_summary_red }}" id="kt_datepicker_end_2" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>

              <hr class="mt-10 mb-10">
            </div>

            <div>
              {{-- Rekapitulasi Laporan Bulanan (Hijau) --}}
              <div class="form-group">
                <h5>Rekapitulasi Laporan Bulanan (Hijau)</h5>
              </div>

              <div class="form-group">
                <label for="">Perubahan</label>
                <select name="change_summary_green" class="form-control" required>
                  @if($change_summary_green != null)
                    @if($change_summary_green == 'sebelum_perubahan')
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
                  <label for="">Tanggal Mulai</label>
                  <input type="text" name="start_date_summary_green" value="{{ $start_date_summary_green }}" id="kt_datepicker_start_3" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">Tanggal Akhir</label>
                  <input type="text" name="end_date_summary_green" value="{{ $end_date_summary_green }}" id="kt_datepicker_end_3" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>

              <hr class="mt-10 mb-10">
            </div>

            <div>
              {{-- Pendapatan --}}
              <div class="form-group">
                <h5>Pendapatan</h5>
              </div>

              <div class="form-group">
                <label for="">Perubahan</label>
                <select name="change_income" class="form-control" required>
                  @if($change_income != null)
                    @if($change_income == 'ya')
                      <option value="ya" hidden>Ya</option>
                    @else
                      <option value="tidak" hidden>Tidak</option>
                    @endif
                  @endif
                  <option value="ya">Ya</option>
                  <option value="tidak">Tidak</option>
                </select>
              </div>

              <div class="form-group">
                  <label for="">Tanggal Mulai</label>
                  <input type="text" name="start_date_income" value="{{ $start_date_income }}" id="kt_datepicker_start_4" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">Tanggal Akhir</label>
                  <input type="text" name="end_date_income" value="{{ $end_date_income }}" id="kt_datepicker_end_4" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
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
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="{{ route('report.overall.print') }}" method="get" target="_blank">
          @csrf
          <div class="modal-body">

            <input type="hidden" name="month_summary_all" value="{{ $month_summary_all }}">
            <input type="hidden" name="month_summary_red" value="{{ $month_summary_red }}">
            <input type="hidden" name="month_summary_green" value="{{ $month_summary_green }}">
            <input type="hidden" name="month_income" value="{{ $month_income }}">

            <input type="hidden" name="change_summary_all" value="{{ $change_summary_all }}">
            <input type="hidden" name="start_date_summary" value="{{ $start_date_summary }}">
            <input type="hidden" name="end_date_summary" value="{{ $end_date_summary }}">
            <input type="hidden" name="change_summary_red" value="{{ $change_summary_red }}">
            <input type="hidden" name="start_date_summary_red" value="{{ $start_date_summary_red }}">
            <input type="hidden" name="end_date_summary_red" value="{{ $end_date_summary_red }}">
            <input type="hidden" name="change_summary_green" value="{{ $change_summary_green }}">
            <input type="hidden" name="start_date_summary_green" value="{{ $start_date_summary_green }}">
            <input type="hidden" name="end_date_summary_green" value="{{ $end_date_summary_green }}">

            <input type="hidden" name="change_income" value="{{ $change_income }}">
            <input type="hidden" name="start_date_income" value="{{ $start_date_income }}">
            <input type="hidden" name="end_date_income" value="{{ $end_date_income }}">

            <div class="form-group">
              <label for="">Tempat/Tanggal</label>
              <input type="text" class="form-control" name="ttgl" placeholder="Masukkan Tempat/Tanggal" maxlength="250">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-outline-primary openPrint">Print</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--end::Modal Print-->

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

  <script type="text/javascript">
    $(document).on("click", "#filterButton", function ()
    {
      $("#filterModal").modal();
    });

    $(document).on("click", "#printButton", function ()
    {
      $("#printModal").modal();
    });
  </script>

  <script type="text/javascript">


    // Class definition

    var KTBootstrapDatepicker = function () {

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
      var datepicker = function () {
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
      var datepickers = function () {
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

      var datepicker2 = function () {
        // minimum setup
        $('#kt_datepicker_start_2').datepicker({
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
      var datepickers2 = function () {
        // minimum setup
        $('#kt_datepicker_end_2').datepicker({
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

      var datepicker4 = function () {
        // minimum setup
        $('#kt_datepicker_start_4').datepicker({
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
      var datepickers4 = function () {
        // minimum setup
        $('#kt_datepicker_end_4').datepicker({
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

      var datepicker3 = function () {
        // minimum setup
        $('#kt_datepicker_start_3').datepicker({
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
      var datepickers3 = function () {
        // minimum setup
        $('#kt_datepicker_end_3').datepicker({
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
          datepicker2();
          datepickers2();
          datepicker3();
          datepickers3();
          datepicker4();
          datepickers4();
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

    var menu_link_4 = document.getElementById("menu_overall");
    menu_link_4.classList.add("menu-item-active");
  </script>

@endsection
