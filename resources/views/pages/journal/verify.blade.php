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

    <!--begin::CardTable-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <select name="tahun" id="tahun" class="form-control form-control-lg">
                                @for ($i = 20; $i < 30; $i++)
                                    <option @if ($tahun == '20' . $i) selected @endif value="20{{ $i }}">
                                        20{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="bulan" id="bulan" class="form-control form-control-lg">
                                <option @if ($bulan == 1) selected @endif value="1">Januari</option>
                                <option @if ($bulan == 2) selected @endif value="2">Februari</option>
                                <option @if ($bulan == 3) selected @endif value="3">Maret</option>
                                <option @if ($bulan == 4) selected @endif value="4">April</option>
                                <option @if ($bulan == 5) selected @endif value="5">Mei</option>
                                <option @if ($bulan == 6) selected @endif value="6">Juni</option>
                                <option @if ($bulan == 7) selected @endif value="7">Juli</option>
                                <option @if ($bulan == 8) selected @endif value="8">Agustus</option>
                                <option @if ($bulan == 9) selected @endif value="9">September</option>
                                <option @if ($bulan == 10) selected @endif value="10">Oktober</option>
                                <option @if ($bulan == 11) selected @endif value="11">November</option>
                                <option @if ($bulan == 12) selected @endif value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary" type="submit" id="tampispesifik">Tampilkan Jurnal</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-custom mt-8">
                <div class="card-header py-6">
                    <div class="card-toolbar">
                        <h3>Daftar Jurnal Yang Anda Tambahkan & Belum Diverifikasi</h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-outline-info font-weight-bolder mr-2"
                            id="checkSemuaJurnal">Pilih Semua Jurnal
                        </button>
                        <button type="button" class="btn btn-outline-success font-weight-bolder mr-2"
                            id="verifikasiJurnal">Verifikasi Jurnal
                        </button>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="table-responsive p-5">
                        <table class="table gy-5 gs-7 border rounded" id="kt_datatable_dom_positioning">
                            <thead>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>No.Bukti</td>
                                    <td>Uraian</td>
                                    <td>Ket.Tahun Lalu</td>
                                    <td>No.Akun</td>
                                    <td>Akun</td>
                                    <td>Tahun Kemarin ? </td>
                                    <td>SKPD</td>
                                    <td>Nilai</td>
                                    <td>Waktu & User Yang Menambahkan</td>
                                    <td>Pilih</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($journals as $journal)
                                    <tr>
                                        <td>{{ $journal->date }}</td>
                                        <td>{{ $journal->evidance }}</td>
                                        <td>{{ $journal->description }}</td>
                                        <td>{{ $journal->last_year_description ?? '-' }}</td>
                                        <td>{{ $journal->account->number }}</td>
                                        <td>{{ $journal->account->name }}</td>
                                        <td>{{ $journal->last_year == 0 ? 'TIDAK' : 'YA' }}</td>
                                        <td>{{ $journal->skpd->name }}</td>
                                        @php
                                            $value = $journal->value;
                                            if (strpos($value, '.') !== false) {
                                                $formattedValue = number_format($value, 2, ',', '.');
                                            } else {
                                                $formattedValue = number_format($value, 0, ',', '.');
                                            }
                                        @endphp

                                        <td>Rp. {{ $formattedValue }}</td>
                                        <td><span class="badge badge-primary">{{ $journal->user->name }}
                                                -{{ \Carbon\Carbon::parse($journal->created_at)->format('d M Y h:i:s') }}</span>
                                        </td>
                                        <td>
                                            @if ($journal->verify_at)
                                                <span class="badge badge-success">Terverifikasi  - {{ \Carbon\Carbon::parse($journal->verify_at)->format('d M Y H:i:s') }}</span>
                                            @else
                                                <input type="checkbox" class="form-control form-check checkveri"
                                                    data-id="{{ $journal->id }}">
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$journal->verify_at)
                                                @if (Auth::user()->role->journals_edit == 1)
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        value="{{ $journal->id }}" id="editButton" data-toggle="tooltip"
                                                        data-placement="bottom" title="" data-original-title="Edit"
                                                        title="Edit"><i class="fa fa-edit"></i></button>
                                                @endif
                                                @if (Auth::user()->role->journals_delete == 1)
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        value="{{ $journal->id }}" id="deleteButton" data-toggle="tooltip"
                                                        data-placement="bottom" title=""
                                                        data-original-title="Hapus"><i class="fa fa-trash"></i></button>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::CardTable-->

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
                        @method('DELETE')
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali
                        </button>
                        <button type="submit" class="btn btn-outline-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal Delete-->

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
                            <select name="skpd_id" class="form-control skpd-select-input selectpicker"
                                data-live-search="true" id="skpdId" required>
                                @foreach ($skpd as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Akun</label>
                            <select name="account_id"
                                class="form-control skpd-account-select-input js-example-basic-single"
                                style="width: 100%; height: 100%;" id="accountId" disabled required>
                                <option value="0">Pilih skpd terlebih dahulu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" name="date" class="form-control" id="date" required>
                        </div>
                        <div class="form-group">
                            <label for="">No Bukti</label>
                            <input type="text" name="evidance" placeholder="Masukkan nomor bukti"
                                class="form-control input-number" id="evidance" onpaste="return false;"
                                ondrop="return false;" autocomplete="off" required>
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
                            <textarea name="last_year_description" placeholder="Masukkan keterangan"
                                class="form-control editLastYearDescriptionValue"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Nilai Sebelumnya</label>
                            <input type="text" placeholder="Masukkan nilai" class="form-control" id="value"
                                onpaste="return false;" ondrop="return false;"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');"
                                autocomplete="off" readonly>
                        </div>
                        <div class="form-group">
                            <label>Apakah nilai baru mengandung sen?</label>
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="radioValue" class="edit-radio-value" value="iya"
                                        checked>
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
                                <input type="text" name="value1" placeholder="Masukkan nilai"
                                    class="form-control masking2" onpaste="return false;" ondrop="return false;"
                                    autocomplete="off">
                            </div>
                            <div class="edit-input-value d-none">
                                <input type="text" name="value2" placeholder="Masukkan nilai"
                                    class="form-control input-currency" onpaste="return false;" ondrop="return false;"
                                    autocomplete="off">
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

    <!--begin::Modal Save Bulk Edit-->
    <div class="modal fade" id="saveModalBulk">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title text-white">Apa anda yakin ingin mengubah semua data?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" id="saveModalBulk_Simpan" class="btn btn-outline-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal Delete-->

    {{--    <!--begin::Modal Edit--> --}}
    {{--    <div class="modal fade" id="editModal"> --}}
    {{--        <div class="modal-dialog" role="document"> --}}
    {{--            <div class="modal-content"> --}}
    {{--                <div class="modal-header bg-primary white"> --}}
    {{--                    <h5 class="modal-title text-white">Edit Jurnal</h5> --}}
    {{--                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times; --}}
    {{--                    </button> --}}
    {{--                </div> --}}
    {{--                <form action="" id="editForm" method="post"> --}}
    {{--                    <div class="modal-body"> --}}
    {{--                        @csrf --}}
    {{--                        @method('PUT') --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Skpd</label> --}}
    {{--                            <select name="skpd_id" class="form-control skpd-select-input selectpicker" --}}
    {{--                                    data-live-search="true" id="skpdId" required> --}}
    {{--                                @foreach ($skpd as $item) --}}
    {{--                                    <option value="{{ $item->id }}">{{ $item->name }}</option> --}}
    {{--                                @endforeach --}}
    {{--                            </select> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Akun</label> --}}
    {{--                            <select name="account_id" --}}
    {{--                                    class="form-control skpd-account-select-input js-example-basic-single" --}}
    {{--                                    style="width: 100%; height: 100%;" id="accountId" disabled required> --}}
    {{--                                <option value="0">Pilih skpd terlebih dahulu</option> --}}
    {{--                            </select> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Tanggal</label> --}}
    {{--                            <input type="date" name="date" class="form-control" id="date" required> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">No Bukti</label> --}}
    {{--                            <input type="text" name="evidance" placeholder="Masukkan nomor bukti" --}}
    {{--                                   class="form-control input-number" id="evidance" onpaste="return false;" --}}
    {{--                                   ondrop="return false;" autocomplete="off" required> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Uraian</label> --}}
    {{--                            <textarea name="description" placeholder="Masukkan uraian" class="form-control" --}}
    {{--                                      id="description"></textarea> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Tahun kemarin?</label> --}}
    {{--                            <select name="last_year" class="form-control editLastYear" required> --}}
    {{--                                <option value="0">Tidak</option> --}}
    {{--                                <option value="1">Iya</option> --}}
    {{--                            </select> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group editLastYearDescription"> --}}
    {{--                            <label for="">Keterangan (tahun kemaren)</label> --}}
    {{--                            <textarea name="last_year_description" placeholder="Masukkan keterangan" --}}
    {{--                                      class="form-control editLastYearDescriptionValue"></textarea> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Nilai Sebelumnya</label> --}}
    {{--                            <input type="text" placeholder="Masukkan nilai" class="form-control" id="value" --}}
    {{--                                   onpaste="return false;" ondrop="return false;" --}}
    {{--                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');" --}}
    {{--                                   autocomplete="off" readonly> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label>Apakah nilai baru mengandung sen?</label> --}}
    {{--                            <div class="radio-inline"> --}}
    {{--                                <label class="radio"> --}}
    {{--                                    <input type="radio" name="radioValue" class="edit-radio-value" value="iya" checked> --}}
    {{--                                    <span></span> --}}
    {{--                                    Iya --}}
    {{--                                </label> --}}
    {{--                                <label class="radio"> --}}
    {{--                                    <input type="radio" name="radioValue" class="edit-radio-value" value="tidak"> --}}
    {{--                                    <span></span> --}}
    {{--                                    Tidak --}}
    {{--                                </label> --}}
    {{--                            </div> --}}
    {{--                        </div> --}}
    {{--                        <div class="form-group"> --}}
    {{--                            <label for="">Nilai Baru</label> --}}
    {{--                            <div class="edit-input-value-sen"> --}}
    {{--                                <input type="text" name="value1" placeholder="Masukkan nilai" --}}
    {{--                                       class="form-control masking2" --}}
    {{--                                       onpaste="return false;" ondrop="return false;" autocomplete="off"> --}}
    {{--                            </div> --}}
    {{--                            <div class="edit-input-value d-none"> --}}
    {{--                                <input type="text" name="value2" placeholder="Masukkan nilai" --}}
    {{--                                       class="form-control input-currency" onpaste="return false;" --}}
    {{--                                       ondrop="return false;" --}}
    {{--                                       autocomplete="off"> --}}
    {{--                            </div> --}}
    {{--                            <span class="text-danger">Kosongkan kolom jika tidak ingin mengubah nilai</span> --}}
    {{--                        </div> --}}
    {{--                    </div> --}}
    {{--                    <div class="modal-footer"> --}}
    {{--                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali --}}
    {{--                        </button> --}}
    {{--                        <button type="submit" class="btn btn-outline-primary">Simpan</button> --}}
    {{--                    </div> --}}
    {{--                </form> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <!--end::Modal Edit--> --}}

    {{--    <!--begin::Modal Delete--> --}}
    {{--    <div class="modal fade" id="deleteModal"> --}}
    {{--        <div class="modal-dialog" role="document"> --}}
    {{--            <div class="modal-content"> --}}
    {{--                <div class="modal-header bg-danger text-white"> --}}
    {{--                    <h4 class="modal-title text-white">Apa anda yakin ingin menghapus data ini?</h4> --}}
    {{--                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times; --}}
    {{--                    </button> --}}
    {{--                </div> --}}
    {{--                <form action="" id="deleteForm" method="post"> --}}
    {{--                    <div class="modal-footer"> --}}
    {{--                        @csrf --}}
    {{--                        @method("DELETE") --}}
    {{--                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali --}}
    {{--                        </button> --}}
    {{--                        <button type="submit" class="btn btn-outline-danger">Hapus</button> --}}
    {{--                    </div> --}}
    {{--                </form> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <!--end::Modal Delete--> --}}

    {{--    <!--begin::Modal Save Bulk Edit--> --}}
    {{--    <div class="modal fade" id="saveModalBulk"> --}}
    {{--        <div class="modal-dialog" role="document"> --}}
    {{--            <div class="modal-content"> --}}
    {{--                <div class="modal-header bg-success text-white"> --}}
    {{--                    <h4 class="modal-title text-white">Apa anda yakin ingin mengubah semua data?</h4> --}}
    {{--                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times; --}}
    {{--                    </button> --}}
    {{--                </div> --}}
    {{--                <div class="modal-footer"> --}}
    {{--                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button> --}}
    {{--                    <button type="submit" id="saveModalBulk_Simpan" class="btn btn-outline-primary">Ubah</button> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <!--end::Modal Delete--> --}}

    {{--    <!--begin::Modal Delete Bulk--> --}}
    {{--    <div class="modal fade" id="deleteModalBulk"> --}}
    {{--        <div class="modal-dialog" role="document"> --}}
    {{--            <div class="modal-content"> --}}
    {{--                <div class="modal-header bg-danger text-white"> --}}
    {{--                    <h4 class="modal-title text-white">Apakah Anda yakin ingin menghapus data yang dipilih?</h4> --}}
    {{--                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times; --}}
    {{--                    </button> --}}
    {{--                </div> --}}
    {{--                <div class="modal-footer"> --}}
    {{--                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button> --}}
    {{--                    <button type="submit" id="deleteModalBulk_Hapus" class="btn btn-outline-danger">Hapus</button> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{--    <!--end::Modal Delete--> --}}

@endsection

@section('script')
    <script>
        $("#kt_datatable_dom_positioning").DataTable({
            "bPaginate": false,
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
    <script>
        $(document).ready(function() {
            var checked = false
            $('#checkSemuaJurnal').click(function() {
                if (checked) {
                    checked = false
                } else {
                    checked = true
                }
                $('.checkveri').each(function() {
                    $(this).prop('checked', checked);
                });
            })

            $('#deleteButton').click(function() {
                $("#deleteForm").modal();
            })

            $('#tampispesifik').click(function() {
                var tahun = $('#tahun').val()
                var bulan = $('#bulan').val()
                window.location = '{{ route('journal.verifyJournal') }}?tahun=' + tahun + '&bulan=' +
                    bulan;
            })

            $('#verifikasiJurnal').click(function() {
                var selectedIds = [];

                $('.checkveri:checked').each(function() {
                    var id = $(this).data('id');
                    selectedIds.push(id);
                });

                if (selectedIds.length === 0) {
                    // alert('Pilih setidaknya satu data untuk dihapus.');
                    // Handle error response
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'Pilih setidaknya satu data untuk diverifikasi.'
                    });
                    return;
                }

                $("#saveModalBulk").modal();
            })

            $('#saveModalBulk_Simpan').click(function() {
                var selectedIds = [];

                $('.checkveri:checked').each(function() {
                    var id = $(this).data('id');
                    selectedIds.push(id);
                });

                $.ajax({
                    url: "{{ route('journal.verifyJournalStore') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        selectedIds: JSON.stringify(selectedIds)
                    },
                    success: function(response) {
                        // Tindakan setelah pembaruan data berhasil
                        window.location = window.location.href
                        // console.log(response.message)
                    },
                    error: function(error) {
                        // Tindakan jika terjadi kesalahan
                        console.error('Terjadi kesalahan saat memperbarui data:', error);
                    }
                });
            })
        })

        $(document).on("click", "#deleteButton", function() {
            let id = $(this).val();
            $("#deleteForm").attr("action", "{{ route('journal.journal.index') }}/" + id);

            // Menambahkan event handler untuk tombol "Simpan"
            $("#deleteForm").on("submit", function(e) {
                const formData = new FormData(this);

                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter',
                                    Swal.stopTimer);
                                toast.addEventListener('mouseleave',
                                    Swal.resumeTimer);
                            }
                        });

                        if (response.success) {
                            $('#deleteModal').modal('hide'); // Perbaikan ini
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });

                            location.reload();
                        }
                    },
                    error: function(err) {
                        // Handle error response
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter',
                                    Swal.stopTimer);
                                toast.addEventListener('mouseleave',
                                    Swal.resumeTimer);
                            }
                        });

                        Toast.fire({
                            icon: 'error',
                            title: err.responseJSON.message
                        });
                    }
                });
            });
            $("#deleteModal").modal();
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
                    $(".skpd-account-select-input").append("<option value=\"" + skpdAccount.account_id +
                        "\">" + skpdAccountName + "</option>");
                });

                if (account_id != 0) {
                    $(".skpd-account-select-input option[value=\"" + account_id + "\"]").attr("selected", true);
                }
                $(".skpd-account-select-input").attr("disabled", false)
            });
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
                $("#description").val(response.description);
                $(".editLastYear option[value=\"" + response.last_year + "\"]").attr("selected", true);
                $(".editLastYearDescriptionValue").val(response.last_year_description);
                $("#evidance").val(response.evidance);
                $("#value").val(formatRupiah(response.value, ''));
                getSkpdAccount(response.skpd_id, response.account_id);
                if (response.last_year == 0) {
                    $(".editLastYearDescription").hide();
                } else {
                    $(".editLastYearDescription").show();
                }
                $("#editForm").attr("action", "{{ route('journal.journal.index') }}/" + id);

                // Menambahkan event handler untuk tombol "Simpan"
                $("#editForm").on("submit", function(e) {
                    e.preventDefault(); // Mencegah reload halaman
                    const formData = new FormData(this);

                    $.ajax({
                        method: "POST",
                        url: $(this).attr("action"),
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer);
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer);
                                }
                            });

                            if (response.success) {
                                $('#editModal').modal('hide');
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });

                                // Reload data using Laravel DataTables
                                location.reload();
                            }
                        },
                        error: function(err) {
                            // Handle error response
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer);
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer);
                                }
                            });

                            Toast.fire({
                                icon: 'error',
                                title: err.responseJSON.message
                            });
                        }
                    });
                });

                // Tampilkan modal edit
                $("#editModal").modal();
            });
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

        var menu_link_4 = document.getElementById("menu_journal_verifikasi");
        menu_link_4.classList.add("menu-item-active");
    </script>
@endsection
