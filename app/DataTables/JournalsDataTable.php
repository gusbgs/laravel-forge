<?php

namespace App\DataTables;

use App\Journal;
use Carbon\Carbon;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Auth;

class JournalsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)->setRowId(function (Journal $journal) {
                return $journal->id;
            })
            ->addColumn('aksi', function (Journal $journal) {
                $button = '';

                // if (auth()->user()->can('ubah jurnal')) {
                // $button .= '<a href="javascript:void(0)" class="btn btn-sm btn-warning edit-journal" data-journal-id="' . $journal->id . '"><i class="fa fa-edit"></i></a>';

                // if (Auth::user()->role->journals_edit == 1){
                $button .= '<button type="button" class="btn btn-warning btn-xs" value="' . $journal->id . '" id="editButton" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit"></i></button>';

                $button .= '<button type="button" class="btn btn-danger btn-xs" value="' . $journal->id . '" id="deleteButton" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash"></i></button>';

                // }
                // }

                // if (auth()->user()->can('hapus jurnal')) {
                // $button .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                // }

                return $button;
            })
            ->addColumn('select', function (Journal $journal) {
                return '<input type="checkbox" class="bulk-select" data-id="' . $journal->id . '" style="display: none;">';
            })
            ->addColumn('id', function (Journal $journal) {
                $i = 2;
                return $i++;
            })
            //            ->addColumn('date', function (Journal $journal) {
//                //return '<input type="text" name="evidance" disabled class="bulk-edit-evidance" value="' . $journal->evidance . '">';
//                return Carbon::parse($journal->date)->format('d-m-Y');
//            })
            ->addColumn('evidance', function (Journal $journal) {
                //return '<input type="text" name="evidance" disabled class="bulk-edit-evidance" value="' . $journal->evidance . '">';
                return $journal->evidance;
            })
            ->addColumn('description', function (Journal $journal) {
                //return '<input type="text" name="description" disabled class="bulk-edit-description" value="' . $journal->description . '">';
                return $journal->description;
            })
            //            ->addColumn('value', function (Journal $journal) {
//                //return '<input type="text" name="value" disabled class="bulk-edit-value" value="' . $journal->value . '">';
//                return number_format($journal->value, '0',',','.');
//            })
            ->addColumn('last_year', function (Journal $journal) {
                //return '<input type="text" name="value" disabled class="bulk-edit-value" value="' . $journal->value . '">';
                $status = $journal->last_year == 1 ? 'Ya' : 'Tidak';
                //                $color = $journal->last_year == 1 ? 'success' : 'danger';
//                $badge = "<span class='badge badge-". $color ."'>" . $status . "</span>";
                return $status;
            })
            ->addColumn('value', function (Journal $journal) {
                $value = $journal->value;
                $numericValue = preg_replace('/[^0-9.]/', '', $value);
                if (strpos($numericValue, '.') !== false) {
                    $formattedValue = 'Rp. ' . number_format((float) $numericValue, 2, ',', '.');
                } else {
                    $formattedValue = 'Rp. ' . number_format((int) $numericValue, 0, ',', '.');
                }

                return $formattedValue;


            })


            ->rawColumns(['aksi', 'select', 'evidance', 'description']);
    }

    public function query(Journal $journal)
    {
        $query = $journal->newQuery()
            ->select(
                'journals.id',
                db::raw("DATE_FORMAT(journals.date, '%d-%m-%Y') as date"),
                //            'journals.date',
                'journals.evidance',
                'journals.description',
                'journals.value',
                'journals.last_year_description',
                'accounts.number as account_number',
                'accounts.name as account_name',
                DB::raw('CASE WHEN journals.last_year = 1 THEN journals.last_year ELSE NULL END as last_year'),
                DB::raw('CASE WHEN journals.last_year = 0 THEN journals.last_year ELSE NULL END as current_year'),
                'skpd.name as skpd',
                db::raw("DATE_FORMAT(journals.created_at, '%d-%m-%Y %H:%i:%s') as time")
            )
            ->leftJoin('skpd', 'journals.skpd_id', '=', 'skpd.id')
            ->leftJoin('accounts', 'journals.account_id', '=', 'accounts.id');

        $year = Auth::user()->year; // Ambil tahun dari user yang sedang login

        // Filter data berdasarkan tahun yang diperoleh dari Auth::user()
        $query->whereYear('journals.date', $year);
        //        $query->whereDate('journals.date', date('d'));
        $query->orderByDesc('date');
        $query->where('journals.user_id', Auth::user()->id);
        //        // Logika untuk memfilter berdasarkan Auth::user()->role
//        if (Auth::user()->role->all_users_data == 0) {
//
//        }

        return $query;
    }

    public function html()
    {
        // $columnsArrExPr = [0, 1, 2, 3];
        return $this->builder()
            ->setTableId('journal-table') // Ubah 'journals-table' menjadi 'journal-table'
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                // 'order' => [[1, 'asc']],
                'responsive' => true,
                'autoWidth' => true,
                'dom' => 'lBfrtip',
                'lengthMenu' => [
                    [-1],
                    ['Semua Data']
                ],
                'order' => [
                    10,
                    // here is the column number
                    'desc'
                ]
                // 'buttons' => $this->buttonDatatables($columnsArrExPr),
            ]);
    }

    protected function getColumns()
    {
        return [
            //            ['data' => 'id', 'title' => 'No.', 'orderable' => false, 'searchable' => false, 'render' => function () {
//                return 'function(data,type,fullData,meta){return meta.settings._iDisplayStart+meta.row+1;}';
//            }],

            ['data' => 'select', 'class' => 'bulk-select', 'title' => '<input type="checkbox" id="select_all_deletes" />', 'name' => 'bulkselec', 'orderable' => false, 'width' => '110px', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'visible' => false],
            ['data' => 'date', 'name' => 'date', 'title' => 'Tanggal', 'orderable' => true],
            ['data' => 'evidance', 'name' => 'evidance', 'title' => 'No. Bukti', 'class' => 'editable text'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Uraian', 'class' => 'editable text'],
            ['data' => 'skpd', 'name' => 'skpd.name', 'title' => 'SKPD'],
            ['data' => 'account_number', 'name' => 'accounts.number', 'title' => 'No. Akun'],
            ['data' => 'account_name', 'name' => 'accounts.name', 'title' => 'Akun'],
            ['data' => 'value', 'name' => 'value', 'title' => 'Nilai', 'class' => 'editable text w-150px', 'orderable' => true, 'width' => '150px'],


            ['data' => 'last_year', 'name' => 'last_year', 'title' => 'Tahun Kemarin ?', 'orderable' => false],
            ['data' => 'last_year_description', 'name' => 'last_year_description', 'title' => 'Ket. Tahun Lalu'],
            //            ['data' => 'current_year', 'name' => 'last_year', 'title' => 'Tahun Berjalan'],

            ['data' => 'time', 'title' => 'Waktu di Tambahkan', 'searchable' => false, 'orderable' => true],
            ['data' => 'aksi', 'title' => 'Aksi', 'width' => '110px', 'orderable' => false, 'searchable' => false, 'exportable' => false],
        ];
    }


}
