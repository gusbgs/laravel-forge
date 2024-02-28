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

        .card.card-custom > .card-body {
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

        .card.card-custom > .card-header-value .card-title {
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
        <div class="col-4">
            <div class="card card-custom mt-8 mb-8">
                <form id="journalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Skpd</label>
                            <select name="skpd_id" class="form-control skpd-select-input selectpicker"
                                    data-live-search="true" required id="skpd-select">
                                <option value="-">Pilih salah satu</option>
                                @foreach ($skpd as $skp)
                                    <option value="{{ $skp->id }}">
                                        {{ $skp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Akun</label>
                            <select name="account_id"
                                    class="form-control skpd-account-select-input js-example-basic-single" id="account-select"
                                    style="width: 100%; height: 100%;" disabled required>
                                <option value="0">Pilih skpd terlebih dahulu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" name="date" class="form-control" id="displayed_date">
                        </div>
                        <div class="form-group">
                            <label for="">No Bukti</label>
                            <input type="text" name="evidance" placeholder="Masukkan nomor bukti"
                                   class="form-control input-number" onpaste="return false;"
                                   ondrop="return false;"
                                   autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">Uraian</label>
                            <textarea name="description" placeholder="Masukkan uraian"
                                      class="form-control"></textarea>
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
                            <textarea name="last_year_description" placeholder="Masukkan keterangan"
                                      class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Apakah nilai mengandung sen?</label>
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="radioValue" class="radio-value" value="iya"
                                           checked>
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
                                <input type="text" name="value1" placeholder="Masukkan nilai"
                                       class="form-control masking2 form-control-lg" onpaste="return false;"
                                       ondrop="return false;"
                                       autocomplete="off">
                            </div>
                            <div class="input-value d-none">
                                <input type="text" name="value2" placeholder="Masukkan nilai"
                                       class="form-control form-control-lg input-currency" onpaste="return false;"
                                       ondrop="return false;" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row gy-3">
                            <div class="col-12">
                                <button type="submit" id="submitJournalForm"
                                        class="btn btn-lg btn-success w-100 mb-3">Tambah Jurnal (Enter)
                                </button>
                            </div>
                            <div class="col-12">
                                <button type="button"
                                        class="btn btn-outline p-4 btn-outline btn-outline-secondary text-dark btn-active-light-secondary w-100" onclick="resetForm()">Kosongkan Form (Del)
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-custom mt-8">
                <div class="card-header py-6">
                    <div class="card-toolbar">
{{--                        <h6>Daftar Jurnal Yang Anda Tambahkan & Belum Diverifikasi</h6>--}}
                        <input type="text" name="input_date" value="" id="kt_datepicker_day_2"
                               class="form-control"
                               readonly placeholder="Pilih Tanggal" autocomplete="off"/>
                    </div>
                    <div class="card-toolbar">
                        <!-- Tombol Bulk Edit -->
                        <a href="#" class="btn btn-outline-primary font-weight-bolder mr-2" id="bulkEditButton">
                            <i class="fa fa-edit"></i>Bulk Edit
                        </a>
                        <!-- Tombol Simpan -->
                        <a href="#" class="btn btn-success font-weight-bolder mr-2" id="saveButton"
                           style="display: none">
                            <i class="fa fa-save"></i>Simpan
                        </a>


                        <button type="button" class="btn btn-outline-danger font-weight-bolder mr-2"
                                id="bulkDeleteButton">Bulk
                            Delete
                        </button>

                        <button type="button" class="btn btn-danger font-weight-bolder mr-2" id="hapusButton"
                                style="display: none;">Hapus
                        </button>
                        <!-- Tombol Batalkan -->
                        <a href="#" class="btn btn-outline-light font-weight-bolder mr-2" id="discardButton"
                           style="display: none">
                            <i class="fa fa-undo"></i>Batalkan
                        </a>
                        <button type="button" class="btn btn-danger font-weight-bolder mr-2" id="discardButton_Edit"
                                style="display: none;">Batalkan Edit
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="tab-content">
{{--                        <div class="row mx-4">--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="skpdFilter" class="col-form-label">Filter Laporan :</label>--}}
{{--                                <div class="card-toolbar">--}}
{{--                                    <script>--}}

{{--                                    </script>--}}
{{--                                 --}}
{{--                                    <!-- Tombol "Tampilkan Data" tidak perlu ada -->--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="tab-pane fade show active" id="kt_tab_pane_5_1" role="tabpanel"
                             aria-labelledby="kt_tab_pane_5_1">
                            <div class="table-responsive">

                                {!! $dataTableJournal->table(['id' => 'journal-table', 'class' => 'table
                                table-bordered']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::CardTable-->

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
                                @foreach($skpd as $item)
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
                            <textarea name="description" placeholder="Masukkan uraian" class="form-control"
                                      id="description"></textarea>
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
                                <input type="text" name="value1" placeholder="Masukkan nilai"
                                       class="form-control masking2"
                                       onpaste="return false;" ondrop="return false;" autocomplete="off">
                            </div>
                            <div class="edit-input-value d-none">
                                <input type="text" name="value2" placeholder="Masukkan nilai"
                                       class="form-control input-currency" onpaste="return false;"
                                       ondrop="return false;"
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

    <!--begin::Modal Delete Bulk-->
    <div class="modal fade" id="deleteModalBulk">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title text-white">Apakah Anda yakin ingin menghapus data yang dipilih?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" id="deleteModalBulk_Hapus" class="btn btn-outline-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal Delete-->

@endsection

@section('modal')

@endsection

@section('script')
    {!! $dataTableJournal->scripts() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        $(document).keydown(function(e){
            if (e.which == 46) {
                resetForm();
                return false;
            }
        });

        $(document).ready(function () {

            var table = $('.dataTable').DataTable();

            // Setup datepicker
            $('#kt_datepicker_day_2').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd" // Ubah format ke "yyyy-mm-dd"
            });
            var selectedDates = $('#kt_datepicker_day_2').val();
            table.column(1).search(selectedDates).draw();

            // Ketika tanggal berubah
            $('#kt_datepicker_day_2').on('change', function () {
                var selectedDate = $('#kt_datepicker_day_2').val();
                // Validasi tanggal yang dipilih
                if (selectedDate === '') {
                    return;
                }
                // Cari dan gambar tabel sesuai tanggal yang dipilih
                table.column(1).search(selectedDate).draw();
                $('#filtered_date').val(selectedDate);
                $('#displayed_date').val(selectedDate);
            });

        });
        {{--function onChangeDate(x)--}}
        {{--{--}}
        {{--    var table = $('#journal-table').DataTable();--}}
        {{--    var selectedDate =  x.value;--}}
        {{--    // alert(selectedDate);--}}
        {{--    // console.log(selectedDate);--}}
        {{--    // Ketika tanggal berubah--}}
        {{--    // var selectedDate = $('#kt_datepicker_day_2').val();--}}

        {{--    // Validasi tanggal yang dipilih--}}
        {{--    if (selectedDate === '') {--}}
        {{--        return;--}}
        {{--    }--}}

        {{--    // Cari dan gambar tabel sesuai tanggal yang dipilih--}}
        {{--    table.column(1).search(selectedDate).draw();--}}
        {{--    $('#filtered_date').val(selectedDate);--}}
        {{--    $('#displayed_date').val(selectedDate);--}}

        {{--    //Kirim permintaan AJAX untuk memfilter data berdasarkan tanggal yang dipilih--}}
        {{--    --}}{{--$.ajax({--}}
        {{--    --}}{{--    url: '{{ route('journal.getJournals') }}',  //Ganti dengan URL yang sesuai--}}
        {{--    --}}{{--    type: 'POST',--}}
        {{--    --}}{{--    data: {--}}
        {{--    --}}{{--        date: selectedDate,--}}
        {{--    --}}{{--        _token: '{{ csrf_token() }}'  //Ganti dengan token CSRF Anda--}}
        {{--    --}}{{--    },--}}
        {{--    --}}{{--    success: function (data) {--}}
        {{--    --}}{{--        //reload data dalam tabel--}}
        {{--    --}}{{--        table.clear().rows.add(data).draw();--}}

        {{--    --}}{{--        // window.LaravelDataTables["journal-table"].ajax.reload(function (--}}
        {{--    --}}{{--        //     json) {});--}}
        {{--    --}}{{--    }--}}
        {{--    --}}{{--});--}}
        {{--}--}}
        $(document).ready(function () {
            var bulkEditActive = false;
            var editBulkData = {}



            function fnCreateTextBox(value, fieldprop, id, column) {

                if(column == "description"){

                    return '<textarea name="description" id="' + column + '' + id + '" style="width:200px !important; " placeholder="Masukkan uraian" class="form-control">'+ value +'</textarea>'

                }else{
                    var data = value.replace(/Rp|[.]|\s+/gi, "")
                    return '<input class="form-control masking2" style="width:200px !important; data-field="' + fieldprop + '" id="' + column + '' + id + '" type="number" value="' + data.replace(/[,]/gi, '.') + '" ></input>';
                }

            }

            function insertEditDataToArray(id, column, value) {
                if (typeof editBulkData[id] != "undefined") {
                    editBulkData[id][column] = value
                } else {
                    editBulkData[id] = {}; // create parent

                    editBulkData[id][column] = value
                }

                // console.log(editBulkData)

            }

            // Handle Bulk Edit Button Click
            $('#bulkEditButton').click(function () {
                bulkEditActive = !bulkEditActive;
                $('.editable').css('font-weight', 'bold')
                var dt = $('#journal-table').DataTable()
                dt.on('click', 'tbody td.editable', function (e) {

                    if ($(this).hasClass('text') && !$(this).hasClass('edrede') && bulkEditActive) {
                        var id = dt.row(this).id()

                        var columns = dt.settings().init().columns;
                        var colIndex = dt.cell(this).index().column;

                        var nameOfSelectedColumn = columns[colIndex].name;

                        var html = fnCreateTextBox($(this).html(), 'editable_field', id, nameOfSelectedColumn);

                        $(this).html($(html))
                        $(this).addClass('edrede');

                        $('#' + nameOfSelectedColumn + '' + id).on('change', function (e) {
                            var daval = $('#' + nameOfSelectedColumn + '' + id).val() // value
                            insertEditDataToArray(id, nameOfSelectedColumn, daval)
                        })
                    }
                });


                // Menampilkan atau menyembunyikan input untuk edit
                $('#journal-table .bulk-edit-evidance').prop('disabled', !bulkEditActive);
                $('#journal-table .bulk-edit-description').prop('disabled', !bulkEditActive);
                $('#journal-table .bulk-edit-value').prop('disabled', !bulkEditActive);

                // Menampilkan atau menyembunyikan tombol "Simpan" dan "Batalkan"
                if (bulkEditActive) {
                    $('#saveButton').show();
                    $('#discardButton_Edit').show();
                    $('#bulkEditButton').hide();

                    $('#discardButton').hide();
                    $('#bulkDeleteButton').hide();
                    $('#hapusButton').hide();
                    $('#discardButton_Edit').show();
                } else {
                    $('#saveButton').hide();
                    $('#discardButton_Edit').hide();
                }
            });

            // Handle Discard Button Click
            $('#discardButton_Edit').click(function () {
                bulkEditActive = false;
                editBulkData = {}
                $('#discardButton_Edit').hide();
                $('#saveButton').hide();

                $('#bulkDeleteButton').show();
                $('#bulkEditButton').show();
                window.LaravelDataTables["journal-table"].ajax.reload(
                    function (json) {
                    });
            });

            // Handle Save Button Click
            $('#saveButton').click(function () {
                bulkEditActive = false;

                if (Object.keys(editBulkData).length === 0) {
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
                        title: 'Belum ada data yang di ubah.'
                    });
                    return;
                }

                $("#saveModalBulk").modal();


                // Dapatkan data yang telah diubah
                // var updatedData = [];
                // $('#journal-table tbody tr').each(function () {
                //     var row = $(this);
                //     var id = row.data('id');
                //     var evidance = row.find('.bulk-edit-evidance').val();
                //     var description = row.find('.bulk-edit-description').val();
                //     var value = row.find('.bulk-edit-value').val();

                //     updatedData.push({
                //         id: id,
                //         evidance: evidance,
                //         description: description,
                //         value: value,
                //     });
                // });

                // Kirim data yang diubah ke server dengan permintaan Ajax

            });

            $('#saveModalBulk_Simpan').click(function () {
                console.log(JSON.stringify(editBulkData))
                $.ajax({
                    url: "{{ route('journal.updateBulk') }}",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        data: JSON.stringify(editBulkData),
                    },
                    success: function (response) {
                        // Tindakan setelah pembaruan data berhasil
                        $("#saveModalBulk").modal('hide');
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
                            icon: 'success',
                            title: response.message
                        });

                        bulkEditActive = false;
                        editBulkData = {}
                        $('#discardButton_Edit').hide();
                        $('#saveButton').hide();

                        $('#bulkEditButton').show();
                        $('#bulkDeleteButton').show();

                        window.LaravelDataTables["journal-table"].ajax.reload(
                            function (json) {
                            });
                    },
                    error: function (error) {
                        // Tindakan jika terjadi kesalahan
                        console.error('Terjadi kesalahan saat memperbarui data:', error);
                    }
                });
            })
        });


    </script>
    <script>
        $(document).ready(function () {
            // Handle Bulk Delete Click
            $('#bulkDeleteButton').click(function () {
                // Hide Bulk Delete Button and Show Hapus & Discard Buttons
                $('#bulkDeleteButton').hide();
                $('#saveButton').hide();
                $('#discardButton_Edit').hide();
                $('#bulkEditButton').hide();

                $('#hapusButton').show();
                $('#discardButton').show();

                var dt = $('#journal-table').DataTable()
                dt.column('bulkselec:name').visible(true);
                // Show checkboxes in each row
                $('.bulk-select').show();
                console.log(dt)

                // Handle all checkbox
                $('#select_all_deletes').click(function () {
                    if ($('#select_all_deletes').is(":checked")) {
                        $('.bulk-select').prop('checked', true);
                    } else {
                        $('.bulk-select').prop('checked', false);
                    }
                });
            });


            // Handle Discard Button Click
            $('#discardButton').click(function () {
                // Show Bulk Delete Button and Hide Hapus & Discard Buttons
                $('#bulkDeleteButton').show();
                $('#hapusButton').hide();
                $('#discardButton').hide();
                $('#saveButton').hide();
                $('#bulkEditButton').show();

                // Hide checkboxes in each row
                // $('.bulk-select').hide();
                var dt = $('#journal-table').DataTable()
                dt.column('bulkselec:name').visible(false);

                // Uncheck all checkboxes
                $('.bulk-select').prop('checked', false);
            });

            // Handle Checkbox Header Click
            $('#selectAllCheckbox').click(function () {
                var isChecked = $(this).prop('checked');

                $('.bulk-select').each(function () {
                    $(this).prop('checked', isChecked);
                });
            });

            // Handle Hapus Button Click
            $('#hapusButton').click(function () {
                var selectedIds = [];

                $('.bulk-select:checked').each(function () {
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
                        title: 'Pilih setidaknya satu data untuk dihapus.'
                    });
                    return;
                }
                $("#deleteModalBulk").modal();

            });


            $('#deleteModalBulk_Hapus').click(function () {
                var selectedIds = [];
                $('.bulk-select:checked').each(function () {
                    var id = $(this).data('id');
                    selectedIds.push(id);
                });
                console.log(selectedIds)
                $.ajax({
                    url: '{{ route("journal.deleteBulk") }}', // Ganti dengan URL penghapusan data Anda
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),

                        selectedIds: selectedIds
                    },
                    success: function (response) {
                        // Tindakan setelah penghapusan data berhasil
                        console.log(response.old_data);
                        $("#deleteModalBulk").modal('hide');
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
                            icon: 'success',
                            title: response.message
                        });

                        // Show Bulk Delete Button and Hide Hapus & Discard Buttons
                        $('#bulkDeleteButton').show();
                        $('#bulkEditButton').show();
                        $('#hapusButton').hide();
                        $('#discardButton').hide();

                        // Hide checkboxes in each row
                        // $('.bulk-select').hide();
                        var dt = $('#journal-table').DataTable()
                        dt.column('bulkselec:name').visible(false);

                        // Uncheck all checkboxes
                        $('.bulk-select').prop('checked', false);
                        // Muat ulang tabel atau lakukan tindakan lain yang diperlukan
                        window.LaravelDataTables["journal-table"].ajax.reload(
                            function (json) {
                            });
                    },
                    error: function (error) {
                        // Tindakan jika terjadi kesalahan
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
                            title: error
                        });
                    }
                });
            });
        });

    </script>
    <script type="text/javascript">
        function resetForm(){
            document.getElementById("journalForm").reset();
            // $("#skpd-select").select2({
            //     placeholder: "Select a State",
            //     allowClear: true
            // });
            // $("#skpd-select").select2({
            //     placeholder: "Select a State",
            //     allowClear: true
            // });

            $('#skpd-select').val("-");
            $('#skpd-select').trigger("change");
            $('#skpd-select').select2("focus");

            const Toasts = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal
                        .resumeTimer)
                }

            });

            Toasts.fire({
                icon: 'success',
                title: 'Form berhasil dikosongkan'
            });

            $('#account-select').select2("val","");
            // $('#account-select').empty('').trigger('change');
            // $('#skpd-select').empty('').trigger('change');
        }

        // SETUP FILTER POSITION
        $(document).ready(function () {
            var table = $('.dataTable').DataTable();

            $('#skpdFilter').select2();

            $('#skpdFilter').on('change', function () {
                var selectedSkpd = $(this).val();
                var selectedSkpdId = $(this).find(':selected').data('skpd-id');
                table.column(9).search(selectedSkpd)
                    .draw(); // Mengubah angka kolom menjadi 3 untuk pencarian berdasarkan jabatan
            });
        });

        {{--$(document).ready(function () {--}}
        {{--    var table = $('#journal-table').DataTable();--}}
        {{--    var datePicker = $('#kt_datetimepicker_1');--}}

        {{--    datePicker.datetimepicker({--}}
        {{--        format: 'YYYY-MM-DD',--}}
        {{--    });--}}

        {{--    datePicker.on('dp.change', function (e) {--}}
        {{--        var selectedDate = e.date.format('YYYY-MM-DD');--}}

        {{--        console.log(selectedDate);--}}

        {{--         Kirim permintaan AJAX untuk memfilter data berdasarkan tanggal yang dipilih--}}
        {{--        $.ajax({--}}
        {{--            url: '{{ route('journal.getJournals') }}',  Ganti dengan URL yang sesuai--}}
        {{--            type: 'POST',--}}
        {{--            data: {--}}
        {{--                date: selectedDate,--}}
        {{--                _token: '{{ csrf_token() }}'  Ganti dengan token CSRF Anda--}}
        {{--            },--}}
        {{--            success: function (data) {--}}
        {{--                 Reload data dalam tabel--}}
        {{--                table.clear().rows.add(data).draw();--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}

        $(document).ready(function () {
            $("#submitJournalForm").click(function (e) {
                e.preventDefault();

                // Serialize form data
                var formData = new FormData($("#journalForm")[0]);

                formData.append('_token', '{{ csrf_token() }}');
                console.log(formData);
                $.ajax({
                    url: "{{ route('journal.journal.store') }}",
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        // Handle success response
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        });

                        if (response.success) {
                            $('#formModal').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            // document.getElementById("journalForm").reset();
                            // Reload data using Laravel DataTables
                            window.LaravelDataTables["journal-table"].ajax.reload(function (
                                json) {
                            });
                        }
                    },
                    error: function (err) {
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
                            title: err.responseJSON.message
                        });
                    }
                });
            });
        });

    </script>

    <script type="text/javascript">
        $("#tombolForgetPassword").on("click", function () {
            $("#modalForgetPassword").modal();
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.radio-value').on('click', function () {
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

            $('.edit-radio-value').on('click', function () {
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
                init: function () {
                    datepicker();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTBootstrapDatepicker.init();
        });

        document.getElementById('checkFilterType').addEventListener('change', function () {
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
        $(document).on("click", "#dateButton", function () {
            $("#dateModal").modal();
        });

        $(document).on("click", "#filterButton", function () {
            $("#filterModal").modal();
        });

        $(document).on("click", "#createButton", function () {
            $("#createModal").modal();
        });

        $(document).on("change", ".lastYear", function () {
            last_year = $(this).val();
            //   console.log(last_year);
            if (last_year == 0) {
                $(".lastYearDescription").hide();
            } else {
                $(".lastYearDescription").show();
            }
        });

        $(document).on("change", ".editLastYear", function () {
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

        $(document).on("click", "#editButton", function () {
            let id = $(this).val();
            $.ajax({
                method: "GET",
                url: "{{ route('journal.journal.index') }}/" + id + "/edit"
            }).done(function (response) {
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
                $("#editForm").on("submit", function (e) {
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
                        success: function (response) {
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
                                window.LaravelDataTables["journal-table"].ajax.reload(
                                    function (json) {
                                    });
                            }
                        },
                        error: function (err) {
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

        $(document).on("click", "#deleteButton", function () {
            let id = $(this).val();
            $("#deleteForm").attr("action", "{{ route('journal.journal.index') }}/" + id);

            // Menambahkan event handler untuk tombol "Simpan"
            $("#deleteForm").on("submit", function (e) {
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
                    success: function (response) {
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

                            // Reload data using Laravel DataTables
                            window.LaravelDataTables["journal-table"].ajax.reload(
                                function (json) {
                                });
                        }
                    },
                    error: function (err) {
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

        $(document).ready(function () {
            $('#table_id').DataTable();
        });

    </script>

    <script>
        $(".input-number").on("keypress", function (evt) {
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

        $(document).on("change", ".skpd-select-input", function () {
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
            }).done(function (response) {
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

        $(document).ready(function () {
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

        var menu_link_4 = document.getElementById("menu_journal_create");
        menu_link_4.classList.add("menu-item-active");

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function (e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };

    </script>

@endsection
