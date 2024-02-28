@extends('layouts.layoutDashboard')

@section('title', 'Daftar Akun')

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
          Daftar Akun
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item text-muted">
              <a href="#" class="text-muted">Referensi</a>
            </li>
            <li class="breadcrumb-item text-muted active">
              <a href="#" class="text-muted">Daftar Akun</a>
            </li>
          </ul>
        </h3>
      </div>
      @if (Auth::user()->role->accounts_create == 1)
        <div class="card-toolbar">
          <!--begin::Button-->
          <a href="#" class="btn btn-success font-weight-bolder" id="createButton">
            <i class="la la-plus"></i>Tambah
          </a>
          <!--end::Button-->
        </div>
      @endif
      </div>
      <div class="card-body">
        <table id="table_id" class="display">
          <thead>
            <tr>
              <th style="display: none;">Akun Order No</th>
              <th>Parent</th>
              <th>Akun Level</th>
              <th>Akun No</th>
              <th>Akun Nama</th>
              <th>Target Sebelum</th>
              <th>Target Sesudah</th>

              @if (Auth::user()->role->accounts_edit == 1 || Auth::user()->role->accounts_delete == 1 || Auth::user()->role->accounts_mark == 1 || Auth::user()->role->accounts_target == 1)
                <th style="width: 23%;">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php $no = 1; @endphp
            @foreach($account as $item)
              @if(count($item->children) > 0)
                <tr>
                  <td style="display: none;"><b>{{ $item->order_number ?? '-' }}</b></td>
                  <td><b>{{ $item->parent->number ?? '-' }}</b></td>
                  <td><b>{{ $item->level }}</b></td>
                  <td class="{{ $item->mark_1 == 0 ? '' : 'bg-success text-white' }}"><b>{{ $item->number }}</b></td>
                  <td class="{{ $item->mark_2 == 0 ? '' : 'bg-danger text-white' }}"><b>{{ $item->name }}</b></td>
                  <td style="text-align: right !important;">
                    @foreach($array_target as $item_1)
                      @if($item_1['id'] == $item->id)
                        <b>{{ number_format($item_1['target_before'], 2, ",", ".") ?? '0' }}</b>
                      @endif
                    @endforeach
                  </td>
                  <td style="text-align: right !important;">
                    @foreach($array_target as $item_1)
                      @if($item_1['id'] == $item->id)
                        <b>{{ number_format($item_1['target_after'], 2, ",", ".") ?? '0' }}</b>
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @if (Auth::user()->role->accounts_mark == 1)
                      <a href="/referensi/akun/{{ $item->id }}/tandai-no" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="Tandai No"><i class="fa fa-pen"></i></a>
                      <a href="/referensi/akun/{{ $item->id }}/tandai-nama" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Tandai Nama"><i class="fa fa-pen"></i></a>
                    @endif

                    @if (Auth::user()->role->accounts_edit == 1)
                      <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editParentButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                    @endif
                  </td>
                </tr>
              @else
                <tr>
                  <td style="display: none;">{{ $item->order_number }}</td>
                  <td>{{ $item->parent->number ?? '-' }}</td>
                  <td>{{ $item->level }}</td>
                  <td class="{{ $item->mark_1 == 0 ? '' : 'bg-success text-white' }}">{{ $item->number }}</td>
                  <td class="{{ $item->mark_2 == 0 ? '' : 'bg-danger text-white' }}">{{ $item->name }}</td>
                  <td  style="text-align: right !important;">{{ number_format($item->target_before, 2, ",", ".") ?? '0' }}</td>
                  <td  style="text-align: right !important;">{{ number_format($item->target_after, 2, ",", ".") ?? '0' }}</td>

                  @if (Auth::user()->role->accounts_edit == 1 || Auth::user()->role->accounts_delete == 1 || Auth::user()->role->accounts_mark == 1 || Auth::user()->role->accounts_target == 1)
                    <td>
                      @if (Auth::user()->role->accounts_mark == 1)
                        <a href="/referensi/akun/{{ $item->id }}/tandai-no" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="Tandai No"><i class="fa fa-pen"></i></a>
                        <a href="/referensi/akun/{{ $item->id }}/tandai-nama" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Tandai Nama"><i class="fa fa-pen"></i></a>
                      @endif

                      @if(count($item->children) < 1)
                        @if (Auth::user()->role->accounts_edit == 1)
                            <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editChildrenButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                        @endif
                        @if (Auth::user()->role->accounts_delete == 1)
                          <button type="button" class="btn btn-danger btn-xs" value="{{ $item->id }}" id="deleteButton" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>
                        @endif
                       @else
                        @if (Auth::user()->role->accounts_edit == 1)
                            <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editParentButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                        @endif
                       @endif
                    </td>
                  @endif
                </tr>
              @endif
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th style="display: none;">Akun Order No</th>
              <th>Parent</th>
              <th>Akun Level</th>
              <th>Akun No</th>
              <th>Akun Nama</th>
              <th>Target Sebelum</th>
              <th>Target Sesudah</th>

              @if (Auth::user()->role->accounts_edit == 1 || Auth::user()->role->accounts_delete == 1 || Auth::user()->role->accounts_mark == 1 || Auth::user()->role->accounts_target == 1)
                <th style="width: 23%;">Aksi</th>
              @endif
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
              <h5 class="modal-title text-white">Tambah Akun</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{ route('referensi.akun.store') }}" method="post">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="">Kode Rekening</label>
                  <input type="text" name="number" placeholder="Masukkan kode rekening" class="form-control" autofocus onpaste="return false;" ondrop="return false;" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" name="name" placeholder="Masukkan nama" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="">Parent</label>
                  <div class="comboTreeWrapper">
                    <div class="comboTreeInputWrapper">
                      <input class="comboTreeInputBox" type="text" name="parent_id" id="justAnotherInputBox" placeholder="Unknown" autocomplete="off"/>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="">Peraturan / Dasar Hukum</label>
                  <input type="text" name="legal_basis" placeholder="Masukkan peraturan / dasar hukum" class="form-control">
                </div>

                <div class="form-group">
                  <label for="">Keterangan</label>
                  <textarea name="description" placeholder="Masukkan keterangan" class="form-control"></textarea>
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
      <div class="modal fade" id="editParentModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <h5 class="modal-title text-white">Edit Akun</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="editParentForm" method="post">
              <div class="modal-body">
                @csrf
                @method('PUT')
                <input type="hidden" name="children" value="0">
                <div class="form-group">
                  <label for="">Kode Rekening</label>
                  <input type="text" name="number" placeholder="Masukkan kode rekening" class="form-control" id="number" onpaste="return false;" ondrop="return false;" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" name="name" placeholder="Masukkan nama" class="form-control" id="name" required>
                </div>

                <div class="form-group">
                  <label for="">Parent</label>
                  <div class="comboTreeWrapper">
                    <div class="comboTreeInputWrapper">
                      <input class="comboTreeInputBox" type="text" name="parent_id" id="justAnotherInputBoxEdit" placeholder="Unknown" autocomplete="off"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Peraturan / Dasar Hukum</label>
                  <input type="text" name="legal_basis" placeholder="Masukkan peraturan / dasar hukum" class="form-control" id="accountSetting">
                </div>

                <div class="form-group">
                  <label for="">Keterangan</label>
                  <textarea name="description" placeholder="Masukkan keterangan" class="form-control" id="description"></textarea>
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

      <!--begin::Modal Edit-->
      <div class="modal fade" id="editChildrenModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary white">
              <h5 class="modal-title text-white">Edit Akun</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="editChildrenForm" method="post">
              <div class="modal-body">
                @csrf
                @method('PUT')
                <input type="hidden" name="children" value="1">
                <div class="form-group">
                  <label for="">Kode Rekening</label>
                  <input type="text" name="number" placeholder="Masukkan kode rekening" class="form-control" id="childrenNumber" onpaste="return false;" ondrop="return false;" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" name="name" placeholder="Masukkan nama" class="form-control" id="childrenName" required>
                </div>

                <div class="form-group">
                  <label for="">Target Sebelum</label>
                  <input type="text" name="target_before" placeholder="Masukkan target sebelum" class="form-control input-number input-currency" id="targetBefore" required>
                </div>
                <div class="form-group">
                  <label for="">Target Sesudah</label>
                  <input type="text" name="target_after" placeholder="Masukkan target sesudah" class="form-control input-number input-currency" id="targetAfter" required>
                </div>

                <div class="form-group">
                  <label for="">Parent</label>
                  <div class="comboTreeWrapper">
                    <div class="comboTreeInputWrapper">
                      <input class="comboTreeInputBox" type="text" name="parent_id" id="childrenJustAnotherInputBoxEdit" placeholder="Unknown" autocomplete="off"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Peraturan / Dasar Hukum</label>
                  <input type="text" name="legal_basis" placeholder="Masukkan peraturan / dasar hukum" class="form-control" id="childrenAccountSetting">
                </div>

                <div class="form-group">
                  <label for="">Keterangan</label>
                  <textarea name="description" placeholder="Masukkan keterangan" class="form-control" id="descriptionChildren"></textarea>
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

      <!--begin::Modal Edit Target-->
      <div class="modal fade" id="editTargetModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning white">
              <h5 class="modal-title text-white">Edit Target</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="editTargetForm" method="post">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                  <label for="">Target Sebelum</label>
                  <input type="text" name="target_before" placeholder="Masukkan target sebelum" class="form-control input-number input-currency" id="targetBefore" required>
                </div>
                <div class="form-group">
                  <label for="">Target Sesudah</label>
                  <input type="text" name="target_after" placeholder="Masukkan target sesudah" class="form-control input-number input-currency" id="targetAfter" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-outline-warning">Simpan</button>
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

      @include('/accountData/index1')

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

        $(document).on("click", "#editParentButton", function()
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
            url: "{{ route('referensi.akun.index') }}/" + id + "/edit"
          }).done(function (response)
          {
            // console.log(response);
            var number = response.number;
            var split_number = number.split(".");
            $("#number").val(split_number[split_number.length - 1]);
            $("#name").val(response.name);
            if(response.children.length > 0)
            {
              $("#justAnotherInputBoxEdit").prop("disabled", true);
              $("#number").prop("disabled", true);
            } else {
              $("#justAnotherInputBoxEdit").prop("disabled", false);
              $("#number").prop("disabled", false);
            }
            if(response.parent != null)
            {
              $("#justAnotherInputBoxEdit").val(response.parent.number + "-" + response.parent.name);
            } else {
              $("#justAnotherInputBoxEdit").val("");
            }
            $("#accountSetting").val(response.legal_basis);
            $("#description").val(response.description);
            $("#editParentForm").attr("action", "{{ route('referensi.akun.index') }}/" + id)
            $("#editParentModal").modal();
          })
        });

        $(document).on("click", "#editChildrenButton", function()
        {
          let id = $(this).val();
          var comboTree3;

          jQuery(document).ready(function($) {

            comboTree3 = $('#childrenJustAnotherInputBoxEdit').comboTree({
              source : newData,
              isMultiple: false,
              collapse: true,
            });
          });
          document.getElementById("childrenJustAnotherInputBoxEdit").empty;
          $.ajax(
          {
            method: "GET",
            url: "{{ route('referensi.akun.index') }}/" + id + "/edit"
          }).done(function (response)
          {
            // console.log(response);
            var number = response.number;
            var parent = response.parent.number + '.';
            var split_number = number.split(parent);
            console.log(split_number);
            $("#childrenNumber").val(split_number[split_number.length - 1]);
            $("#childrenName").val(response.name);
            if(response.children.length > 0)
            {
              $("#childrenJustAnotherInputBoxEdit").prop("disabled", true);
              $("#childrenNumber").prop("disabled", true);
            } else {
              $("#childrenJustAnotherInputBoxEdit").prop("disabled", false);
              $("#childrenNumber").prop("disabled", false);
            }
            if(response.parent != null)
            {
              $("#childrenJustAnotherInputBoxEdit").val(response.parent.number + "-" + response.parent.name);
            } else {
              $("#childrenJustAnotherInputBoxEdit").val("");
            }
            $("#targetBefore").val(response.target_before);
            $("#targetAfter").val(response.target_after);
            $("#childrenAccountSetting").val(response.legal_basis);
            $("#descriptionChildren").val(response.description);
            $("#editChildrenForm").attr("action", "{{ route('referensi.akun.index') }}/" + id)
            $("#editChildrenModal").modal();
          })
        });

        $(document).on("click", "#editTargetButton", function()
        {
          let id = $(this).val();
          $.ajax(
          {
            method: "GET",
            url: "{{ route('referensi.akun.index') }}/" + id + "/edit"
          }).done(function (response)
          {
            console.log(response);
            $("#targetBefore").val(response.target_before);
            $("#targetAfter").val(response.target_after);
            $("#editTargetForm").attr("action", "{{ route('referensi.akun.index') }}/" + id + '/target')
            $("#editTargetModal").modal();
          })
        });

        $(document).on("click", "#deleteButton", function()
        {
          let id = $(this).val();
          $("#deleteForm").attr("action", "{{ route('referensi.akun.index') }}/" + id)
          $("#deleteModal").modal();
        });

        $(document).ready( function () {
          $('#table_id').DataTable({
            "pageLength": 1000,
            "bLengthChange": false,
            "paging": false,
            "order": [[0, 'asc']]
          });
        } );

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
      </script>

      <script>
        var menu_link_1 = document.getElementById("kt_header_menu_3");
        menu_link_1.classList.add("active");

        var menu_link_2 = document.getElementById("kt_header_menu_mobile_3");
        menu_link_2.classList.add("active");

        var menu_link_3 = document.getElementById("kt_header_tab_3");
        menu_link_3.classList.add("active");
        menu_link_3.classList.add("show");

        var menu_link_4 = document.getElementById("menu_akun");
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
