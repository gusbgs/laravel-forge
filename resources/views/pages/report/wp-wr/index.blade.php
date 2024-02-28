@extends('layouts.layoutDashboard')

@section('title', 'Wajib Pajak/Wajib Retribusi')

@section('link')

@endsection

@section('style')
    <link rel="stylesheet" href="/assets/dropDown/dropDown/style.css">

  <style media="screen">

  .letter .col-8{
    text-align: center;
    line-height: 0.5;
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

  #table_id th, td{
    font-size: 12px !important;
    border: solid 1px black;
  }

  #table_id .bg-primary th{
    color: white !important;
  }

  input:invalid {
    box-shadow: none;
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
                <i class="fa fa-quran" style="color:#3699ff; font-size:28px"></i>
                <!--end::Svg Icon-->
              </span>
            </span>
            <h3 class="card-label">
              Wajib Pajak/Wajib Retribusi
              <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                <li class="breadcrumb-item text-muted">
                  <a href="#" class="text-muted">Laporan</a>
                </li>
                <li class="breadcrumb-item text-muted active">
                  <a href="#" class="text-muted">Wajib Pajak/Wajib Retribusi</a>
                </li>
              </ul>
            </h3>
          </div>
          <div class="card-toolbar">
            <!--begin::Button-->
            @if ($date == true || $tahun == true)
            <a href="/wp-wr/export?account={{ $account }}&date={{ $date }}&tahun={{ $tahun }}" class="btn btn-success font-weight-bolder mr-2 mb-2" id="exportButton">
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

          <div class="letter mt-2 mb-8">
            <div class="row">
              <div class="col-2">
                <img src="/images/logo-tabalong.jpeg" alt="Logo">
              </div>
              <div class="col-8">
                <b>
                  <h5> PEMERINTAH KABUPATEN TABALONG </h5> <br>
                  <h4>LAPORAN REALISASI PENDAPATAN DAERAH </h4> <br>
                  <!--<small> Wajib Pajak/Wajib Retribusi </small>-->
                </b>
              </div>
            </div>
          </div>

          <table id="table_id" width="100%" class="display compact d-lg-table table-responsive">
            <thead>
              <tr>
                <th colspan="2">SKPD</th>
                <th colspan="4">
                  @if($skpd_account != null)
                    {{ $skpd_account->skpd->name }}
                  @else
                    -
                  @endif
                </th>
              </tr>

              <tr>
                <th colspan="2">Kode Akun</th>
                <th colspan="2">
                  @if($skpd_account != null)
                    {{ $skpd_account->account->number }}
                  @else
                    -
                  @endif
                </th>
                @php
                  $total = $last_year + $this_year;
                @endphp
                <th colspan="2" style="text-align: center;"> {{ number_format($total, 2, ",", ".") ?? '0' }} </th>
              </tr>

              <tr>
                <th colspan="2">Nama Akun</th>
                <th colspan="2">
                  @if($skpd_account != null)
                    {{ $skpd_account->account->name }}
                  @else
                    -
                  @endif
                </th>
                <th colspan="1" style="text-align: center;"> {{ number_format($last_year, 2, ",", ".") ?? '0' }} </th>
                <th colspan="1" style="text-align: center;"> {{ number_format($this_year, 2, ",", ".") ?? '0' }} </th>
              </tr>

              <tr>
                <th colspan="2">Bulan</th>
                <th colspan="4">
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
                <th>Bukti</th>
                <th>Uraian</th>
                <th>Tahun Lalu</th>
                <th>Tahun Berjalan</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @foreach($wp_wr as $item)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                  <td>{{ $item->evidance }}</td>
                  <td style="text-align: left;">{{ $item->description }}</td>
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
          <b>HJ. HAMIDA MUNAWARAH, S.T., M.T</b><br>
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

@section('modal')

  <!--begin::Modal Filter-->
  <div class="modal fade" id="filterModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <h5 class="modal-title text-white">Filter data</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="" method="get">
          @csrf
          <div class="modal-body">

            <div class="form-group">
              <label for="">Akun</label>
              <div class="comboTreeWrapper">
                <div class="comboTreeInputWrapper">
                  <input class="comboTreeInputBox" type="text" name="account" id="justAnotherInputBoxEdit" placeholder="Unknown" autocomplete="off" required/>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="">Tipe Filter</label>
              <select class="form-control" id="checkFilterType" autocomplete="off">
                <option>Tahun</option>
                <option>Bulanan</option>
              </select>
            </div>

            <div class="form-group filterDateMonth d-none">
              <label for="">Bulan</label>
              <input type="text" name="date" id="kt_datepicker_month" class="form-control" readonly placeholder="Pilih Tanggal" autocomplete="off" required/>
            </div>
            
            <div class="form-group filterDateYear">
              <label for="">Tahun</label>
              <div class="input-group" id="kt_datetimepicker_1" data-target-input="nearest" data-toggle="datetimepicker">
                <input type="text" name="tahun" class="form-control datetimepicker-input" value="{{ Auth::user()->year }}" placeholder="Tahun" name="year" data-target="#kt_datetimepicker_1" required/>
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
        <form action="{{ route('report.wp-wr.print') }}" method="get" target="_blank">
          @csrf
          <div class="modal-body">

            <input type="hidden" name="account" value="{{ $account }}"/>
            <input type="hidden" name="date" value="{{ $date }}"/>
            <input type="hidden" name="tahun" value="{{ $tahun }}"/>

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
  <script src="/assets/dropDown/dropDown/comboTreePlugin.js"  type="text/javascript"></script>

  @include('/accountData/index2')

  <script type="text/javascript">
      var comboTree2;

      jQuery(document).ready(function($) {

        comboTree2 = $('#justAnotherInputBoxEdit').comboTree({
          source : newData,
          isMultiple: false,
          collapse: true,
        });
      });
  </script>

  <script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable({
      "pageLength": 1000,
      "bLengthChange": false,
      "bFilter": true,
      "paging": false,
      "ordering": [0],
      "bInfo": false,
    });
  });
  </script>

  <script type="text/javascript">
    $('#kt_datetimepicker_1').datetimepicker({
        format: "YYYY",
        viewMode: "years"
    });
      $(document).on("click", "#filterButton", function ()
      {
        $("#filterModal").modal();
        if("{{ $account }}" != null)
        {
            $("#justAnotherInputBoxEdit").val("{{ $account }}");
        }
      });
      
        document.getElementById('checkFilterType').addEventListener('change', function() {
          if (this.value == "Tahun") {
            $('.filterDateMonth').addClass('d-none');
            $('.filterDateYear').removeClass('d-none');
          } else if (this.value == "Bulanan") {
            $('.filterDateMonth').removeClass('d-none');
            $('.filterDateYear').addClass('d-none');
          } else {
          }
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
        $('#kt_datepicker_month').datepicker({
          rtl: KTUtil.isRTL(),
          format: 'yyyy-mm',
          viewMode: "months",
          minViewMode: "months",
          orientation: "bottom left",
          templates: arrows,
          startDate: '{{ Auth::user()->year }} 01',
          endDate: '{{ Auth::user()->year }} 12',
          defaultViewDate: {
            year: '{{ Auth::user()->year }}',
          },
        });
      }

      return {
        // public functions
        init: function() {
          datepicker();
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

    var menu_link_4 = document.getElementById("menu_wp_wr");
    menu_link_4.classList.add("menu-item-active");
  </script>

@endsection
