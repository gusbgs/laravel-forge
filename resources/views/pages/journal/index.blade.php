@extends('layouts.layoutDashboard')

@section('title', 'Jurnal')

@section('link')

@endsection

@section('style')

<style media="screen">
    #table_id .btn {
        font-size: 12px;
        margin-top: 6px;
    }

    .card.card-custom>.card-body {
        padding: 2rem 0;
    }

    #kt_tab_pane_5_1 {
        padding: 2rem 2.25rem;
    }

    #kt_tab_pane_5_2 .container-fluid {
        padding: 0 0;
    }

    .card-header-value {
        text-align: center;
        background: #3569fe !important;
    }

    .card-value h4 {
        color: white !important;
    }

    .card-value .card-body {
        text-align: center;
    }

    .card.card-custom>.card-header-value .card-title {
        margin: auto;
    }

    .card-realisasi .col-3 {
        text-align: right;
    }

    .card-realisasi h5 {
        font-weight: normal;
        font-size: 14px;
    }

    .card-realisasi b {
        font-size: 16px;
    }

    @media only screen and (max-width: 600px) {
        .card-realisasi h5 {
            font-size: 8px !important;
        }

        .card-realisasi b {
            font-size: 10px;
        }
    }
</style>

@endsection

@section('navigation')

@endsection

@section('content')

<!--begin::Navigation-->
<div class="card card-custom mt-5">
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
                <font style="font-size: 16px;">
                    LAPORAN REALISASI PENDAPATAN DAERAH JURNAL UMUM {{ $show_filter_date }}
                    <br>
                    @if ($skpd_name != null)
                    ({{ $skpd_name }})
                    @endif
                </font>
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted">Jurnal</a>
                    </li>
                    <li class="breadcrumb-item text-muted active">
                        <a href="#" class="text-muted">Jurnal</a>
                    </li>
                </ul>
            </h3>
        </div>
    </div>
</div>
<!--end::Navigation-->

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
                    {{ number_format($this_year, 2, ",", ".") }}
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
                    {{ number_format($last_year, 2, ",", ".") }}
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
                    {{ number_format($total, 2, ",", ".") }}
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
            {{-- @if (Auth::user()->role->journals_create == 1 && $input_date != null) --}}
            <a href="{{{ route('journal.journal.create') }}}" class="btn btn-success font-weight-bolder">
                <i class="fa fa-plus"></i>Tambah
            </a>
            {{-- @endif --}}
            {{-- @if (Auth::user()->role->journals_create == 1 && $input_date != null) --}}
            {{-- <a href="#" class="btn btn-success font-weight-bolder" id="createButton">
                    <i class="fa fa-plus"></i>Tambah
                </a> --}}
            {{-- @endif --}}
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_tab_pane_5_1" role="tabpanel" aria-labelledby="kt_tab_pane_5_1">
                <div class="table-responsive">
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
                            <th>Waktu & User Yang Menambahkan</th>

                            @if (Auth::user()->role->journals_edit == 1 || Auth::user()->role->journals_delete == 1 || Auth::user()->role->journals_mark == 1)
                                <th style="width: 100px !important;">Aksi</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            function getColor($name)
                            {
                            // level 600, see: materialuicolors.co
                            $colors = [
                            '#e53935', // red
                            '#d81b60', // pink
                            '#8e24aa', // purple
                            '#5e35b1', // deep-purple
                            '#3949ab', // indigo
                            '#1e88e5', // blue
                            '#039be5', // light-blue
                            '#00acc1', // cyan
                            '#00897b', // teal
                            '#43a047', // green
                            '#7cb342', // light-green
                            '#c0ca33', // lime
                            '#fdd835', // yellow
                            '#ffb300', // amber
                            '#fb8c00', // orange
                            '#f4511e', // deep-orange
                            '#6d4c41', // brown
                            '#757575', // grey
                            '#546e7a', // blue-grey
                            ];
                            $unique = hexdec(substr(md5($name), -8));
                            return $colors[$unique % count($colors)];
                            }
                        @endphp
                        @foreach($journal as $item)

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
                                <td>{{ $item->skpd->name ?? '-' }}</td>
                                <td><span class="badge text-white" style="background-color:  {{getColor($item->user->name)}}">{{ $item->user->name }}
                                    - {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i:s') }}</span>
                                </td>

                                <td>
                                    @if($item->verify_at == null)
                                        @if (Auth::user()->role->journals_edit == 1 || Auth::user()->role->journals_delete == 1 || Auth::user()->role->journals_mark == 1)
                                            @if (Auth::user()->role->journals_edit == 1)
                                                <button type="button" class="btn btn-primary btn-xs" value="{{ $item->id }}" id="editButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i>
                                                </button>
                                            @endif

                                            @if (Auth::user()->role->journals_delete == 1)
                                                <button type="button" class="btn btn-danger btn-xs" value="{{ $item->id }}" id="deleteButton" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>
                                            @endif

                                            @if (Auth::user()->role->journals_mark == 1)
                                                <a href="/journal/journal/{{ $item->id }}/tandai" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="Tandai No"><i class="fa fa-pen" style="color:black"></i></a>
                                            @endif
                                        @endif
                                    @endif
                                </td>

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
                            <th>Waktu & User Yang Menambahkan</th>


                            @if (Auth::user()->role->journals_edit == 1 || Auth::user()->role->journals_delete == 1 || Auth::user()->role->journals_mark == 1)
                                <th>Aksi</th>
                            @endif
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="tab-pane fade" id="kt_tab_pane_5_2" role="tabpanel" aria-labelledby="kt_tab_pane_5_2">
                <div class="container-fluid">

                    <div class="row card-realisasi mb-3">
                        <div class="col-md-2 col-3">
                            <h5 class="text-muted mr-2"></h5>
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

                    @php $no = 1; @endphp
                    @foreach($realisasi_rekening as $item)
                    @if($item[1] != 0)
                    <div class="row card-realisasi mb-1" style="margin-right: 100px;">
                        <div class="col-md-2 col-3">
                            <h5 class="text-muted mr-2">{{ $no++ }}</h5>
                        </div>
                        <div class="col-md-5 col-4">
                            <h5>
                                {{ $item[0] }}
                                <font style="position:absolute; right: 0;">:</font>
                            </h5>

                        </div>
                        <div class="col-md-5 col-5" style="text-align: right;">
                            <h5>Rp.{{ number_format($item[1], 2, ",", ".") }}</h5>
                        </div>
                    </div>
                    <br>
                    @endif
                    @endforeach
                    <hr>
                    <div class="row card-realisasi mt-8" style="margin-right: 100px;">
                        <div class="col-md-2 col-3">
                            <h5 class="text-muted mr-2"></h5>
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
                                    Rp.{{ number_format($realisasi_rekening_total, 2, ",", ".") }}
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

<!--begin::Modal Date-->
<div class="modal fade" id="dateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title text-white">Filter tanggal</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                </button>
            </div>
            <form action="/journal/journal" method="get">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" name="input_date" value="{{ $input_date }}" id="kt_datepicker_day_2" class="form-control" readonly placeholder="Pilih Tanggal" autocomplete="off" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali
                    </button>
                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Date-->

<!--begin::Modal Filter-->
<div class="modal fade" id="filterModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title text-white">Filter data</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                </button>
            </div>
            <form action="/journal/journal" method="get">
                <div class="modal-body">
                    @csrf
                    <input name="input_date" type="hidden" value="{{ $input_date }}">
                    <div class="form-group">
                        <label for="">Skpd</label>
                        <select name="skpd_id" class="form-control skpd-select-input selectpicker" data-live-search="true">
                            <option value="null">Pilih salah satu</option>
                            @if($skpd_id != null)
                            <option value="{{ $skpd_id }}" hidden>{{ $skpd_name }}</option>
                            @endif
                            @foreach($skpd as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Tipe Filter</label>
                        <select class="form-control" id="checkFilterType" autocomplete="off">
                            <option>Harian</option>
                            <option>Bulanan</option>
                        </select>
                    </div>

                    <div class="form-group" id="formDay">
                        <label for="">Tanggal</label>
                        <input type="text" name="date" id="kt_datepicker_day" class="form-control" readonly placeholder="Pilih Tanggal" autocomplete="off" />
                    </div>

                    <div class="form-group" id="formMonth" hidden>
                        <label for="">Tanggal</label>
                        <input type="text" id="kt_datepicker_month" class="form-control" readonly placeholder="Pilih Tanggal" autocomplete="off" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali
                    </button>
                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Filter-->

<!--begin::Modal Create-->
<div class="modal fade" id="createModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h5 class="modal-title text-white">Tambah Jurnal</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                </button>
            </div>
            <form action="{{ route('journal.journal.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Skpd</label>
                        <select name="skpd_id" class="form-control skpd-select-input selectpicker" data-live-search="true" required>
                            <option value="">Pilih salah satu</option>
                            @foreach($skpd as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Akun</label>
                        <select name="account_id" class="form-control skpd-account-select-input js-example-basic-single" style="width: 100%; height: 100%;" disabled required>
                            <option value="0">Pilih skpd terlebih dahulu</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" name="date" value="{{ $input_date }}" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">No Bukti</label>
                        <input type="text" name="evidance" placeholder="Masukkan nomor bukti" class="form-control input-number" onpaste="return false;" ondrop="return false;" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Uraian</label>
                        <textarea name="description" placeholder="Masukkan uraian" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Tahun kemarin?</label>
                        <select name="last_year" class="form-control lastYear" required>
                            <option value="0">Tidak</option>
                            <option value="1">Iya</option>
                        </select>
                    </div>
                    <div class="form-group lastYearDescription" style="display: none;">
                        <label for="">Keterangan (tahun kemaren)</label>
                        <textarea name="last_year_description" placeholder="Masukkan keterangan" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Apakah nilai mengandung sen?</label>
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="radioValue" class="radio-value" value="iya" checked>
                                <span></span>
                                Iya
                            </label>
                            <label class="radio">
                                <input type="radio" name="radioValue" class="radio-value" value="tidak">
                                <span></span>
                                Tidak
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nilai</label>
                        <div class="input-value-sen">
                            <input type="text" name="value1" placeholder="Masukkan nilai" class="form-control masking2" onpaste="return false;" ondrop="return false;" autocomplete="off">
                        </div>
                        <div class="input-value d-none">
                            <input type="text" name="value2" placeholder="Masukkan nilai" class="form-control input-currency" onpaste="return false;" ondrop="return false;" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali
                    </button>
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
                <h5 class="modal-title text-white">Edit Jurnal</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                </button>
            </div>
            <form action="" id="editForm" method="post">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Skpd</label>
                        <select name="skpd_id" class="form-control skpd-select-input selectpicker" data-live-search="true" id="skpdId" required>
                            @foreach($skpd as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Akun</label>
                        <select name="account_id" class="form-control skpd-account-select-input js-example-basic-single" style="width: 100%; height: 100%;" id="accountId" disabled required>
                            <option value="0">Pilih skpd terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                    <div class="form-group">
                        <label for="">No Bukti</label>
                        <input type="text" name="evidance" placeholder="Masukkan nomor bukti" class="form-control input-number" id="evidance" onpaste="return false;" ondrop="return false;" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="">Uraian</label>
                        <textarea name="description" placeholder="Masukkan uraian" class="form-control" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Tahun kemarin?</label>
                        <select name="last_year" class="form-control editLastYear" required>
                            <option value="0">Tidak</option>
                            <option value="1">Iya</option>
                        </select>
                    </div>
                    <div class="form-group editLastYearDescription">
                        <label for="">Keterangan (tahun kemaren)</label>
                        <textarea name="last_year_description" placeholder="Masukkan keterangan" class="form-control editLastYearDescriptionValue"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Nilai Sebelumnya</label>
                        <input type="text" placeholder="Masukkan nilai" class="form-control" id="value" onpaste="return false;" ondrop="return false;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label>Apakah nilai baru mengandung sen?</label>
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="radioValue" class="edit-radio-value" value="iya" checked>
                                <span></span>
                                Iya
                            </label>
                            <label class="radio">
                                <input type="radio" name="radioValue" class="edit-radio-value" value="tidak">
                                <span></span>
                                Tidak
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nilai Baru</label>
                        <div class="edit-input-value-sen">
                            <input type="text" name="value1" placeholder="Masukkan nilai" class="form-control masking2" onpaste="return false;" ondrop="return false;" autocomplete="off">
                        </div>
                        <div class="edit-input-value d-none">
                            <input type="text" name="value2" placeholder="Masukkan nilai" class="form-control input-currency" onpaste="return false;" ondrop="return false;" autocomplete="off">
                        </div>
                        <span class="text-danger">Kosongkan kolom jika tidak ingin mengubah nilai</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali
                    </button>
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
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                </button>
            </div>
            <form action="" id="deleteForm" method="post">
                <div class="modal-footer">
                    @csrf
                    @method("DELETE")
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali
                    </button>
                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Delete-->

@endsection

@section('modal')

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.radio-value').on('click', function() {
            var val = $(this).val();
            console.log(val);
            if (val == 'iya') {
                $('.input-value').addClass('d-none');
                $('.input-currency').val(null);
                $('.input-value-sen').removeClass('d-none');

            } else {
                $('.input-value-sen').addClass('d-none');
                $('.masking2').val(null);
                $('.input-value').removeClass('d-none');
            }
        });

        $('.edit-radio-value').on('click', function() {
            var val = $(this).val();
            console.log(val);
            if (val == 'iya') {
                $('.edit-input-value').addClass('d-none');
                $('.input-currency').val(null);
                $('.edit-input-value-sen').removeClass('d-none');

            } else {
                $('.edit-input-value-sen').addClass('d-none');
                $('.masking2').val(null);
                $('.edit-input-value').removeClass('d-none');
            }
        });

        $('#masking1').mask('#.##0', {
            reverse: true
        });
        $('.masking2').mask('#.##0,00', {
            reverse: true
        });
        $('#masking3').mask('#,##0.00', {
            reverse: true
        });
    });

    // Class definition

    var KTBootstrapDatepicker = function() {

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
        var datepicker = function() {
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
        } else {}
    });
</script>

<script type="text/javascript">
    $(document).on("click", "#dateButton", function() {
        $("#dateModal").modal();
    });

    $(document).on("click", "#filterButton", function() {
        $("#filterModal").modal();
    });

    $(document).on("click", "#createButton", function() {
        $("#createModal").modal();
    });

    $(document).on("change", ".lastYear", function() {
        last_year = $(this).val();
        //   console.log(last_year);
        if (last_year == 0) {
            $(".lastYearDescription").hide();
        } else {
            $(".lastYearDescription").show();
        }
    });

    $(document).on("change", ".editLastYear", function() {
        last_year = $(this).val();
        console.log(last_year);
        if (last_year == 0) {
            $(".editLastYearDescription").hide();
        } else {
            $(".editLastYearDescription").show();
        }
    });


    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on("click", "#editButton", function() {
        let id = $(this).val();
        $.ajax({
            method: "GET",
            url: "{{ route('journal.journal.index') }}/" + id + "/edit"
        }).done(function(response) {
            console.log(response);
            $("#skpdId option[value=\"" + response.skpd_id + "\"]").attr("selected", true);
            $("#date").val(response.date);
            $("#description").text(response.description);
            $(".editLastYear option[value=\"" + response.last_year + "\"]").attr("selected", true);
            $(".editLastYearDescriptionValue").text(response.last_year_description);
            $("#evidance").val(response.evidance);
            $("#value").val(formatRupiah(response.value, ''));
            getSkpdAccount(response.skpd_id, response.account_id);
            if (response.last_year == 0) {
                $(".editLastYearDescription").hide();
            } else {
                $(".editLastYearDescription").show();
            }
            $("#editForm").attr("action", "{{ route('journal.journal.index') }}/" + id)
            $("#editModal").modal();
        })
    });

    $(document).on("click", "#deleteButton", function() {
        let id = $(this).val();
        $("#deleteForm").attr("action", "{{ route('journal.journal.index') }}/" + id)
        $("#deleteModal").modal();
    });

    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>

<script>
    $(".input-number").on("keypress", function(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    });

    function inputmaskCurrencyInit() {
        Inputmask.extendAliases({
            'numeric': {
                "prefix": "",
                "digits": 0,
                "rightAlign": false,
                "digitsOptional": false,
                "decimalProtect": true,
                "groupSeparator": ".",
                "radixPoint": ",",
                "radixFocus": true,
                "autoGroup": true,
                "autoUnmask": true,
                "removeMaskOnSubmit": true
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

    $(document).on("change", ".skpd-select-input", function() {
        skpd_id = $(this).val();
        if (skpd_id != 0) {
            getSkpdAccount(skpd_id, 0);
        } else {
            $(".skpd-account-select-input").html("<option value=\"0\">Pilih skpd terlebih dahulu</option>");
            $(".skpd-account-select-input").attr("disabled", true);
        }
    });

    function getSkpdAccount(skpd_id, account_id) {
        $(".skpd-account-select-input").html("<option value=\"0\">Loading...</option>")
        $(".skpd-account-select-input").attr("disabled", true);
        $.ajax({
            method: "POST",
            url: "/journal/journal/get-skpd-akun",
            data: {
                skpd_id: skpd_id,
                _token: "{{ csrf_token() }}"
            }
        }).done(function(response) {
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
