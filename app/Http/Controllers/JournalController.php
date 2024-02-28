<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SkpdAccount;
use App\Account;
use App\DataTables\JournalsDataTable;
use App\Journal;
use App\Skpd;
use Auth;
use DB;
use Yajra\DataTables\DataTables;
class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if (Auth::user()->role->journals_view == 0) {
        return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
      }

        $data['journal'] = [];
        $data['skpd_id'] = null;
        $data['skpd_name'] = null;
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['total'] = 0;
        $data['show_filter_date'] = $request->date;
        $data['realisasi_rekening'] = null;
        $data['realisasi_rekening_total'] = 0;
        $data['input_date'] = null;
        $data['realisasi_rekening'] = [];
        $data['skpd'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        $date = null;
        if(isset($_GET['date']))
        {
           $date = $_GET['date'] ;
        }

        $skpd_id = null;
        if(isset($_GET['skpd_id']))
        {
           $skpd_id = $_GET['skpd_id'] ;
        }
        if($date != null && $date != '')
        {
            $date = $_GET['date'];
            if($skpd_id != 'null' && $skpd_id != '')
            {
                $skpd_id = $_GET['skpd_id'];
                $split_format_date = explode("-", $date);
                 if(Auth::user()->role->all_users_data == 1)
                {
                    $data['journal'] = Journal::where('skpd_id', $skpd_id)
                        ->where(function($q) use($split_format_date, $date){
                            if(count($split_format_date) == 2)
                            {
                                $q->whereMonth('date', $split_format_date[1])->whereYear('date', $split_format_date[0]);
                            }
                            if(count($split_format_date) == 3)
                            {
                                $q->whereDate('date', $date);
                            }

                        })->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
                }
                else{
                    $data['journal'] = Journal::where('user_id', Auth::user()->id)->where('skpd_id', $skpd_id)
                        ->where(function($q) use($split_format_date, $date){
                            if(count($split_format_date) == 2)
                            {
                                $q->whereMonth('date', $split_format_date[1])->whereYear('date', $split_format_date[0]);
                            }
                            if(count($split_format_date) == 3)
                            {
                                $q->whereDate('date', $date);
                            }
                        })->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
                    // dd($data['journal']);
                }

                if(count($split_format_date) == 2)
                {
                    $data['show_filter_date'] = $this->getMonth($split_format_date[1]);
                }
                if(count($split_format_date) == 3)
                {
                    $data['show_filter_date'] = $split_format_date[2] . '-' . $this->getMonth($split_format_date[1]) . '-' . $split_format_date[0];
                }
                $data['skpd_id'] = $skpd_id;
                $data['skpd_name'] = Skpd::where('id', $skpd_id)->pluck('name')->first();
                $data['date'] = $date;

                $skpd_account = SkpdAccount::where('skpd_id', $skpd_id)->get();
                $realisasi_rekening = [];
                foreach($skpd_account as $item_1)
                {
                    $value = 0;
                    $array_realisasi_rekening = [];
                    array_push($array_realisasi_rekening, $item_1->account->name);
                    foreach($data['journal'] as $item_2)
                    {
                        if($item_1->account_id == $item_2->account_id)
                        {
                            $value += $item_2->value;
                        }
                    }
                    array_push($array_realisasi_rekening, $value);
                    if(count($array_realisasi_rekening) > 0)
                    {
                        array_push($realisasi_rekening, $array_realisasi_rekening);
                    }
                }
                $data['realisasi_rekening'] = $realisasi_rekening;
                $data['realisasi_rekening_total'] = 0;
                foreach($realisasi_rekening as $item)
                {
                    $data['realisasi_rekening_total'] +=  $item[1];
                }
            } else {
                $skpd_id = 0;
                $split_format_date = explode("-", $date);
                 if(Auth::user()->role->all_users_data == 1)
                {
                    $data['journal'] = Journal::where(function($q) use($split_format_date, $date){
                            if(count($split_format_date) == 2)
                            {
                                $q->whereMonth('date', $split_format_date[1])->whereYear('date', $split_format_date[0]);
                            }
                            if(count($split_format_date) == 3)
                            {
                                $q->whereDate('date', $date);
                            }
                        })->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
                }
                else{
                    $data['journal'] = Journal::where('user_id',Auth::user()->id)
                        ->where(function($q) use($split_format_date, $date){
                            if(count($split_format_date) == 2)
                            {
                                $q->whereMonth('date', $split_format_date[1])->whereYear('date', $split_format_date[0]);
                            }
                            if(count($split_format_date) == 3)
                            {
                                $q->whereDate('date', $date);
                            }
                        })->orderBy('date', 'desc')->orderBy('id', 'desc')->get();
                }

                if(count($split_format_date) == 2)
                {
                    $data['show_filter_date'] = $this->getMonth($split_format_date[1]);
                }
                if(count($split_format_date) == 3)
                {
                    $data['show_filter_date'] = $split_format_date[2] . '-' . $this->getMonth($split_format_date[1]) . '-' . $split_format_date[0];
                }
                $data['skpd_id'] = 0;
                $data['skpd_name'] = '';
                $data['date'] = $date;

                $skpd_account = SkpdAccount::whereHas('account', function($q){
                    $q->where('year', Auth::user()->year);
                })->get();
                $realisasi_rekening = [];
                foreach($skpd_account as $item_1)
                {
                    $value = 0;
                    $array_realisasi_rekening = [];
                    array_push($array_realisasi_rekening, $item_1->account->name);
                    foreach($data['journal'] as $item_2)
                    {
                        if($item_1->account_id == $item_2->account_id && $item_1->skpd_id == $item_2->skpd_id)
                        {
                            $value += $item_2->value;
                        }
                    }
                    array_push($array_realisasi_rekening, $value);
                    if(count($array_realisasi_rekening) > 0)
                    {
                        array_push($realisasi_rekening, $array_realisasi_rekening);
                    }
                }
                $data['realisasi_rekening'] = $realisasi_rekening;
                $data['realisasi_rekening_total'] = 0;
                foreach($realisasi_rekening as $item)
                {
                    $data['realisasi_rekening_total'] +=  $item[1];
                }
            }
        }
         if(Auth::user()->role->all_users_data == 1)
        {
            $data['this_year'] = Journal::whereYear('date', Auth::user()->year)->where('last_year', 0)->orderBy('date', 'desc')->sum('value');
            $data['last_year'] = Journal::whereYear('date', Auth::user()->year)->where('last_year', 1)->orderBy('date', 'desc')->sum('value');
        }
        else{
            $data['this_year'] = Journal::where('user_id',Auth::user()->id)->whereYear('date', Auth::user()->year)->where('last_year', 0)->orderBy('date', 'desc')->sum('value');

            $data['last_year'] = Journal::where('user_id',Auth::user()->id)->whereYear('date', Auth::user()->year)->where('last_year', 1)->orderBy('date', 'desc')->sum('value');
        }
        $data['total'] = $data['this_year'] + $data['last_year'];
        if(isset($_GET['input_date']) != null || isset($_GET['input_date']) != '')
        {
            $data['input_date'] = $_GET['input_date'];
        }
        return view('pages.journal.index', $data);
    }

    public function getMonth($month)
    {
        if($month == '01')
        {
            $date = "Januari";
        } else if ($month == '02') {
            $date = "Februari";
        } else if ($month == '03') {
            $date = "Maret";
        } else if ($month == '04') {
            $date = "April";
        } else if ($month == '05') {
            $date = "Mei";
        } else if ($month == '06') {
            $date = "Juni";
        } else if ($month == '07') {
            $date = "Juli";
        } else if ($month == '08') {
            $date = "Agustus";
        } else if ($month == '09') {
            $date = "September";
        } else if ($month == '10') {
            $date = "Oktober";
        } else if ($month == '11') {
            $date = "November";
        } else {
            $date = "Desember";
        }

        return $date;
    }

    public function getFilteredJournals(Request $request)
    {
        $selectedDate = $request->input('date');

        // Query database untuk mengambil data yang sesuai berdasarkan tanggal
        $filteredData = Journal::whereDate('date', $selectedDate)->get();

        return response()->json($filteredData);
    }


    public function getJournals(Request $request)
    {
        $date = $request->input('date');
        $skpd_id = $request->input('skpd_id');

        // Query data jurnal berdasarkan tanggal dan skpd_id jika diberikan.
        $journalQuery = Journal::query()
            ->select(
                'journals.id',
                'journals.date',
                'journals.evidance',
                'journals.description',
                'journals.last_year_description',
                'accounts.number as account_number',
                'accounts.name as account_name',
                DB::raw('CASE WHEN journals.last_year = 1 THEN journals.last_year ELSE NULL END as last_year'),
                DB::raw('CASE WHEN journals.last_year = 0 THEN journals.last_year ELSE NULL END as current_year'),
                'skpd.name as skpd'
            )
            ->leftJoin('skpd', 'journals.skpd_id', '=', 'skpd.id')
            ->leftJoin('accounts', 'journals.account_id', '=', 'accounts.id')
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date);
            })
            ->when($skpd_id, function ($query) use ($skpd_id) {
                return $query->where('skpd_id', $skpd_id);
            });

        return Datatables::of($journalQuery)
            ->addColumn('aksi', function (Journal $journal) {
                $button = '';

                // if (auth()->user()->can('ubah jurnal')) {
                    $button .= '<a href="javascript:void(0)" onclick="onEdit(' . htmlspecialchars(json_encode($journal), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-warning me-2"><i class="bi bi-pen"></i></a>';
                // }

                // if (auth()->user()->can('hapus jurnal')) {
                    $button .= '<a href="javascript:void(0)" onclick="onDelete(' . htmlspecialchars(json_encode($journal), ENT_QUOTES, 'UTF-8') . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>';
                // }

                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(JournalsDataTable $dataTable)
    {
        if (Auth::user()->role->journals_view == 0) {
            return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
        }

            if (isset($_GET['input_date']) != null || isset($_GET['input_date']) != '') {
                $data['input_date'] = $_GET['input_date'];
            }

        $skpd = Skpd::where('year', date('Y'))->get();
        $dataTableJournal = $dataTable->html();

        $compact = compact('dataTableJournal','skpd'); // Add the $data array to the compact function to make it available in the view.

        // return view('pages.journal.create', $compact);
        return $dataTable->render('pages.journal.create', $compact);

    }

    public function getJournalsEdit($id)
    {
        $journal = Journal::find($id);

        if ($journal) {
            return response()->json([
                'success' => true,
                'journal' => $journal,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Jurnal tidak ditemukan.',
            ]);
        }
    }

    public function updateBulkData(Request $request)
    {
        // try {
        //     $updatedData = $request->input('updatedData');

        //     foreach ($updatedData as $data) {
        //         $journal = Journal::find($data['id']);
        //         if ($journal) {
        //             $journal->update([
        //                 'evidance' => $data['evidance'],
        //                 'description' => $data['description'],
        //                 'value' => $data['value'],
        //             ]);
        //         }
        //     }
        //     dd($request->all());
        //     // return response()->json(['message' => 'Data berhasil diperbarui']);
        // } catch (\Exception $e) {
        //     dd($request->all());
        //     // return response()->json(['error' => $e->getMessage()], 500); // Mengembalikan kesalahan dalam respons
        // }
        $data = json_decode($request->data);
        foreach($data as $key => $value) {
            $journal = Journal::find($key);
            foreach($value as $atribut => $data_atribut){
                $journal->update([
                    $atribut => $data_atribut
                ]);
            }
        }

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        // // Hapus data berdasarkan ID yang terpilih
        $jur = Journal::whereIn('id', $selectedIds)->delete();

        return response()->json(['message' => 'Data berhasil dihapus', 'old_data' => $jur]);

    }


    public function revisijurnal(){

        $dataRevisi = Journal::with('account','skpd')->whereBetween('date',['2022-12-22','2022-12-30'])->get();

        $skpdAccount = DB::table('skpd_accounts as sa')
        ->join('accounts as a', 'sa.account_id','=','a.id')
        ->join('skpd as s', 'sa.skpd_id','=','s.id')
        ->select('a.number','a.name','a.name')
        ->get();
        //DB::table('journals')->whereBetween('date', ['2022-12-22','2022-12-30'])->get();



        return view('pages.journal.revisiJurnal', compact('dataRevisi'));
    }

    public function updateRevisiJurnal(Request $request){
        $dataRevisi = DB::table('journals')
                    ->where('id', $request->id)
                    ->update([
                        'account_id' => $request->account_id

                        ]);
          return response()->json([
            'status' => 200,

        ]);
    }

    // public function store(Request $request)
    // {
    //     DB::beginTransaction();

    //     // if(request('last_year') == 0)
    //     // {
    //     //     $last_year_description = null;
    //     // } else {
    //     //     $last_year_description = request('last_year_description');
    //     // }
    //     // $skpd = Skpd::where('id', request('skpd_id'))->first();
    //     // if($skpd != null)
    //     // {
    //     //     $skpd_now = Skpd::where('name', $skpd->name)->where('year', Auth::user()->year)->pluck('id')->first();
    //     // } else {
    //     //     $skpd_now = request('skpd_id');
    //     // }
    //     // $account = Account::where('id', request('account_id'))->first();
    //     // if($skpd != null)
    //     // {
    //     //     $account_now = Account::where('number', $account->number)->where('year', Auth::user()->year)->pluck('id')->first();
    //     // } else {
    //     //     $account_now = request('account_id');
    //     // }

    //     // $value = 0;
    //     // if(request('value1') != null)
    //     // {
    //     //     $value = str_replace(".","", request('value1'));
    //     //     $value = str_replace(",",".", $value);
    //     // } else if(request('value2') != null){
    //     //     $value = request('value2');
    //     // }

    //     Journal::create([
    //        'account_id' => request('account_id'),
    //        'user_id' => request('account_id'),
    //        'skpd_id' => request('account_id'),
    //        'date' => request('date'),
    //        'evidance' => request('evidance'),
    //        'description' => request('description'),
    //        'value' => request('evidance'),
    //        'last_year' => request('last_year'),
    //        'last_year_description' => request('evidance'),
    //        'mark' => 0,
    //     ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => "Berhasil",
    //         ], 200);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request('last_year') == 0)
        {
            $last_year_description = null;
        } else {
            $last_year_description = request('last_year_description');
        }
        $skpd = Skpd::where('id', request('skpd_id'))->first();
        if($skpd != null)
        {
            $skpd_now = Skpd::where('name', $skpd->name)->where('year', Auth::user()->year)->pluck('id')->first();
        } else {
            $skpd_now = request('skpd_id');
        }
        $account_number = Account::where('id', request('account_id'))->pluck('number')->first();
        $account_now = Account::where('number', $account_number)
            ->where('year', Auth::user()->year)->pluck('id')->first();
//        if($skpd != null)
//        {
//
//        } else {
//            $account_now = request('account_id');
//        }

        $value = 0;
        if(request('value1') != null)
        {
            $value = str_replace(".","", request('value1'));
            $value = str_replace(",",".", $value);
        } else if(request('value2') != null){
            $item = request('value2');
            $value = str_replace(".","", $item);
        }
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $request = [
            'account_id' => $account_now,
            'user_id' => Auth::user()->id,
            'skpd_id' => $request->skpd_id,
            'date' => request('date'),
            'evidance' => request('evidance'),
            'description' => request('description'),
            'value' => $value,
            'last_year' => request('last_year'),
            'last_year_description' => $last_year_description,
            'mark' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        \Illuminate\Support\Facades\DB::table('journals')->insert($request);

           return response()->json([
                'success' => true,
                'message' => "Berhasil",
            ], 200);
    }

    public function getSkpdAccount()
    {

        $skpdAccounts = SkpdAccount::with(['account' => function($q){
            $q->orderBy('number', 'asc');
        }])->where('skpd_id', request('skpd_id'))
            ->orderBy('id', 'asc')->get();

        return response()->json(compact('skpdAccounts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Journal::with('account')->findOrFail($id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = Journal::findOrFail($id);
        if(request('last_year') == 0)
        {
            $last_year_description = null;
        } else {
            $last_year_description = request('last_year_description');
        }

        $skpd = Skpd::where('id', request('skpd_id'))->first();
        if($skpd != null)
        {
            $skpd_now = Skpd::where('name', $skpd->name)->where('year', Auth::user()->year)->pluck('id')->first();
        } else {
            $skpd_now = request('skpd_id');
        }
        $account = Account::where('id', request('account_id'))->first();
        if($skpd != null)
        {
            $account_now = Account::where('number', $account->number)->where('year', Auth::user()->year)->pluck('id')->first();
        } else {
            $account_now = request('account_id');
        }
        $value = $data->value;
        if(request('value1') != null)
        {
            $value = str_replace(".","", request('value1'));
            $value = str_replace(",",".", $value);
        } else if(request('value2') != null) {
            $value = request('value2');
        }

        $data->update([
            'account_id' => $account_now,
            'skpd_id' => $skpd_now,
            'date' => request('date'),
            'evidance' => request('evidance'),
            'description' => request('description'),
            'value' => $value,
            'last_year' => request('last_year'),
            'last_year_description' => $last_year_description,
        ]);

        // return redirect()->back()->with("OK", "Berhasil mengubah data");
        return response()->json([
            'success' => true,
            'message' => "Data Berhasil Diubah",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Journal::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => "Data Berhasil Dihapus",
        ], 200);
    }

    public function mark($id)
    {
        $data = Journal::findOrFail($id);
        if($data->mark == 0)
        {
          $data->update([
            'mark' => 1
          ]);
        } else {
          $data->update([
            'mark' => 0
          ]);
        }

        return redirect()->back();
    }

    public function verifyJournal(Request $request)
    {
        $skpd = Skpd::all();
        if(isset($request->tahun)){
            $journals = Journal::whereYear('date', $request->tahun)->whereMonth('date', $request->bulan)->get();
        }else{
            $journals = Journal::whereYear('date', date('Y'))->whereMonth('date', date('m'))->get();
        }

        return view('pages.journal.verify', ['skpd' => $skpd, 'journals' => $journals, 'tahun' => (isset($request->tahun))? $request->tahun : date('Y'), 'bulan' => (isset($request->bulan))? $request->bulan : date('m')]);
    }

    public function verifyJournalStore(Request $request){
        $x = json_decode($request->selectedIds);
        foreach($x as $id_journal){
            $journal = Journal::find($id_journal);
            $journal->update([
                "verify_at" => Carbon::now(),
                "verify_by" => Auth::user()->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Data Berhasil Di Ubah",
        ], 200);
    }
}
