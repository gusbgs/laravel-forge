@extends('layouts.layoutDashboard')

@section('title', 'Pengguna')

@section('link')

@endsection

@section('style')

    <style media="screen">
        #table_id .btn {
            font-size: 12px;
            margin-top: 6px;
        }

        .table-image img {
            width: 80px;
            height: 80px;
        }

        .profile-picture img {
            width: 200px;
            height: 200px;
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
                        <i class="fa fa-users" style="color:#3699ff; font-size:28px"></i>
                        <!--end::Svg Icon-->
                    </span>
                </span>
                <h3 class="card-label">
                    Daftar Pengguna
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">Manajemen Pengguna</a>
                        </li>
                        <li class="breadcrumb-item text-muted active">
                            <a href="#" class="text-muted">Pengguna</a>
                        </li>
                    </ul>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="#" class="btn btn-success font-weight-bolder" id="createButton">
                    <i class="fa fa-plus"></i>Tambah
                </a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table id="table_id" width="100%" class="display compact d-lg-table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto Profil</th>
                        <th>Nama</th>
                        <th>Hak Akses</th>
                        <th>SKPD</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Status</th>
                        <th style="width: 100px !important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td class="text-center">{{ $n++ }}</td>
                            <td class="table-image px-6 py-6"><img
                                    src="{{ $item->profile_picture ?? '/images/user-blank-1.png' }}" alt="Picture"> </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->role->name ?? '-' }}</td>
                            <td>{{ $item->skpd->name ?? '-' }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>
                                @if (Cache::has('user-is-online-' . $item->id))
                                    <span class="label label-lg label-light-success label-inline">Online</span>
                                @else
                                    <span class="label label-lg label-light-danger label-inline">Offline</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-xs editButton" value="{{ $item->id }}"
                                    data-toggle="tooltip" data-placement="bottom" title="Edit"><i
                                        class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-xs deleteButton"
                                    value="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom"
                                    title="Hapus"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Foto Profil</th>
                        <th>Nama</th>
                        <th>Hak Akses</th>
                        <th>SKPD</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->

@endsection

@section('modal')

    <!--begin::Modal Create-->
    <div class="modal fade" id="createModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success white">
                    <h5 class="modal-title text-white">Tambah Pengguna</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <form action="{{ route('userManagement.user.create') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <h5>Foto Profil</h5>
                            <div class="profile-picture">
                                <img id="users-picture" src="/images/user-blank-5.png" alt="Foto Profile">
                            </div><br>
                            <input type="file" id="input-users-picture" name="profile_picture" class="form-control-file"
                                data-show-upload="false" data-show-caption="true" data-show-preview="true" accept="image/*"
                                data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
                        </div>

                        <div class="form-group">
                            <h5>Nama Pengguna <span class="text-danger">*</span></h5>
                            <input type="text" class="form-control" name="name" maxlength="250" minlength="3"
                                placeholder="Masukkan nama pengguna" required>
                        </div>

                        <div class="form-group">
                            <h5>Hak Akses <span class="text-danger">*</span></h5>
                            <select name="role_id" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <h5>SKPD</h5>
                            <select name="skpd_id" class="form-control">
                                <option value="this_skpd_all" selected>--Semua SKPD--</option>
                                @foreach ($skpd as $skpd_item)
                                    <option value="{{ $skpd_item->id }}">{{ $skpd_item->name }}</option>
                                @endforeach
                            </select>
                            <small style="color: grey">Jika --Semua SKPD-- dipilih, maka pengguna ini dapat melihat data
                                laporan dari semua SKPD</small>
                        </div>


                        <div class="form-group">
                            <h5>Email <span class="text-danger">*</span></h5>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-check-circle-outline">@</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" name="email" maxlength="250"
                                    minlength="1" placeholder="Masukkan alamat email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Nomor Telepon</h5>
                            <input type="text" class="form-control input-number" name="phone_number" maxlength="250"
                                minlength="3" placeholder="Masukkan nomor telepon" onpaste="return false;"
                                ondrop="return false;" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <h5>Username <span class="text-danger">*</span></h5>
                            <input type="text" class="form-control" name="username" maxlength="250" minlength="3"
                                placeholder="Masukkan username" required>
                        </div>

                        <div class="form-group">
                            <h5>Password <span class="text-danger">*</span></h5>
                            <input type="password" name="password" id="password_users" class="form-control"
                                maxlength="250" minlength="6" placeholder="Masukkan password" required>
                        </div>

                        <div class="form-group">
                            <h5>Konfirmasi Password <span class="text-danger">*</span></h5>
                            <input type="password" name="confirm_password" id="confirm_password_users"
                                class="form-control" maxlength="250" minlength="6"
                                placeholder="Masukkan konfirmasi password" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-outline-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal Create-->

    <!--begin::Modal Edit-->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title text-white">Edit Pengguna</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"
                        aria-label="Close">&times;</button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="edit_id" value="">

                        <div class="form-group">
                            <h5>Foto Profil</h5>
                            <div class="profile-picture">
                                <img id="edit-users-picture" src="" alt="Foto Profile">
                            </div><br>
                            <input type="file" id="edit-input-users-picture" name="profile_picture"
                                class="form-control-file" data-show-upload="false" data-show-caption="true"
                                data-show-preview="true" accept="image/*"
                                data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
                        </div>

                        <div class="form-group">
                            <h5>Nama Pengguna <span class="text-danger">*</span></h5>
                            <input type="text" class="form-control" name="name" id="edit_name" maxlength="250"
                                minlength="3" placeholder="Masukkan nama pengguna" required>
                        </div>

                        <div class="form-group">
                            <h5>Hak Akses <span class="text-danger">*</span></h5>
                            <select name="role_id" id="edit_role_id" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <h5>SKPD</h5>
                            <select name="skpd_id" id="edit_skpd_id" class="form-control">
                                <option value="this_skpd_all" selected>--Semua SKPD--</option>
                                @foreach ($skpd as $skpd_item)
                                    <option value="{{ $skpd_item->id }}">{{ $skpd_item->name }}</option>
                                @endforeach
                            </select>
                            <small style="color: grey">Jika --Semua SKPD-- dipilih, maka pengguna ini dapat melihat data
                                laporan dari semua SKPD</small>
                        </div>


                        <div class="form-group">
                            <h5>Email <span class="text-danger">*</span></h5>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-check-circle-outline">@</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control" name="email" id="edit_email"
                                    maxlength="250" minlength="1" placeholder="Masukkan alamat email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Nomor Telepon</h5>
                            <input type="text" class="form-control input-number" name="phone_number"
                                id="edit_phone_number" maxlength="250" minlength="3"
                                placeholder="Masukkan nomor telepon" onpaste="return false;" ondrop="return false;"
                                autocomplete="off">
                        </div>

                        <div class="form-group">
                            <h5>Username <span class="text-danger">*</span></h5>
                            <input type="text" class="form-control" name="username" id="edit_username"
                                maxlength="250" minlength="3" placeholder="Masukkan username" required>
                        </div>

                        <div id="change-password-form" hidden>
                            <div class="form-group">
                                <h5>Password Baru</h5>
                                <input type="password" name="password" id="edit_password_users" class="form-control"
                                    maxlength="250" minlength="6" placeholder="Masukkan password">
                            </div>

                            <div class="form-group">
                                <h5>Konfirmasi Password Baru</h5>
                                <input type="password" name="confirm_password" id="edit_confirm_password_users"
                                    class="form-control" maxlength="250" minlength="6"
                                    placeholder="Masukkan konfirmasi password">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Kembali</button>
                        <font id="change-password-btn" class="btn btn-outline-primary">
                            Ubah Password
                        </font>
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
                    <button type="button" class="close text-white" data-dismiss="modal"
                        aria-label="Close">&times;</button>
                </div>
                <form action="" id="deleteForm" method="post">
                    <div class="modal-footer">
                        @csrf
                        <button type="button" class="btn grey btn-outline-secondary"
                            data-dismiss="modal">Kembali</button>
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
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>

    <script type="text/javascript">
        $("#createButton").on("click", function() {
            $("#createModal").modal();
        });
        
        $(document).on("click", ".editButton", function() {
            let id = $(this).val();
            document.getElementById("change-password-form").hidden = true;
            document.getElementById("change-password-btn").hidden = false;

            $.ajax({
                method: "GET",
                url: "/userManagement/user/edit/" + id
            }).done(function(response) {
                console.log(response);
                $("#edit_id").val(response.id);
                $("#edit-users-picture").attr('src', response.profile_picture);
                $("#edit-input-users-picture").val('');
                $("#edit_name").val(response.name);
                $("#edit_role_id").val(response.role_id);
                if (response.skpd_id != null) {
                    $("#edit_skpd_id").val(response.skpd_id);
                } else {
                    $("#edit_skpd_id").val('this_skpd_all');
                }
                $("#edit_email").val(response.email);
                $("#edit_phone_number").val(response.phone_number);
                $("#edit_username").val(response.username);
                    $("#edit_password_users").val('');
                    $("#edit_confirm_password_users").val('');
            
                $("#editForm").attr("action", "/userManagement/user/update/" + id)
                $("#editModal").modal();
            })
        });

        $(document).on("click", ".deleteButton", function() {
            var id = $(this).val();
            $("#deleteForm").attr("action", "/userManagement/user/delete/" + id)
            $("#deleteModal").modal();
        });
    </script>

    <script>
        document.getElementById("change-password-btn").onclick = function() {
            showProfilePassword()
        };

        function showProfilePassword() {
            document.getElementById("change-password-form").hidden = false;
            document.getElementById("change-password-btn").hidden = true;
        }
    </script>

    <script type="text/javascript">
        $(".input-number").on("keypress", function(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        });
    </script>

    <script>
        function readProfilePicture(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#users-picture').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#input-users-picture").change(function() {
            readProfilePicture(this);
        });
    </script>

    <script>
        function readProfilePicture2(input) {
            if (input.files && input.files[0]) {
                var reader2 = new FileReader();
                reader2.onload = function(e) {
                    $('#edit-users-picture').attr('src', e.target.result);
                }
                reader2.readAsDataURL(input.files[0]);
            }
        }
        $("#edit-input-users-picture").change(function() {
            readProfilePicture2(this);
        });
    </script>

    {{-- <script type="text/javascript">
        var password_users = document.getElementById("password_users"),
            confirm_password_users = document.getElementById("confirm_password_users");

        function validatePassword1() {

            if (password_users.value != confirm_password_users.value) {
                confirm_password_users.setCustomValidity("Passwords Tidak Cocok!");
            } else {
                confirm_password_users.setCustomValidity('');
            }
        }
        password_users.onchange = validatePassword1;
        confirm_password_users.onkeyup = validatePassword1;
    </script> --}}

    {{-- <script type="text/javascript">
        var edit_password_users = document.getElementById("edit_password_users"),
            edit_confirm_password_users = document.getElementById("edit_confirm_password_users");

        function validatePassword2() {

            if (edit_password_users.value != edit_confirm_password_users.value) {
                edit_confirm_password_users.setCustomValidity("Passwords Tidak Cocok!");
            } else {
                edit_confirm_password_users.setCustomValidity('');
            }
        }
        edit_password_users.onchange = validatePassword2;
        edit_confirm_password_users.onkeyup = validatePassword2;
    </script> --}}

    <script>
        var menu_link_1 = document.getElementById("kt_header_menu_5");
        menu_link_1.classList.add("active");

        var menu_link_2 = document.getElementById("kt_header_menu_mobile_5");
        menu_link_2.classList.add("active");

        var menu_link_3 = document.getElementById("kt_header_tab_5");
        menu_link_3.classList.add("active");
        menu_link_3.classList.add("show");

        var menu_link_4 = document.getElementById("menu_user");
        menu_link_4.classList.add("menu-item-active");
    </script>

@endsection
