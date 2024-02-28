@extends('layouts.layoutDashboard')

@section('title', 'Daftar SKPD')

@section('link')

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
          Daftar SKPD
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item text-muted">
              <a href="#" class="text-muted">Referensi</a>
            </li>
            <li class="breadcrumb-item text-muted active">
              <a href="#" class="text-muted">Daftar SKPD</a>
            </li>
          </ul>
        </h3>
      </div>
      @if (Auth::user()->role->skpd_create == 1)
        <div class="card-toolbar">
          <!--begin::Button-->
          <a href="#" class="btn btn-success font-weight-bolder" id="createButton">
            <i class="fa fa-plus"></i>Tambah
          </a>
          <!--end::Button-->
        </div>
      @endif
    </div>
    <div class="card-body">
      <table id="table_id" class="display">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            @if (Auth::user()->role->skpd_account == 1 || Auth::user()->role->skpd_edit == 1 || Auth::user()->role->skpd_delete == 1)
              <th style="width: 20%;">Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @php $no = 1; @endphp
          @foreach($skpd as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->name }}</td>
              @if (Auth::user()->role->skpd_account == 1 || Auth::user()->role->skpd_edit == 1 || Auth::user()->role->skpd_delete == 1)
                <td>
                  @if (Auth::user()->role->skpd_account == 1)
                    <a href="/referensi/skpd-akun/{{ $item->id }}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="Akun SKPD"><i class="fa fa-list"></i></a>
                  @endif
                  @if (Auth::user()->role->skpd_edit == 1)
                    <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                  @endif
                  @if (Auth::user()->role->skpd_delete == 1)
                    <button type="button" class="btn btn-danger btn-xs" value="{{ $item->id }}" id="deleteButton" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>
                  @endif
                </td>
              @endif
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Nama</th>
            @if (Auth::user()->role->skpd_account == 1 || Auth::user()->role->skpd_edit == 1 || Auth::user()->role->skpd_delete == 1)
              <th style="width: 20%;">Aksi</th>
            @endif
          </tr>
        </thead>
      </table>
      <!--end: Datatable-->
    </div>
    <!--end::Card-->
  </div>

@endsection

@section('modal')

  <!--begin::Modal Create-->
  <div class="modal fade" id="createModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success white">
          <h5 class="modal-title text-white">Tambah SKPD</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="{{ route('referensi.skpd.store') }}" method="post">
          <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="">Nama SKPD</label>
              <input type="text" name="name" placeholder="Masukkan nama skpd" class="form-control" required>
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
          <h5 class="modal-title text-white">Edit SKPD</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="" id="editForm" method="post">
          <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="">Nama SKPD</label>
              <input type="text" name="name" placeholder="Masukkan nama skpd" class="form-control" id="nameSkpd" required>
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
        url: "{{ route('referensi.skpd.index') }}/" + id + "/edit"
      }).done(function (response)
      {
        console.log(response);
        $("#nameSkpd").val(response.name);
        $("#editForm").attr("action", "{{ route('referensi.skpd.index') }}/" + id)
        $("#editModal").modal();
      })
    });

    $(document).on("click", "#deleteButton", function()
    {
      let id = $(this).val();
      $("#deleteForm").attr("action", "{{ route('referensi.skpd.index') }}/" + id)
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
