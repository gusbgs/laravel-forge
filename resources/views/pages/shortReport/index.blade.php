@extends('layouts.layoutDashboard')

@section('title', 'Laporan Singkat')

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
          Laporan Singkat
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item text-muted">
              <a href="#" class="text-muted">Dashboard</a>
            </li>
            <li class="breadcrumb-item text-muted active">
              <a href="#" class="text-muted">Laporan Singkat</a>
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
                <th>Kode Rekening</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1; @endphp
            @foreach($short_report as $item)
                <tr>
                    <td>{{ $item->number }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-xs" value="{{ $item->id }}" id="deleteButton" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th>Kode Rekening</th>
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
              <h5 class="modal-title text-white">Tambah Laporan Singkat</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{ route('dashboard.shortReport.create') }}" method="post">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="">Kode Rekening</label>
                  <input class="form-control" name="number" required>
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
              <h5 class="modal-title text-white">Edit Laporan Singkat</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="editForm" method="post">
              <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="">Kode Rekening</label>
                  <input class="form-control" name="number" id="editKodeRekening" required>
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

      <script type="text/javascript">
        $(document).on("click", "#createButton", function ()
        {
          $("#createModal").modal();
        });

        $(document).on("click", "#editButton", function()
        {
          let id = $(this).val();
          $.ajax(
          {
            method: "GET",
            url: "/dashboard/shortReport/edit/" + id
          }).done(function (response)
          {
            console.log(response);
            $("#editKodeRekening").val(response.number);
            $("#editForm").attr("action", "/dashboard/shortReport/update/" + id)
            $("#editModal").modal();
          })
        });

        $(document).on("click", "#deleteButton", function()
        {
          let id = $(this).val();
          $("#deleteForm").attr("action", "/dashboard/shortReport/delete/" + id)
          $("#deleteModal").modal();
        });

        $(document).ready( function () {
          $('#table_id').DataTable();
        } );
      </script>

      <script>
        var menu_link_1 = document.getElementById("kt_header_menu_1");
        menu_link_1.classList.add("active");

        var menu_link_2 = document.getElementById("kt_header_menu_mobile_1");
        menu_link_2.classList.add("active");

        var menu_link_3 = document.getElementById("kt_header_tab_1");
        menu_link_3.classList.add("active");
        menu_link_3.classList.add("show");

        var menu_link_4 = document.getElementById("menu_short_report");
        menu_link_4.classList.add("menu-item-active");
      </script>

    @endsection
