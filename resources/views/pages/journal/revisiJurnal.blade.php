@extends('layouts.layoutDashboard')

@section('title', 'Jurnal')

@section('link')

@endsection

@section('style')

  <style media="screen">
  #table_id .btn{
    font-size: 12px;
    margin-top: 6px;
  }

  .card.card-custom > .card-body{
    padding: 2rem 0;
  }

  #kt_tab_pane_5_1{
    padding: 2rem 2.25rem;
  }

  #kt_tab_pane_5_2 .container-fluid{
    padding: 0 0;
  }

  .card-header-value{
    text-align: center;
    background: #3569fe !important;
  }

  .card-value h4{
    color: white !important;
  }

  .card-value .card-body{
    text-align: center;
  }

  .card.card-custom > .card-header-value .card-title{
    margin: auto;
  }

  .card-realisasi .col-3{
    text-align: right;
  }

  .card-realisasi h5{
    font-weight: normal;
    font-size: 14px;
  }

  .card-realisasi b{
    font-size: 16px;
  }

  @media only screen and (max-width: 600px) {
    .card-realisasi h5{
      font-size: 8px !important;
    }

    .card-realisasi b{
      font-size: 10px;
    }
  }
</style>

@endsection

@section('navigation')

@endsection

@section('content')



  <!--begin::Card Row-->

  <div class="row mt-4">
    <div class="col-12 col-md-4 mt-4">
      <!--begin::Card-->
      <div class="card card-value card-custom card-stretch">
        <div class="card-header card-header-value">
          <div class="card-title">
            <h4 class="card-label">Tahun Sekarang</h4>
          </div>
        </div>
        <div class="card-body">
          <h3>

          </h3>
        </div>
      </div>
      <!--end::Card-->
    </div>

    <div class="col-12 col-md-4 mt-4">
      <!--begin::Card-->
      <div class="card card-value card-custom card-stretch">
        <div class="card-header card-header-value">
          <div class="card-title">
            <h4 class="card-label">Tahun Lalu</h4>
          </div>
        </div>
        <div class="card-body">
          <h3>
            
          </h3>
        </div>
      </div>
      <!--end::Card-->
    </div>

    <div class="col-12 col-md-4 mt-4">
      <!--begin::Card-->
      <div class="card card-value card-custom card-stretch">
        <div class="card-header card-header-value">
          <div class="card-title">
            <h4 class="card-label">Total</h4>
          </div>
        </div>
        <div class="card-body">
          <h3>
          
          </h3>
        </div>
      </div>
      <!--end::Card-->
    </div>
  </div>

  <!--end::CardRow-->


  <!--begin::CardTable-->

  <div class="card card-custom mt-8">
    <div class="card-header py-6">
      <div class="card-toolbar">
        <ul class="nav nav-light-primary nav-bold nav-pills">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_5_1">
              <span class="nav-text">Tabel Data Jurnal</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5_2">
              <span class="nav-text">Data Realisasi Rekening</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-toolbar">
        <!--begin::Button-->
        <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="dateButton">
          <i class="fa fa-calendar"></i>Tanggal
        </a>
        <a href="#" class="btn btn-primary font-weight-bolder mr-2" id="filterButton">
          <i class="fa fa-filter"></i>Filter
        </a>
 
        <!--end::Button-->
      </div>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="kt_tab_pane_5_1" role="tabpanel" aria-labelledby="kt_tab_pane_5_1">
          <table id="table_id" width="100%" class="display compact d-lg-table table-responsive">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Uraian</th>
                <th>Ket. Tahun Lalu</th>
                <th>No Akun</th>
                <th>Akun</th>
                <th>Tahun Lalu</th>
                <th>Tahun Berjalan</th>
                <th>SKPD</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dataRevisi as $item)
                <tr>
                  <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                  <td class="{{ $item->mark == 0 ? '' : 'bg-warning text-black' }}">{{ $item->evidance }}</td>
                  <td style="text-align: left !important;">{{ $item->description }}</td>
                  <td>{{ $item->last_year_description ?? '-' }}</td>
                  <td class="text-left">{{ $item->account->number }}</td>
                  <td>{{ $item->account->name }}</td>
                  <td style="text-align: right !important;">
                    @if($item->last_year == 1)
                      {{ number_format($item->value, 2, ",", ".") }}
                    @else
                      -
                    @endif
                  </td>
                  <td style="text-align: right !important;">
                    @if($item->last_year == 0)
                      {{ number_format($item->value, 2, ",", ".") }}
                    @else
                      -
                    @endif
                  </td>
                  <td>{{ $item->skpd->name }}</td>

                 
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Uraian</th>
                <th>Ket. Tahun Lalu</th>
                <th>No Akun</th>
                <th>Akun</th>
                <th>Tahun Lalu</th>
                <th>Tahun Berjalan</th>
                <th>SKPD</th>

                @if (Auth::user()->role->journals_edit == 1 || Auth::user()->role->journals_delete == 1 || Auth::user()->role->journals_mark == 1)
                  <th>Aksi</th>
                @endif
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_5_2" role="tabpanel" aria-labelledby="kt_tab_pane_5_2">
          <div class="container-fluid">

            <div class="row card-realisasi mb-3">
              <div class="col-md-2 col-3">
                <h5 class="text-muted mr-2" ></h5>
              </div>
              <div class="col-md-5 col-4">
                <h5>
                  <b>
                    Akun
                  </b>
                </h5>
              </div>
              <div class="col-md-5 col-5">
                <h5>
                  <b>
                    Nilai
                  </b>
                </h5>
              </div>
            </div>

           
            <hr>
            <div class="row card-realisasi mt-8" style="margin-right: 100px;">
              <div class="col-md-2 col-3">
                <h5 class="text-muted mr-2" ></h5>
              </div>
              <div class="col-md-5 col-4">
                <h5>
                  <b>
                    Total

                    <font style="position:absolute; right: 0;">:</font>
                  </b>
                </h5>
              </div>
              <div class="col-md-5 col-5">

                <h5 style="text-align: right;">
                  <b>
               
                  </b>
                </h5>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!--end::CardTable-->

@endsection

@section('modal')

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){
        $('.radio-value').on('click', function(){
            var val = $(this).val();
            console.log(val);
            if(val == 'iya')
            {
                $('.input-value').addClass('d-none');
                $('.input-currency').val(null);
                $('.input-value-sen').removeClass('d-none');
                
            } else {
                $('.input-value-sen').addClass('d-none');
                $('.masking2').val(null);
                $('.input-value').removeClass('d-none');
            }
        });
        
        $('.edit-radio-value').on('click', function(){
            var val = $(this).val();
            console.log(val);
            if(val == 'iya')
            {
                $('.edit-input-value').addClass('d-none');
                $('.input-currency').val(null);
                $('.edit-input-value-sen').removeClass('d-none');
                
            } else {
                $('.edit-input-value-sen').addClass('d-none');
                $('.masking2').val(null);
                $('.edit-input-value').removeClass('d-none');
            }
        });
        
        $('#masking1').mask('#.##0', {reverse: true});
        $('.masking2').mask('#.##0,00', {reverse: true});
        $('#masking3').mask('#,##0.00', {reverse: true});
    });

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
            month: '0'
          },
        });

        $('#kt_datepicker_day').datepicker({
          rtl: KTUtil.isRTL(),
          format: 'yyyy-mm-dd',
          orientation: "bottom left",
          templates: arrows,
          startDate: '{{ Auth::user()->year }} 01 01',
          endDate: '{{ Auth::user()->year }} 12 31',
        });

        $('#kt_datepicker_day_2').datepicker({
          rtl: KTUtil.isRTL(),
          format: 'yyyy-mm-dd',
          orientation: "bottom left",
          templates: arrows,
          startDate: '{{ Auth::user()->year }} 01 01',
          endDate: '{{ Auth::user()->year }} 12 31',
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

    document.getElementById('checkFilterType').addEventListener('change', function() {
      if (this.value == "Harian") {
        document.getElementById("formMonth").hidden = true;
        document.getElementById("formDay").hidden = false;
        document.getElementById("kt_datepicker_month").value = '';
        document.getElementById("kt_datepicker_day").name = 'date';
        document.getElementById("kt_datepicker_month").name = '';
      } else if (this.value == "Bulanan") {
        document.getElementById("formMonth").hidden = false;
        document.getElementById("formDay").hidden = true;
        document.getElementById("kt_datepicker_day").value = '';
        document.getElementById("kt_datepicker_day").name = '';
        document.getElementById("kt_datepicker_month").name = 'date';
      } else {
      }
    });

  </script>

  <script type="text/javascript">
    $(document).on("click", "#dateButton", function ()
    {
      $("#dateModal").modal();
    });

    $(document).on("click", "#filterButton", function ()
    {
      $("#filterModal").modal();
    });

    $(document).on("click", "#createButton", function ()
    {
      $("#createModal").modal();
    });

    $(document).on("change", ".lastYear", function ()
    {
      last_year = $(this).val();
    //   console.log(last_year);
      if(last_year == 0)
      {
        $(".lastYearDescription").hide();
      } else {
        $(".lastYearDescription").show();
      }
    });
    
    $(document).on("change", ".editLastYear", function ()
    {
      last_year = $(this).val();
      console.log(last_year);
      if(last_year == 0)
      {
        $(".editLastYearDescription").hide();
      } else {
        $(".editLastYearDescription").show();
      }
    });
    
            
    function formatRupiah(angka, prefix){
    	var number_string = angka.replace(/[^,\d]/g, '').toString(),
    	split   		= number_string.split(','),
    	sisa     		= split[0].length % 3,
    	rupiah     		= split[0].substr(0, sisa),
    	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
     
    	// tambahkan titik jika yang di input sudah menjadi angka ribuan
    	if(ribuan){
    		separator = sisa ? '.' : '';
    		rupiah += separator + ribuan.join('.');
    	}
     
    	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on("click", "#editButton", function()
    {
      let id = $(this).val();
      $.ajax(
      {
        method: "GET",
        url: "{{ route('journal.journal.index') }}/" + id + "/edit"
      }).done(function (response)
      {
        console.log(response);
        $("#skpdId option[value=\"" + response.skpd_id + "\"]").attr("selected", true);
        $("#date").val(response.date);
        $("#description").text(response.description);
        $(".editLastYear option[value=\"" + response.last_year + "\"]").attr("selected", true);
        $(".editLastYearDescriptionValue").text(response.last_year_description);
        $("#evidance").val(response.evidance);
        $("#value").val(formatRupiah(response.value, ''));
        getSkpdAccount(response.skpd_id, response.account_id);
        if(response.last_year == 0)
        {
          $(".editLastYearDescription").hide();
        } else {
          $(".editLastYearDescription").show();
        }
        $("#editForm").attr("action", "{{ route('journal.journal.index') }}/" + id)
        $("#editModal").modal();
      })
    });

    $(document).on("click", "#deleteButton", function()
    {
      let id = $(this).val();
      $("#deleteForm").attr("action", "{{ route('journal.journal.index') }}/" + id)
      $("#deleteModal").modal();
    });

    $(document).ready( function () {
      $('#table_id').DataTable();
    });
  </script>

  <script>
    $(".input-number").on("keypress", function(evt)
    {
      var charCode = (evt.which) ? evt.which : evt.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
      return true;
    });

    function inputmaskCurrencyInit() {
      Inputmask.extendAliases({
        'numeric': {
          "prefix":"",
          "digits":0,
          "rightAlign": false,
          "digitsOptional":false,
          "decimalProtect":true,
          "groupSeparator":".",
          "radixPoint":",",
          "radixFocus":true,
          "autoGroup":true,
          "autoUnmask":true,
          "removeMaskOnSubmit":true
        }
      });
      Inputmask.extendAliases({
        'IDR': {
          alias: "numeric", //it inherits all the properties of numeric
        }
      });
      $(".input-currency").inputmask("IDR");
    }
    inputmaskCurrencyInit();

    $(document).on("change", ".skpd-select-input", function()
    {
      skpd_id = $(this).val();
      if (skpd_id != 0)
      {
        getSkpdAccount(skpd_id, 0);
      } else
      {
        $(".skpd-account-select-input").html("<option value=\"0\">Pilih skpd terlebih dahulu</option>");
        $(".skpd-account-select-input").attr("disabled", true);
      }
    });

    function getSkpdAccount(skpd_id, account_id)
    {
      $(".skpd-account-select-input").html("<option value=\"0\">Loading...</option>")
      $(".skpd-account-select-input").attr("disabled", true);
      $.ajax({
        method: "POST",
        url : "/journal/journal/get-skpd-akun",
        data : {
          skpd_id : skpd_id,
          _token : "{{ csrf_token() }}"
        }
      }).done(function(response)
      {
        console.log(response.skpdAccounts);
        let skpdAccounts = response.skpdAccounts;
        $(".skpd-account-select-input").empty();
        $(".skpd-account-select-input").append("<option value=\"0\">Pilih salah satu</option>");
        skpdAccounts.forEach(skpdAccount => {
          skpdAccountName = skpdAccount.account.number + "-" + skpdAccount.account.name;
          $(".skpd-account-select-input").append("<option value=\"" + skpdAccount.account_id + "\">" + skpdAccountName + "</option>");
        });

        if (account_id != 0) {
          $(".skpd-account-select-input option[value=\"" + account_id + "\"]").attr("selected", true);
        }
        $(".skpd-account-select-input").attr("disabled", false)
      });
    }
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
  </script>

  <script>
    var menu_link_1 = document.getElementById("kt_header_menu_4");
    menu_link_1.classList.add("active");

    var menu_link_2 = document.getElementById("kt_header_menu_mobile_4");
    menu_link_2.classList.add("active");

    var menu_link_3 = document.getElementById("kt_header_tab_4");
    menu_link_3.classList.add("active");
    menu_link_3.classList.add("show");

    var menu_link_4 = document.getElementById("menu_journal");
    menu_link_4.classList.add("menu-item-active");
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      var scrollpos = localStorage.getItem('scrollpos');
      if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
      localStorage.setItem('scrollpos', window.scrollY);
    };
  </script>

@endsection
