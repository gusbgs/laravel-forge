@extends('layouts.layoutPrint')

@section('title', 'Buku Besar')

@section('link')

@endsection

@section('style')

<style>
    table {
        width: 100% !important;
    }

    td,
    th {
        padding: 14px 0 !important;
    }

    .letter .col-8 {
        text-align: center;
        line-height: 0.5;
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

    .preview-header {
        background: white;
        display: inline-block;
        width: 100%;
    }

    .preview-header b {
        font-size: 20px;
    }

    /* #table_id{
    margin-left: -12px;
  } */

    #table_id th,
    td {
        font-size: 10px !important;
        border: solid 1px black;
    }

    #table_id .bg-primary th {
        color: white !important;
    }

    @media only screen and (max-width: 600px) {
        .letter img {
            height: 40px;
        }
    }

</style>

<style media="print">
    body {
        margin: 0mm 10mm 0mm 10mm;
    }

    td,
    th {
        padding: 14px 0 !important;
    }

    .preview-header {
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

                <div class="letter mt-2 mb-8">
                    <div class="row">
                        <div class="col-2">
                            <img src="/images/logo-tabalong.jpeg" alt="Logo">
                        </div>
                        <div class="col-8">
                            <b>
                                <h5> PEMERINTAH KABUPATEN TABALONG </h5> <br>
                                <h4>LAPORAN REALISASI PENDAPATAN DAERAH </h4> <br>
                                <small> BUKU BESAR </small>
                            </b>
                        </div>
                    </div>
                </div>

                <table id="table_id" width="100%" class="compact d-lg-table table-responsive">
                    <thead>
                        <tr>
                            <th colspan="2">SKPD</th>
                            <th colspan="5">
                                @if($skpd_account != null)
                                {{ $skpd_account->skpd->name }}
                                @else
                                -
                                @endif
                            </th>
                        </tr>

                        <tr>
                            <th colspan="2">Kode Akun</th>
                            <th colspan="1">
                                @if($skpd_account != null)
                                {{ $skpd_account->account->number }}
                                @else
                                -
                                @endif
                            </th>
                            @php
                            $total = $last_year + $this_year;
                            @endphp
                            <th colspan="4" style="text-align: center;"> {{ number_format($total, 2, ",", ".") ?? '0' }} </th>
                        </tr>

                        <tr>
                            <th colspan="2">Nama Akun</th>
                            <th colspan="1">
                                @if($skpd_account != null)
                                {{ $skpd_account->account->name }}
                                @else
                                -
                                @endif
                            </th>
                            <th colspan="2" style="text-align: center;"> {{ number_format($last_year, 2, ",", ".") ?? '0' }} </th>
                            <th colspan="2" style="text-align: center;"> {{ number_format($this_year, 2, ",", ".") ?? '0' }} </th>
                        </tr>

                        <tr>
                            <th colspan="2">Bulan</th>
                            <th colspan="5">
                                @if($month != null)
                                {{ $month }}
                                @else
                                -
                                @endif
                            </th>
                        </tr>

                        <tr class="bg-primary">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Pajak</th>
                            <th>Bukti</th>
                            <th>Uraian</th>
                            <th>Tahun Lalu</th>
                            <th>Tahun Berjalan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($book as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                            <td>{{ $item->account->name }}</td>
                            <td>{{ $item->evidance }}</td>
                            <td style="text-align: left !important;">{{ $item->description }}</td>
                            <td style="text-align: right;">
                                @if($item->last_year == 1)
                                {{ number_format($item->value, 2, ",", ".") ?? '0' }}
                                @else
                                0
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if($item->last_year == 0)
                                {{ number_format($item->value, 2, ",", ".") ?? '0' }}
                                @else
                                0
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <div class="letter-footer mt-12">
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
                KEPALA BADAN PENDAPATAN DAERAH <br>
                KABUPATEN TABALONG, <br><br><br><br>
                <b> Drs. H. NANANG MULKANI, M.Si </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19720306 199203 1 004 </small>
              </div>
            </div>
          </div> --}}
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
    $(document).ready(function() {
        $('#table_id').DataTable({
            "pageLength": 1000
            , "bLengthChange": false
            , "bFilter": false
            , "paging": false
            , "ordering": false
            , "bInfo": false
        , });
    });

</script>

@endsection
