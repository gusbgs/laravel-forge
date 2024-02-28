@extends('layouts.layoutDashboard')

@section('title', 'Hak Akses')

@section('link')

@endsection

@section('style')

<style media="screen">
    #table_id .btn {
        font-size: 12px;
        margin-top: 6px;
    }

    #table_id td {
        border-bottom: 1px solid black;
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
                    <i class="fa fa-user-shield" style="color:#3699ff; font-size:28px"></i>
                    <!--end::Svg Icon-->
                </span>
            </span>
            <h3 class="card-label">
                Manajemen Hak Akses
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted">Manajemen Pengguna</a>
                    </li>
                    <li class="breadcrumb-item text-muted active">
                        <a href="#" class="text-muted">Hak Akses</a>
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
        <table id="table_id" width="100%" class="display d-lg-table table-responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Akses</th>
                    <th>Hak Akses</th>
                    <th style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $item)
                <tr>
                    <td>{{ $n++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td style="min-width: 350px;">
                        <br>
                        @if ($item->roles_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Hak Akses <br>

                        @if ($item->roles_create == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Membuat Hak Akses <br>

                        @if ($item->roles_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit Hak Akses <br>

                        @if ($item->roles_delete == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menghapus Hak Akses <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->users_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Pengguna <br>

                        @if ($item->users_create == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Membuat Pengguna <br>

                        @if ($item->users_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit Pengguna <br>

                        @if ($item->users_delete == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menghapus Pengguna <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->accounts_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Akun <br>

                        @if ($item->accounts_create == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Membuat Akun <br>

                        @if ($item->accounts_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit Akun <br>

                        @if ($item->accounts_delete == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menghapus Akun <br>

                        @if ($item->accounts_mark == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menandai Akun <br>

                        @if ($item->accounts_target == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengubah Target Akun <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->skpd_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman SKPD <br>

                        @if ($item->skpd_create == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Membuat SKPD <br>

                        @if ($item->skpd_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit SKPD <br>

                        @if ($item->skpd_delete == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menghapus SKPD <br>

                        @if ($item->skpd_account == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengubah Akun pada SKPD<br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->journals_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Jurnal <br>

                        @if ($item->journals_create == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Membuat Jurnal <br>

                        @if ($item->journals_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit Jurnal <br>

                        @if ($item->journals_delete == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menghapus Jurnal <br>

                        @if ($item->journals_mark == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Menandai Jurnal<br>

                        @if ($item->journals_verify == 1)
                            <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                            <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Memverifikasi Jurnal<br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->reports_summary_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Ringkasan dan PAD <br>

                        @if ($item->reports_summary_print == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Print Ringkasan dan PAD <br>

                        @if ($item->reports_summary_all == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Semua Data Ringkasan dan PAD <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->reports_ledger_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Buku Besar <br>

                        @if ($item->reports_ledger_print == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Print Buku Besar <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->reports_income_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Pendapatan <br>

                        @if ($item->reports_income_print == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Print Pendapatan <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->reports_overall_view == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat Halaman Laporan Keseluruhan <br>

                        @if ($item->reports_overall_print == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Print Laporan Keseluruhan <br>
                        <hr>

                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}

                        @if ($item->profile_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit Profil <br>

                        @if ($item->about_edit == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Mengedit Tentang Aplikasi <br>
                        <hr>


                        {{-- /////////////////////////////////////////////////////////////////////////////////////// --}}
                        @if($item->all_users_data == 1)
                        <i class="fa fa-check-circle text-success view-access mb-3"></i>
                        @else
                        <i class="fa fa-times-circle text-danger view-access mb-3"></i>
                        @endif
                        Melihat data semua user <br>

                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-xs editButton" value="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-xs deleteButton" value="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Akses</th>
                    <th>Hak Akses</th>
                    <th style="width: 20%;">Aksi</th>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h5 class="modal-title text-white">Tambah Hak Akses</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{ route('userManagement.role.create') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <h5>Nama Akses</h5>
                        <input type="text" class="form-control" name="name" maxlength="250" minlength="3" placeholder="Masukkan nama akses" required>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Hak Akses</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="roles_view" id="checkboxViewRoles">
                            <label class="form-check-label">
                                Melihat Halaman Hak Akses
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_roles" type="checkbox" name="roles_create" disabled>
                            <label class="form-check-label">
                                Membuat Hak Akses
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_roles" type="checkbox" name="roles_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Hak Akses
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_roles" type="checkbox" name="roles_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Hak Akses
                            </label>
                        </div>
                    </div><br>

                    <div class="form-group">
                        <h5 class="form-section">Pengguna</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="users_view" id="checkboxViewUsers">
                            <label class="form-check-label">
                                Melihat Halaman Pengguna
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_user" type="checkbox" name="users_create" disabled>
                            <label class="form-check-label">
                                Membuat Pengguna
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_user" type="checkbox" name="users_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Pengguna
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_user" type="checkbox" name="users_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Pengguna
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Akun</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="accounts_view" id="checkboxViewAccounts">
                            <label class="form-check-label">
                                Melihat Halaman Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_account" type="checkbox" name="accounts_create" disabled>
                            <label class="form-check-label">
                                Membuat Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_account" type="checkbox" name="accounts_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_account" type="checkbox" name="accounts_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_account" type="checkbox" name="accounts_mark" disabled>
                            <label class="form-check-label">
                                Menandai Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_account" type="checkbox" name="accounts_target" disabled>
                            <label class="form-check-label">
                                Mengubah Target Akun
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">SKPD</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="skpd_view" id="checkboxViewSkpd">
                            <label class="form-check-label">
                                Melihat Halaman SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_skpd" type="checkbox" name="skpd_create" disabled>
                            <label class="form-check-label">
                                Membuat SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_skpd" type="checkbox" name="skpd_edit" disabled>
                            <label class="form-check-label">
                                Mengedit SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_skpd" type="checkbox" name="skpd_delete" disabled>
                            <label class="form-check-label">
                                Menghapus SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_skpd" type="checkbox" name="skpd_account" disabled>
                            <label class="form-check-label">
                                Mengubah Target SKPD
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Jurnal</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="journals_view" id="checkboxViewJournals">
                            <label class="form-check-label">
                                Melihat Halaman Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_journal" type="checkbox" name="journals_create" disabled>
                            <label class="form-check-label">
                                Membuat Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_journal" type="checkbox" name="journals_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_journal" type="checkbox" name="journals_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_journal" type="checkbox" name="journals_mark" disabled>
                            <label class="form-check-label">
                                Menandai Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_journal" type="checkbox" name="journals_verify" disabled>
                            <label class="form-check-label">
                                Memverifikasi Jurnal
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Ringkasan dan PAD</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_summary_view" id="checkboxViewSummary">
                            <label class="form-check-label">
                                Melihat Halaman Ringkasan dan PAD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_summary" type="checkbox" name="reports_summary_all" disabled>
                            <label class="form-check-label">
                                Melihat Semua Data Ringkasan dan PAD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_summary" type="checkbox" name="reports_summary_print" disabled>
                            <label class="form-check-label">
                                Print Ringkasan dan PAD
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Buku Besar</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_ledger_view" id="checkboxViewLedger">
                            <label class="form-check-label">
                                Melihat Halaman Buku Besar
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_ledger" type="checkbox" name="reports_ledger_print" disabled>
                            <label class="form-check-label">
                                Print Buku Besar
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Pendapatan</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_income_view" id="checkboxViewIncome">
                            <label class="form-check-label">
                                Melihat Halaman Pendapatan
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_income" type="checkbox" name="reports_income_print" disabled>
                            <label class="form-check-label">
                                Print Pendapatan
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Laporan Keseluruhan</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_overall_view" id="checkboxViewOverall">
                            <label class="form-check-label">
                                Melihat Halaman Laporan Keseluruhan
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input create_overall" type="checkbox" name="reports_overall_print" disabled>
                            <label class="form-check-label">
                                Print Laporan Keseluruhan
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Lain-lain</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="profile_edit">
                            <label class="form-check-label">
                                Mengedit Profil
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="about_edit">
                            <label class="form-check-label">
                                Mengedit Tentang Aplikasi
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Akses Data</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="all_users_data">
                            <label class="form-check-label">
                                Melihat data semua user
                            </label>
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
                <h5 class="modal-title text-white">Edit Hak Akses</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="" id="editForm" method="post">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <h5>Nama Akses</h5>
                        <input type="text" class="form-control" name="name" id="edit_name" maxlength="250" minlength="3" placeholder="Masukkan nama akses" required>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Hak Akses</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="roles_view" id="edit_checkboxViewRoles">
                            <label class="form-check-label">
                                Melihat Halaman Hak Akses
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_roles" type="checkbox" name="roles_create" id="edit_roles_create" disabled>
                            <label class="form-check-label">
                                Membuat Hak Akses
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_roles" type="checkbox" name="roles_edit" id="edit_roles_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Hak Akses
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_roles" type="checkbox" name="roles_delete" id="edit_roles_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Hak Akses
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Pengguna</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="users_view" id="edit_checkboxViewUsers">
                            <label class="form-check-label">
                                Melihat Halaman Pengguna
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_user" type="checkbox" name="users_create" id="edit_users_create" disabled>
                            <label class="form-check-label">
                                Membuat Pengguna
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_user" type="checkbox" name="users_edit" id="edit_users_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Pengguna
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_user" type="checkbox" name="users_delete" id="edit_users_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Pengguna
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Akun</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="accounts_view" id="edit_checkboxViewAccounts">
                            <label class="form-check-label">
                                Melihat Halaman Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_account" type="checkbox" name="accounts_create" id="edit_accounts_create" disabled>
                            <label class="form-check-label">
                                Membuat Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_account" type="checkbox" name="accounts_edit" id="edit_accounts_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_account" type="checkbox" name="accounts_delete" id="edit_accounts_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_account" type="checkbox" name="accounts_mark" id="edit_accounts_mark" disabled>
                            <label class="form-check-label">
                                Menandai Akun
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_account" type="checkbox" name="accounts_target" id="edit_accounts_target" disabled>
                            <label class="form-check-label">
                                Mengubah Target Akun
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">SKPD</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="skpd_view" id="edit_checkboxViewSkpd">
                            <label class="form-check-label">
                                Melihat Halaman SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_skpd" type="checkbox" name="skpd_create" id="edit_skpd_create" disabled>
                            <label class="form-check-label">
                                Membuat SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_skpd" type="checkbox" name="skpd_edit" id="edit_skpd_edit" disabled>
                            <label class="form-check-label">
                                Mengedit SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_skpd" type="checkbox" name="skpd_delete" id="edit_skpd_delete" disabled>
                            <label class="form-check-label">
                                Menghapus SKPD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_skpd" type="checkbox" name="skpd_account" id="edit_skpd_account" disabled>
                            <label class="form-check-label">
                                Mengubah Target SKPD
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Jurnal</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="journals_view" id="edit_checkboxViewJournals">
                            <label class="form-check-label">
                                Melihat Halaman Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_journal" type="checkbox" name="journals_create" id="edit_journals_create" disabled>
                            <label class="form-check-label">
                                Membuat Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_journal" type="checkbox" name="journals_edit" id="edit_journals_edit" disabled>
                            <label class="form-check-label">
                                Mengedit Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_journal" type="checkbox" name="journals_delete" id="edit_journals_delete" disabled>
                            <label class="form-check-label">
                                Menghapus Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_journal" type="checkbox" name="journals_mark" id="edit_journals_mark" disabled>
                            <label class="form-check-label">
                                Menandai Jurnal
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_journal" type="checkbox" name="journals_verify" id="edit_journals_verify" disabled>
                            <label class="form-check-label">
                                Memverifikasi Jurnal
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Ringkasan dan PAD</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_summary_view" id="edit_checkboxViewSummary">
                            <label class="form-check-label">
                                Melihat Halaman Ringkasan dan PAD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_summary" type="checkbox" name="reports_summary_all" id="edit_reports_summary_all" disabled>
                            <label class="form-check-label">
                                Melihat Semua Data Ringkasan dan PAD
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_summary" type="checkbox" name="reports_summary_print" id="edit_reports_summary_print" disabled>
                            <label class="form-check-label">
                                Print Ringkasan dan PAD
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Buku Besar</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_ledger_view" id="edit_checkboxViewLedger">
                            <label class="form-check-label">
                                Melihat Halaman Buku Besar
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_ledger" type="checkbox" name="reports_ledger_print" id="edit_reports_ledger_print" disabled>
                            <label class="form-check-label">
                                Print Buku Besar
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Pendapatan</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_income_view" id="edit_checkboxViewIncome">
                            <label class="form-check-label">
                                Melihat Halaman Pendapatan
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_income" type="checkbox" name="reports_income_print" id="edit_reports_income_print" disabled>
                            <label class="form-check-label">
                                Print Pendapatan
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Laporan Keseluruhan</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="reports_overall_view" id="edit_checkboxViewOverall">
                            <label class="form-check-label">
                                Melihat Halaman Laporan Keseluruhan
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input edit_overall" type="checkbox" name="reports_overall_print" id="edit_reports_overall_print" disabled>
                            <label class="form-check-label">
                                Print Laporan Keseluruhan
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Lain-lain</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="profile_edit" id="edit_profile_edit">
                            <label class="form-check-label">
                                Mengedit Profil
                            </label>
                        </div>

                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="about_edit" id="edit_about_edit">
                            <label class="form-check-label">
                                Mengedit Tentang Aplikasi
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="form-section">Akses Data</h5>
                        <div class="form-check mb-2 ml-2">
                            <input class="form-check-input" type="checkbox" name="all_users_data" id="edit_all_users_data">
                            <label class="form-check-label">
                                Melihat data semua user

                            </label>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_id').DataTable();
    });

</script>

<script type="text/javascript">
    $("#checkboxViewRoles").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_roles").prop("disabled", false);
        } else {
            $(".create_roles").prop("disabled", true);
            $(".create_roles").prop("checked", false);
        }
    });

    $("#edit_journals_verify").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_roles").prop("disabled", false);
        } else {
            $(".edit_roles").prop("disabled", true);
            $(".edit_roles").prop("checked", false);
        }
    });

    $("#checkboxViewUsers").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_user").prop("disabled", false);
        } else {
            $(".create_user").prop("disabled", true);
            $(".create_user").prop("checked", false);
        }
    });

    $("#edit_checkboxViewUsers").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_user").prop("disabled", false);
        } else {
            $(".edit_user").prop("disabled", true);
            $(".edit_user").prop("checked", false);
        }
    });

    $("#checkboxViewAccounts").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_account").prop("disabled", false);
        } else {
            $(".create_account").prop("disabled", true);
            $(".create_account").prop("checked", false);
        }
    });

    $("#edit_checkboxViewAccounts").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_account").prop("disabled", false);
        } else {
            $(".edit_account").prop("disabled", true);
            $(".edit_account").prop("checked", false);
        }
    });

    $("#checkboxViewSkpd").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_skpd").prop("disabled", false);
        } else {
            $(".create_skpd").prop("disabled", true);
            $(".create_skpd").prop("checked", false);
        }
    });

    $("#edit_checkboxViewSkpd").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_skpd").prop("disabled", false);
        } else {
            $(".edit_skpd").prop("disabled", true);
            $(".edit_skpd").prop("checked", false);
        }
    });

    $("#checkboxViewJournals").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_journal").prop("disabled", false);
        } else {
            $(".create_journal").prop("disabled", true);
            $(".create_journal").prop("checked", false);
        }
    });

    $("#edit_checkboxViewJournals").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_journal").prop("disabled", false);
        } else {
            $(".edit_journal").prop("disabled", true);
            $(".edit_journal").prop("checked", false);
        }
    });

    $("#edit_checkboxViewJournals").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_journal").prop("disabled", false);
        } else {
            $(".edit_journal").prop("disabled", true);
            $(".edit_journal").prop("checked", false);
        }
    });

    $("#checkboxViewSummary").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_summary").prop("disabled", false);
        } else {
            $(".create_summary").prop("disabled", true);
            $(".create_summary").prop("checked", false);
        }
    });

    $("#edit_checkboxViewSummary").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_summary").prop("disabled", false);
        } else {
            $(".edit_summary").prop("disabled", true);
            $(".edit_summary").prop("checked", false);
        }
    });

    $("#checkboxViewLedger").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_ledger").prop("disabled", false);
        } else {
            $(".create_ledger").prop("disabled", true);
            $(".create_ledger").prop("checked", false);
        }
    });

    $("#edit_checkboxViewLedger").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_ledger").prop("disabled", false);
        } else {
            $(".edit_ledger").prop("disabled", true);
            $(".edit_ledger").prop("checked", false);
        }
    });

    $("#checkboxViewIncome").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_income").prop("disabled", false);
        } else {
            $(".create_income").prop("disabled", true);
            $(".create_income").prop("checked", false);
        }
    });

    $("#edit_checkboxViewIncome").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_income").prop("disabled", false);
        } else {
            $(".edit_income").prop("disabled", true);
            $(".edit_income").prop("checked", false);
        }
    });

    $("#checkboxViewOverall").on("change", function() {
        if ($(this).is(":checked")) {
            $(".create_overall").prop("disabled", false);
        } else {
            $(".create_overall").prop("disabled", true);
            $(".create_overall").prop("checked", false);
        }
    });

    $("#edit_checkboxViewOverall").on("change", function() {
        if ($(this).is(":checked")) {
            $(".edit_overall").prop("disabled", false);
        } else {
            $(".edit_overall").prop("disabled", true);
            $(".edit_overall").prop("checked", false);
        }
    });

    $("#edit_checkboxViewOverall").on("change", function() {
        if ($(this).is(":checked")) {
            $(".all_users_data").prop("disabled", false);
        } else {
            $(".all_users_data").prop("disabled", true);
            $(".all_users_data").prop("checked", false);
        }
    });

</script>

<script type="text/javascript">
    var token = $("meta[name=\"_token\"]").attr("content");

    $("#createButton").on("click", function() {
        $("#createModal").modal();
    });

    $(".editButton").on("click", function() {
        var id = $(this).val();
        $.ajax({
            method: "get"
            , url: "/userManagement/role/edit/" + id
        , }).done(function(response) {
            $('#editForm').attr("action", "/userManagement/role/update/" + id);
            $("#edit_name").val(response.name);

            ////////////////////////////////////////////////////////////////////////

            if (response.roles_view == 1) {
                $("#edit_checkboxViewRoles").prop("checked", true);
                $(".edit_roles").prop("disabled", false);

            } else {
                $("#edit_checkboxViewRoles").prop("checked", false);
                $(".edit_roles").prop("disabled", true);
            }

            if (response.roles_create == 1) {
                $("#edit_roles_create").prop("checked", true);
            } else {
                $("#edit_roles_create").prop("checked", false);
            }

            if (response.roles_edit == 1) {
                $("#edit_roles_edit").prop("checked", true);
            } else {
                $("#edit_roles_edit").prop("checked", false);
            }

            if (response.roles_delete == 1) {
                $("#edit_roles_delete").prop("checked", true);
            } else {
                $("#edit_roles_delete").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.users_view == 1) {
                $("#edit_checkboxViewUsers").prop("checked", true);
                $(".edit_user").prop("disabled", false);

            } else {
                $("#edit_checkboxViewUsers").prop("checked", false);
                $(".edit_user").prop("disabled", true);
            }

            if (response.users_create == 1) {
                $("#edit_users_create").prop("checked", true);
            } else {
                $("#edit_users_create").prop("checked", false);
            }

            if (response.users_edit == 1) {
                $("#edit_users_edit").prop("checked", true);
            } else {
                $("#edit_users_edit").prop("checked", false);
            }

            if (response.users_delete == 1) {
                $("#edit_users_delete").prop("checked", true);
            } else {
                $("#edit_users_delete").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.accounts_view == 1) {
                $("#edit_checkboxViewAccounts").prop("checked", true);
                $(".edit_account").prop("disabled", false);

            } else {
                $("#edit_checkboxViewAccounts").prop("checked", false);
                $(".edit_account").prop("disabled", true);
            }

            if (response.accounts_create == 1) {
                $("#edit_accounts_create").prop("checked", true);
            } else {
                $("#edit_accounts_create").prop("checked", false);
            }

            if (response.accounts_edit == 1) {
                $("#edit_accounts_edit").prop("checked", true);
            } else {
                $("#edit_accounts_edit").prop("checked", false);
            }

            if (response.accounts_delete == 1) {
                $("#edit_accounts_delete").prop("checked", true);
            } else {
                $("#edit_accounts_delete").prop("checked", false);
            }

            if (response.accounts_mark == 1) {
                $("#edit_accounts_mark").prop("checked", true);
            } else {
                $("#edit_accounts_mark").prop("checked", false);
            }

            if (response.accounts_target == 1) {
                $("#edit_accounts_target").prop("checked", true);
            } else {
                $("#edit_accounts_target").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.skpd_view == 1) {
                $("#edit_checkboxViewSkpd").prop("checked", true);
                $(".edit_skpd").prop("disabled", false);

            } else {
                $("#edit_checkboxViewSkpd").prop("checked", false);
                $(".edit_skpd").prop("disabled", true);
            }

            if (response.skpd_create == 1) {
                $("#edit_skpd_create").prop("checked", true);
            } else {
                $("#edit_skpd_create").prop("checked", false);
            }

            if (response.skpd_edit == 1) {
                $("#edit_skpd_edit").prop("checked", true);
            } else {
                $("#edit_skpd_edit").prop("checked", false);
            }

            if (response.skpd_delete == 1) {
                $("#edit_skpd_delete").prop("checked", true);
            } else {
                $("#edit_skpd_delete").prop("checked", false);
            }

            if (response.skpd_account == 1) {
                $("#edit_skpd_account").prop("checked", true);
            } else {
                $("#edit_skpd_account").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.journals_view == 1) {
                $("#edit_checkboxViewJournals").prop("checked", true);
                $(".edit_journal").prop("disabled", false);

            } else {
                $("#edit_checkboxViewJournals").prop("checked", false);
                $(".edit_journal").prop("disabled", true);
            }

            if (response.journals_create == 1) {
                $("#edit_journals_create").prop("checked", true);
            } else {
                $("#edit_journals_create").prop("checked", false);
            }

            if (response.journals_edit == 1) {
                $("#edit_journals_edit").prop("checked", true);
            } else {
                $("#edit_journals_edit").prop("checked", false);
            }

            if (response.journals_delete == 1) {
                $("#edit_journals_delete").prop("checked", true);
            } else {
                $("#edit_journals_delete").prop("checked", false);
            }

            if (response.journals_mark == 1) {
                $("#edit_journals_mark").prop("checked", true);
            } else {
                $("#edit_journals_mark").prop("checked", false);
            }

            if (response.journals_verify == 1) {
                $("#edit_journals_verify").prop("checked", true);
            } else {
                $("#edit_journals_verify").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.reports_summary_view == 1) {
                $("#edit_checkboxViewSummary").prop("checked", true);
                $(".edit_summary").prop("disabled", false);

            } else {
                $("#edit_checkboxViewSummary").prop("checked", false);
                $(".edit_summary").prop("disabled", true);
            }

            if (response.reports_summary_print == 1) {
                $("#edit_reports_summary_print").prop("checked", true);
            } else {
                $("#edit_reports_summary_print").prop("checked", false);
            }

            if (response.reports_summary_all == 1) {
                $("#edit_reports_summary_all").prop("checked", true);
            } else {
                $("#edit_reports_summary_all").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.reports_ledger_view == 1) {
                $("#edit_checkboxViewLedger").prop("checked", true);
                $(".edit_ledger").prop("disabled", false);

            } else {
                $("#edit_checkboxViewLedger").prop("checked", false);
                $(".edit_ledger").prop("disabled", true);
            }

            if (response.reports_ledger_print == 1) {
                $("#edit_reports_ledger_print").prop("checked", true);
            } else {
                $("#edit_reports_ledger_print").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.reports_income_view == 1) {
                $("#edit_checkboxViewIncome").prop("checked", true);
                $(".edit_income").prop("disabled", false);

            } else {
                $("#edit_checkboxViewIncome").prop("checked", false);
                $(".edit_income").prop("disabled", true);
            }

            if (response.reports_income_print == 1) {
                $("#edit_reports_income_print").prop("checked", true);
            } else {
                $("#edit_reports_income_print").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.reports_overall_view == 1) {
                $("#edit_checkboxViewOverall").prop("checked", true);
                $(".edit_overall").prop("disabled", false);

            } else {
                $("#edit_checkboxViewOverall").prop("checked", false);
                $(".edit_overall").prop("disabled", true);
            }

            if (response.reports_overall_print == 1) {
                $("#edit_reports_overall_print").prop("checked", true);
            } else {
                $("#edit_reports_overall_print").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////

            if (response.profile_edit == 1) {
                $("#edit_profile_edit").prop("checked", true);
            } else {
                $("#edit_profile_edit").prop("checked", false);
            }

            if (response.about_edit == 1) {
                $("#edit_about_edit").prop("checked", true);
            } else {
                $("#edit_about_edit").prop("checked", false);
            }

            ////////////////////////////////////////////////////////////////////////
            if (response.all_users_data == 1) {
                $("#edit_all_users_data").prop("checked", true);
            } else {
                $("#edt_all_users_data").prop("checked", false);
            }


            $("#editModal").modal();
        });
    });

    $(document).on("click", ".deleteButton", function() {
        var id = $(this).val();
        $("#deleteForm").attr("action", "/userManagement/role/delete/" + id)
        $("#deleteModal").modal();
    });

</script>

<script>
    var menu_link_1 = document.getElementById("kt_header_menu_5");
    menu_link_1.classList.add("active");

    var menu_link_2 = document.getElementById("kt_header_menu_mobile_5");
    menu_link_2.classList.add("active");

    var menu_link_3 = document.getElementById("kt_header_tab_5");
    menu_link_3.classList.add("active");
    menu_link_3.classList.add("show");

    var menu_link_4 = document.getElementById("menu_role");
    menu_link_4.classList.add("menu-item-active");

</script>

@endsection
