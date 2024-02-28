@extends('layouts.layoutDashboard')

@section('title', 'Daftar Akun SKPD')

@section('link')
  <link rel="stylesheet" href="/assets/dropDown/dropDown/style.css">
@endsection

@section('style')

  <style media="screen">
  #table_id .btn{
    font-size: 12px;
    margin-top: 6px;
  }
  </style>

@endsection

@section('navigation')

@endsection

@section('content')

  <!--begin::Card-->
  <div class="card card-custom mt-5">
    <div class="card-header py-3">
      <div class="card-title mt-5">
        <span class="card-icon mr-5">
          <span class="svg-icon svg-icon-md svg-icon-primary">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
            <i class="fa fa-list" style="color:#3699ff; font-size:28px"></i>
            <!--end::Svg Icon-->
          </span>
        </span>
        <h3 class="card-label">
          Daftar Akun SKPD
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item text-muted">
              <a href="#" class="text-muted">Referensi</a>
            </li>
            <li class="breadcrumb-item text-muted">
              <a href="{{ route('referensi.skpd.index') }}" class="text-muted">Daftar Skpd</a>
            </li>
            <li class="breadcrumb-item text-muted active">
              <a href="#" class="text-muted">{{ $skpd_name }}</a>
            </li>
          </ul>
        </h3>
      </div>
      <div class="card-toolbar">
        <!--begin::Button-->
        <a href="#" class="btn btn-success font-weight-bolder" id="createButton">
          <i class="la la-plus"></i>Tambah</a>
          <!--end::Button-->
        </div>
      </div>
      <div class="card-body">
        <table id="table_id" class="display">
          <thead>
            <tr>
                <th style="display: none;">Order Kode Rekening</th>
                <th>Kode Rekening</th>
                <th>Akun Nama</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1; @endphp
            @foreach($skpd_account as $item)
                <tr>
                    <td style="display:none;">{{ $item->account->order_number ?? '$item->account->number' }}</td>
                    <td>{{ $item->account->number ?? '' }}</td>
                    <td>{{ $item->account->name ?? '' }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-xs" value="{{ $item->id }}" id="deleteButton" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th style="display: none;">Order Kode Rekening</th>
                <th>Kode Rekening</th>
                <th>Akun Nama</th>
              <th style="width: 15%;">Aksi</th>
            </tr>
          </thead>
        </table>
        <!--end: Datatable-->
      </div>
      <!--end::Card-->

      <!--begin::Modal Create-->
      <div class="modal fade" id="createModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-success white">
              <h5 class="modal-title text-white">Tambah Skpd Akun</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{ route('referensi.skpd-akun.store') }}" method="post">
              <div class="modal-body">
                @csrf
                <input type="hidden" name="skpd_id" value="{{ $skpd_id }}">
                <div class="form-group">
                  <label for="">Akun</label>
                  <div class="comboTreeWrapper">
                    <div class="comboTreeInputWrapper">
                      <input class="comboTreeInputBox" type="text" name="account_id" id="justAnotherInputBox" placeholder="Unknown" autocomplete="off"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-outline-success">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--end::Modal Create-->

      <!--begin::Modal Edit-->
      <div class="modal fade" id="editModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <h5 class="modal-title text-white">Edit Skpd Akun</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="editForm" method="post">
              <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="">Akun</label>
                  <div class="comboTreeWrapper">
                    <div class="comboTreeInputWrapper">
                      <input class="comboTreeInputBox" type="text" name="account_id" id="justAnotherInputBoxEdit" placeholder="Unknown" autocomplete="off"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-outline-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--end::Modal Edit-->

      <!--begin::Modal Delete-->
      <div class="modal fade" id="deleteModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h4 class="modal-title text-white">Apa anda yakin ingin menghapus data ini?</h4>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="deleteForm" method="post">
              <div class="modal-footer">
                @csrf
                @method("DELETE")
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-outline-danger">Hapus</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--end::Modal Delete-->
    @endsection

    @section('script')

      <script src="/assets/dropDown/dropDown/comboTreePlugin.js"  type="text/javascript"></script>

      @include('/accountData/index2')

      <script type="text/javascript">
      var comboTree2;

      jQuery(document).ready(function($) {

        comboTree2 = $('#justAnotherInputBox').comboTree({
          source : newData,
          isMultiple: false,
          collapse: true,
        });
      });
      </script>

      <script type="text/javascript">
        $(document).on("click", "#createButton", function ()
        {
          $("#createModal").modal();
        });

        $(document).on("click", "#editButton", function()
        {
          let id = $(this).val();
          var comboTree3;

          jQuery(document).ready(function($) {

            comboTree3 = $('#justAnotherInputBoxEdit').comboTree({
              source : newData,
              isMultiple: false,
              collapse: true,
            });
          });
          document.getElementById("justAnotherInputBoxEdit").empty;
          $.ajax(
          {
            method: "GET",
            url: "/referensi/skpd-akun/" + id + "/edit"
          }).done(function (response)
          {
            console.log(response);
            $("#accountId option[value=\"" + response.account_id + "\"]").attr("selected", true);
            $("#justAnotherInputBoxEdit").val(response.account.number + "-" + response.account.name);
            $("#editForm").attr("action", "/referensi/skpd-akun/" + id)
            $("#editModal").modal();
          })
        });

        $(document).on("click", "#deleteButton", function()
        {
          let id = $(this).val();
          $("#deleteForm").attr("action", "/referensi/skpd-akun/" + id)
          $("#deleteModal").modal();
        });

        $(document).ready( function () {
          $('#table_id').DataTable();
        } );
      </script>

      <script>
        var menu_link_1 = document.getElementById("kt_header_menu_3");
        menu_link_1.classList.add("active");

        var menu_link_2 = document.getElementById("kt_header_menu_mobile_3");
        menu_link_2.classList.add("active");

        var menu_link_3 = document.getElementById("kt_header_tab_3");
        menu_link_3.classList.add("active");
        menu_link_3.classList.add("show");

        var menu_link_4 = document.getElementById("menu_skpd");
        menu_link_4.classList.add("menu-item-active");
      </script>

    @endsection
