@extends('layouts.layoutDashboard')

@section('title', 'Pendapatan')

@section('link')

@endsection

@section('style')

  <style media="screen">

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

  #table_id th, td{
    font-size: 12px !important;
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
              Pendapatan
              <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                <li class="breadcrumb-item text-muted">
                  <a href="#" class="text-muted">Laporan</a>
                </li>
                <li class="breadcrumb-item text-muted active">
                  <a href="#" class="text-muted">Pendapatan</a>
                </li>
              </ul>
            </h3>
          </div>
          <div class="card-toolbar">
            <!--begin::Button-->
            @if ($start_date == true && Auth::user()->role->reports_income_print == 1)
              <a href="/report/income/export?skpd={{ $id_skpd }}&change={{ $change }}&start_date={{ $start_date }}&end_date={{ $end_date }}" class="btn btn-success font-weight-bolder mr-2 mb-2" id="exportButton">
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

          <table id="table_id" width="100%" class="display compact d-lg-table table-responsive">
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

          <div class="letter-footer mt-6">
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

@section('modal')

  <!--begin::Modal Filter-->
  <div class="modal fade" id="filterModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <h5 class="modal-title text-white">Filter data</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="/report/income" method="get">
          @csrf
          <div class="modal-body">

            @if (Auth::user()->skpd_id == null)
              <div class="form-group">
                <label for="">SKPD</label>
                <select name="skpd" class="form-control selectpicker" data-live-search="true" required>
                  @if($skpd == null)
                    <option value="" hidden>Pilih salah satu</option>
                  @endif
                  @foreach($filter_skpd as $item)
                    @if($skpd != null)
                      @if($skpd == $item->name)
                        <option value="{{ $item->id }}" hidden selected>{{ $item->name }}</option>
                      @endif
                    @endif
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>

              @else
                <input type="hidden" name="skpd" value="{{ Auth::user()->skpd_id }}">
            @endif

            <div class="form-group">
              <label for="">Perubahan</label>
              <select name="change" class="form-control" required>
                @if($change != null)
                    @if($change == 'ya')
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
              <input type="text" name="start_date" value="{{ $start_date }}" id="kt_datepicker_start" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="">Tanggal Akhir</label>
              <input type="text" name="end_date" value="{{ $end_date }}" id="kt_datepicker_end" class="form-control" required placeholder="Pilih Tanggal" autocomplete="off">
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
        <form action="{{ route('report.income.print') }}" method="get" target="_blank">
          @csrf
          <div class="modal-body">

            <input type="hidden" name="skpd" value="{{ $id_skpd ?? '' }}">
            <input type="hidden" name="change" value="{{ $change }}">
            <input type="hidden" name="start_date" value="{{ $start_date }}"/>
            <input type="hidden" name="end_date" value="{{ $end_date }}"/>

            <div class="form-group">
              <label for="">Tempat/Tanggal</label>
              <input type="text" class="form-control" name="" placeholder="Masukkan Tempat/Tanggal" maxlength="250">
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

  <script src="/assets/printPage.js" charset="utf-8"></script>

  <script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable({
      "pageLength": 1000,
      "bLengthChange": false,
      "bFilter": true,
      "paging": false,
      "ordering": [0, 'asc'],
      "bInfo": false,
    });
  } );
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

    var menu_link_4 = document.getElementById("menu_income");
    menu_link_4.classList.add("menu-item-active");
  </script>

@endsection
