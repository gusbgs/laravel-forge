@extends('layouts.layoutPrint')

@section('title', 'Pendapatan')

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

.letter-2{
  font-weight: bold;
}

.letter-footer{
  text-align: center;
  font-size: 11px;
}

.letter-footer b{
  text-decoration: underline;
}

.preview-header{
  background: white;
  display: inline-block;
  width: 100%;
}

.preview-header b{
  font-size: 20px;
}

.dataTables_wrapper .dataTable th.sorting_asc{
  color: black !important;
}

/* #table_id{
  margin-left: -12px;
} */

#table_id th, td{
  font-size: 10px !important;
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
                : {{ $skpd }}
              </div>
            </div>

            <div class="row">
              <div class="col-2">
                Waktu
              </div>
              <div class="col-10">
                : {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }}
              </div>
            </div>
          </div>

          <table id="table_id" width="100%" class="compact d-lg-table table-responsive">
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
                @foreach($income as $item)
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
                        <td style="text-align: left !important;">{{ $item['number'] }}</td>
                        <td style="text-align: left !important;">{{ $item['name'] }}</td>
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
                KEPALA BIDANG PENAGIHAN DAN PENGENDALIAN,  <br><br><br><br>
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
