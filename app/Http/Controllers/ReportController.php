<?php

namespace App\Http\Controllers;

use PDF;
use App\Skpd;
use App\Account;
use App\Journal;
use Carbon\Carbon;
use App\SkpdAccount;
use App\Exports\WpWrExport;
use Illuminate\Http\Request;
use App\Exports\IncomeExport;
use App\Exports\LedgerExport;
use App\Exports\OverallExport;
use App\Exports\SummaryExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    //////////////////////////////////////Ringkasan PAD///////////////////////////////

    public function indexSummary(Request $request)
    {

        $data['n'] = 1;
        $change = null;
        $type = null;
        $date = null;
        $startDate = null;
        $endDate = null;
        $array_summary = [];
        $data['account'] = [];
        $data['month'] = null;
        $data['start_date'] = null;
        $data['end_date'] = null;
        if (isset($_GET['change']) != null) {
            $change = $_GET['change'];
            if (isset($_GET['type']) != null) {
                $type = $_GET['type'];
                if ($_GET['start_date'] != null && $_GET['end_date'] != '') {

                    $startDate = $request->input('start_date');
                    $endDate = $request->input('end_date');
                    $type = $request->input('type');
                    $change = $request->input('change');
                    $data['start_date'] = $startDate;
                    $data['end_date'] = $endDate;

                    if (date('Y', strtotime($startDate)) != date('Y') && date('Y', strtotime($endDate)) != date('Y')) {
                        $data['type'] = $type;
                        $data['change'] = $change;
                        return view('pages.report.summary.index', $data);
                    }


                    $splitStartDate = explode('-', $startDate);
                    $splitEndDate = explode('-', $endDate);
                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }

                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            //   ->where(function($q) use($type){
                            //     if($type == 'laporan_bulanan_merah')
                            //     {
                            //       $q->where('mark_2', 1);
                            //     }
                            //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                            //     {
                            //       $q->where('mark_1', 1);
                            //     }
                            //   })
                            ->get();
                    }

                    $parent = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        //   ->where(function($q) use($type){
                        //     if($type == 'laporan_bulanan_merah')
                        //     {
                        //       $q->where('mark_2', 1);
                        //     }
                        //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                        //     {
                        //       $q->where('mark_1', 1);
                        //     }
                        //   })
                        ->get();
                    if (Auth::user()->role->all_users_data == 1) {
                        $children = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])->where('year', Auth::user()->year)->get();
                    } else {
                        $children = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)
                            //   ->where(function($q) use($type){
                            //     if($type == 'laporan_bulanan_merah')
                            //     {
                            //       $q->where('mark_2', 1);
                            //     }
                            //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                            //     {
                            //       $q->where('mark_1', 1);
                            //     }
                            //   })
                            ->get();
                    }

                    foreach ($parent as $item) {
                        // $explode_number_parent = explode(".", $item->number);
                        // $implode_number_parent = implode("", $explode_number_parent);
                        $array_children = [];
                        $realisasi_this_month_after = 0;
                        $realisasi_this_month_before = 0;
                        $realisasi_until_this_month_after = 0;
                        $realisasi_until_this_month_before = 0;
                        $realisasi_until_last_month_after = 0;
                        $realisasi_until_last_month_before = 0;
                        foreach ($children as $item_1) {
                            // $explode_number_children = explode(".", $item_1->number);
                            // $implode_number_children = implode("", $explode_number_children);
                            // $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month_after += $item_1->realisasi_this_month_after->sum('value');
                                    $realisasi_this_month_before += $item_1->realisasi_this_month_before->sum('value');

                                    $realisasi_until_this_month_after += $item_1->realisasi_until_this_month_after->sum('value');
                                    $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');

                                    $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');

                                    $realisasi_until_last_month_after += $item_1->realisasi_until_last_month_after->sum('value');
                                    $realisasi_until_last_month_before += $item_1->realisasi_until_last_month_before->sum('value');
                                }
                                array_push($array_children, $item_1->id);
                            }
                        }
                        if ($change == 'sebelum_perubahan') {
                            $target = Account::whereIn('id', $array_children)->sum('target_before');
                        } else {
                            $target = Account::whereIn('id', $array_children)->sum('target_after');
                        }
                        $collection = collect([
                            'id' => $item->id,
                            'order_number' => $item->order_number,
                            'number' => $item->number,
                            'name' => $item->name,
                            'target' => $target,
                            'realisasi_this_month_after' => $realisasi_this_month_after,
                            'realisasi_this_month_before' => $realisasi_this_month_before,

                            'realisasi_until_this_month_after' => $realisasi_until_this_month_after,
                            'realisasi_until_this_month_before' => $realisasi_until_this_month_before,
                            // 'realisasi_until_this_month_before' => $realisasi_this_month_before + $realisasi_until_last_month_before,

                            'realisasi_until_last_month_after' => $realisasi_until_last_month_after,
                            'realisasi_until_last_month_before' => $realisasi_until_last_month_before,
                            'legal_basis' => $item->legal_basis,
                            'description' => $item->description,
                            'mark_1' => $item->mark_1,
                            'mark_2' => $item->mark_2,
                        ]);
                        array_push($array_summary, $collection);
                    }
                }else if ($request->type = "laporan_bulanan_merah" || $request->type = "rekapitulasi_laporan_bulanan_hijau") {
                    $now = Carbon::now();
    
                    $startDate = $now->startOfYear();
    
                    $formattedStartDate = $startDate->toDateString();
                    $formattedNow = $now->toDateTimeString();
                    $startDate = $formattedStartDate;
                    $endDate = date('Y-m-d');
                    $data['start_date'] = $startDate;
                    $data['end_date'] = $endDate;
    
    
                    //   $splitDate = explode('-', $date);
                    $splitStartDate = explode('-', $startDate);
                    $splitEndDate = explode('-', $endDate);
                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->whereMonth('date', $splitEndDate[1]);
                                //                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
    
                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            //   ->where(function($q) use($type){
                            //     if($type == 'laporan_bulanan_merah')
                            //     {
                            //       $q->where('mark_2', 1);
                            //     }
                            //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                            //     {
                            //       $q->where('mark_1', 1);
                            //     }
                            //   })
                            ->get();
                    }
    
                    $parent = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        //   ->where(function($q) use($type){
                        //     if($type == 'laporan_bulanan_merah')
                        //     {
                        //       $q->where('mark_2', 1);
                        //     }
                        //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                        //     {
                        //       $q->where('mark_1', 1);
                        //     }
                        //   })
                        ->get();
                    if (Auth::user()->role->all_users_data == 1) {
                        $children = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])->where('year', Auth::user()->year)->get();
                    } else {
                        $children = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate, $splitEndDate) {
                                $q->whereMonth('date', $splitEndDate[1]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)
                            //   ->where(function($q) use($type){
                            //     if($type == 'laporan_bulanan_merah')
                            //     {
                            //       $q->where('mark_2', 1);
                            //     }
                            //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                            //     {
                            //       $q->where('mark_1', 1);
                            //     }
                            //   })
                            ->get();
                    }
    
                    foreach ($parent as $item) {
                        // $explode_number_parent = explode(".", $item->number);
                        // $implode_number_parent = implode("", $explode_number_parent);
                        $array_children = [];
                        $realisasi_this_month_after = 0;
                        $realisasi_this_month_before = 0;
                        $realisasi_until_this_month_after = 0;
                        $realisasi_until_this_month_before = 0;
                        $realisasi_until_last_month_after = 0;
                        $realisasi_until_last_month_before = 0;
                        foreach ($children as $item_1) {
                            // $explode_number_children = explode(".", $item_1->number);
                            // $implode_number_children = implode("", $explode_number_children);
                            // $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month_after += $item_1->realisasi_this_month_after->sum('value');
                                    $realisasi_this_month_before += $item_1->realisasi_this_month_before->sum('value');
    
                                    $realisasi_until_this_month_after += $item_1->realisasi_until_this_month_after->sum('value');
                                    $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');
    
                                    $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');
    
                                    $realisasi_until_last_month_after += $item_1->realisasi_until_last_month_after->sum('value');
                                    $realisasi_until_last_month_before += $item_1->realisasi_until_last_month_before->sum('value');
                                }
                                array_push($array_children, $item_1->id);
                            }
                        }
                        if ($change == 'sebelum_perubahan') {
                            $target = Account::whereIn('id', $array_children)->sum('target_before');
                        } else {
                            $target = Account::whereIn('id', $array_children)->sum('target_after');
                        }
                        $collection = collect([
                            'id' => $item->id,
                            'order_number' => $item->order_number,
                            'number' => $item->number,
                            'name' => $item->name,
                            'target' => $target,
                            'realisasi_this_month_after' => $realisasi_this_month_after,
                            'realisasi_this_month_before' => $realisasi_this_month_before,
    
                            'realisasi_until_this_month_after' => $realisasi_until_this_month_after,
                            'realisasi_until_this_month_before' => $realisasi_until_this_month_before,
                            // 'realisasi_until_this_month_before' => $realisasi_this_month_before + $realisasi_until_last_month_before,
    
                            'realisasi_until_last_month_after' => $realisasi_until_last_month_after,
                            'realisasi_until_last_month_before' => $realisasi_until_last_month_before,
                            'legal_basis' => $item->legal_basis,
                            'description' => $item->description,
                            'mark_1' => $item->mark_1,
                            'mark_2' => $item->mark_2,
                        ]);
                        array_push($array_summary, $collection);
                    }
                }
                
            }
        }

        $data['array_summary'] = $array_summary;
        $data['change'] = $change;
        $data['type'] = $type;
        $data['date'] = $date;
        return view('pages.report.summary.index', $data);
    }

    public function printSummary()
    {
        $data['n'] = 1;
        $data['ttgl'] = request('ttgl');
        $change = null;
        $type = null;
        $date = null;
        $array_summary = [];
        $data['account'] = [];
        $data['month'] = null;
        $data['start_date'] = null;
        $data['end_date'] = null;
        if (isset($_GET['change']) != null) {
            $change = $_GET['change'];
            if (isset($_GET['type']) != null) {
                $type = $_GET['type'];
                if ($_GET['start_date'] != null && $_GET['start_date'] != '') {
                    $startDate = $_GET['start_date'];
                    $endDate = $_GET['end_date'];
                    $data['start_date'] = $startDate;
                    $data['end_date'] = $endDate;

                    //   $splitDate = explode('-', $date);
                    $splitStartDate = explode('-', $startDate);
                    $splitEndDate = explode('-', $endDate);
                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            },
                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            //   ->where(function($q) use($type){
                            //     if($type == 'laporan_bulanan_merah')
                            //     {
                            //       $q->where('mark_2', 1);
                            //     }
                            //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                            //     {
                            //       $q->where('mark_1', 1);
                            //     }
                            //   })
                            ->get();
                    }

                    $parent = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        //   ->where(function($q) use($type){
                        //     if($type == 'laporan_bulanan_merah')
                        //     {
                        //       $q->where('mark_2', 1);
                        //     }
                        //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                        //     {
                        //       $q->where('mark_1', 1);
                        //     }
                        //   })
                        ->get();
                    if (Auth::user()->role->all_users_data == 1) {
                        $children = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            },
                        ])->where('year', Auth::user()->year)->orderBy('order_number', 'asc')->get();
                    } else {
                        $children = Account::with([
                            'children',
                            'realisasi_this_month_after' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_this_month_before' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month_after' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_this_month_before' => function ($q) use ($startDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $startDate);
                            },
                            'realisasi_until_last_month_after' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            },
                            'realisasi_until_last_month_before' => function ($q) use ($splitStartDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitStartDate[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)
                            //   ->where(function($q) use($type){
                            //     if($type == 'laporan_bulanan_merah')
                            //     {
                            //       $q->where('mark_2', 1);
                            //     }
                            //     if($type == 'rekapitulasi_laporan_bulanan_hijau')
                            //     {
                            //       $q->where('mark_1', 1);
                            //     }
                            //   })
                            ->get();
                    }

                    foreach ($parent as $item) {
                        // $explode_number_parent = explode(".", $item->number);
                        // $implode_number_parent = implode("", $explode_number_parent);
                        $array_children = [];
                        $realisasi_this_month_after = 0;
                        $realisasi_this_month_before = 0;
                        $realisasi_until_this_month_after = 0;
                        $realisasi_until_this_month_before = 0;
                        $realisasi_until_last_month_after = 0;
                        $realisasi_until_last_month_before = 0;
                        foreach ($children as $item_1) {
                            // $explode_number_children = explode(".", $item_1->number);
                            // $implode_number_children = implode("", $explode_number_children);
                            // $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month_after += $item_1->realisasi_this_month_after->sum('value');
                                    $realisasi_this_month_before += $item_1->realisasi_this_month_before->sum('value');
                                    $realisasi_until_this_month_after += $item_1->realisasi_until_this_month_after->sum('value');
                                    $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');
                                    $realisasi_until_last_month_after += $item_1->realisasi_until_last_month_after->sum('value');
                                    $realisasi_until_last_month_before += $item_1->realisasi_until_last_month_before->sum('value');
                                }
                                array_push($array_children, $item_1->id);
                            }
                        }
                        if ($change == 'sebelum_perubahan') {
                            $target = Account::whereIn('id', $array_children)->sum('target_before');
                        } else {
                            $target = Account::whereIn('id', $array_children)->sum('target_after');
                        }
                        $collection = collect([
                            'id' => $item->id,
                            'order_number' => $item->order_number,
                            'number' => $item->number,
                            'name' => $item->name,
                            'target' => $target,
                            'realisasi_this_month_after' => $realisasi_this_month_after,
                            'realisasi_this_month_before' => $realisasi_this_month_before,
                            'realisasi_until_this_month_after' => $realisasi_until_this_month_after,
                            'realisasi_until_this_month_before' => $realisasi_until_this_month_before,
                            'realisasi_until_last_month_after' => $realisasi_until_last_month_after,
                            'realisasi_until_last_month_before' => $realisasi_until_last_month_before,
                            'legal_basis' => $item->legal_basis,
                            'description' => $item->description,
                            'mark_1' => $item->mark_1,
                            'mark_2' => $item->mark_2,
                        ]);
                        array_push($array_summary, $collection);
                    }
                }
            }
        }

        $data['array_summary'] = $array_summary;
        $data['change'] = $change;
        $data['type'] = $type;
        $data['date'] = $date;
        // if($date != null && $date != '')
        // {
        //   $data['month'] = $this->getMonth($split_date[1]);
        // }
        return view('pages.report.summary.print', $data);
    }

    public function exportSummary()
    {
        return (new SummaryExport($_GET['change'], $_GET['type'], $_GET['start_date'], $_GET['end_date'], 'Worksheet'))
            ->download('Ringkasan_dan_PAD_' . $_GET['start_date'] . ' | ' . $_GET['end_date'] . '.xlsx');
    }



    //////////////////////////////////////Buku Besar///////////////////////////////


    public function indexLedger()
    {
        if (Auth::user()->role->reports_ledger_view == 0) {
            return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
        }

        $account = null;
        $date = null;
        $data['month'] = null;
        $data['book'] = [];
        $data['skpd_account'] = [];
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['start_date'] = null;
        $data['end_date'] = null;
        $data['account'] = null;
        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();

        if (isset($_GET['account']) != null) {
            $account = $_GET['account'];
            $data['account'] = $account;

            $parent_id = explode("-", $account);
            if (request('account_id') != 0 || $account != null || $account != '') {
                $account = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
            }


            $accountIds = [];

            $accountIds[] = $account;
            $currAcc = Account::find($account);

            if (count($currAcc->children) > 0) {
                foreach ($currAcc->children as $children) {
                    if (count($children->children) > 0) {
                        foreach ($children->children as $children2) {
                            if (count($children2->children) > 0) {
                                foreach ($children2->children as $children3) {
                                    if (count($children3->children) > 0) {
                                        foreach ($children3->children as $children4) {
                                            if (count($children4->children) > 0) {
                                                foreach ($children4->children as $children5) {
                                                    if (count($children5->children) > 0) {
                                                        foreach ($children5->children as $children6) {
                                                            $accountIds[] = $children6->id;
                                                        }
                                                    } else {
                                                        $accountIds[] = $children5->id;
                                                    }
                                                }
                                            } else {
                                                $accountIds[] = $children4->id;
                                            }
                                        }
                                    } else {
                                        $accountIds[] = $children3->id;
                                    }
                                }
                            } else {
                                $accountIds[] = $children2->id;
                            }
                        }
                    } else {
                        $accountIds[] = $children->id;
                    }
                }
            }

            if ($_GET['start_date'] != null && $_GET['start_date'] != '') {

                $startDate = $_GET['start_date'];
                $endDate = $_GET['end_date'];

                $data['start_date'] = $startDate;
                $data['end_date'] = $endDate;

                $splitStartDate = explode('-', $startDate);
                $splitEndDate = explode('-', $endDate);
                // $split_date = explode('-', $date);

                if (Auth::user()->role->all_users_data == 1) {

                    $data['month'] = $this->getMonth($splitStartDate[1]);
                    $data['book'] = Journal::whereBetween('date', [$startDate, $endDate])->whereIn('account_id', $accountIds)->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->whereIn('account_id', $accountIds)->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->whereIn('account_id', $accountIds)->orderBy('date', 'desc')->sum('value');

                    //  $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $currAcc->id)->first();
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();

                } else {
                    $data['month'] = $this->getMonth($split_date[1]);
                    $data['book'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->whereBetween('date', [$startDate, $endDate])->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();

                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $currAcc->id)->first();
                }

            }
        }


        $data['date'] = $date;
        $data['n'] = 1;
        // dd($data['book'][0]);
        return view('pages.report.ledger.index', $data);
    }

    public function indexLedgerOldFromDev()
    {

    }

    public function printLedger()
    {

        $account = null;
        $date = null;
        $data['month'] = null;
        $data['book'] = [];
        $data['skpd_account'] = [];
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['start_date'] = null;
        $data['end_date'] = null;
        $data['account'] = null;
        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();
        if (isset($_GET['account']) != null) {
            $account = $_GET['account'];
            $data['account'] = $account;
            $parent_id = explode("-", $account);
            if (request('account_id') != 0 || $account != null || $account != '') {
                $account = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
            }
            $accountIds[] = $account;
            $currAcc = Account::find($account);
            if (count($currAcc->children) > 0) {
                foreach ($currAcc->children as $children) {
                    if (count($children->children) > 0) {
                        foreach ($children->children as $children2) {
                            if (count($children2->children) > 0) {
                                foreach ($children2->children as $children3) {
                                    if (count($children3->children) > 0) {
                                        foreach ($children3->children as $children4) {
                                            if (count($children4->children) > 0) {
                                                foreach ($children4->children as $children5) {
                                                    if (count($children5->children) > 0) {
                                                        foreach ($children5->children as $children6) {
                                                            $accountIds[] = $children6->id;
                                                        }
                                                    } else {
                                                        $accountIds[] = $children5->id;
                                                    }
                                                }
                                            } else {
                                                $accountIds[] = $children4->id;
                                            }
                                        }
                                    } else {
                                        $accountIds[] = $children3->id;
                                    }
                                }
                            } else {
                                $accountIds[] = $children2->id;
                            }
                        }
                    } else {
                        $accountIds[] = $children->id;
                    }
                }
            }
            if ($_GET['start_date'] != null && $_GET['start_date'] != '') {
                $startDate = $_GET['start_date'];
                $endDate = $_GET['end_date'];
                $data['start_date'] = $startDate;
                $data['end_date'] = $endDate;

                $splitStartDate = explode('-', $startDate);
                $splitEndDate = explode('-', $endDate);

                if (Auth::user()->role->all_users_data == 1) {
                    $data['book'] = Journal::whereIn('account_id', $accountIds)->whereBetween('date', [$startDate, $endDate])->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::whereIn('account_id', $accountIds)->where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::whereIn('account_id', $accountIds)->where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                } else {
                    $data['book'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->whereBetween('date', [$startDate, $endDate])->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $currAcc->id)->first();
                }
            }
        }

        // if($date != null && $date != '')
        // {
        //   $data['month'] = $this->getMonth($split_date[1]);
        // }
        $data['date'] = $date;

        $data['n'] = 1;
        return view('pages.report.ledger.print', $data);
    }

    public function exportLedger()
    {
        return (new LedgerExport)
            ->account($_GET['account'])
            ->startDate($_GET['start_date'])
            ->endDate($_GET['end_date'])
            ->download('Buku_Besar_' . $_GET['start_date'] . ' | ' . $_GET['end_date'] . '.xlsx');
    }

    //////////////////////////////////////Pendapatan///////////////////////////////



    public function indexIncome()
    {
        if (Auth::user()->role->reports_income_view == 0) {
            return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
        }

        $skpd = null;
        $id_skpd = null;
        $change = null;
        $date = null;
        $array_income = [];
        $array_income_final = [];
        $data['account'] = [];
        $data['month'] = null;
        $data['start_date'] = null;
        $data['end_date'] = null;
        $data['filter_skpd'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        if (isset($_GET['skpd']) != null) {
            $skpd = $_GET['skpd'];
            if (isset($_GET['change']) != null) {
                $change = $_GET['change'];
                if ($_GET['start_date'] != null && $_GET['start_date'] != '') {
                    $startDate = $_GET['start_date'];
                    $endDate = $_GET['end_date'];
                    $data['start_date'] = $startDate;
                    $data['end_date'] = $endDate;

                    //   $splitDate = explode('-', $date);
                    $splitStartDate = explode('-', $startDate);
                    $splitEndDate = explode('-', $endDate);

                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();

                        $parent = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();

                        $children = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    }

                    $id_skpd = Skpd::where('id', $skpd)->pluck('id')->first();

                    $skpd = Skpd::where('id', $skpd)->pluck('name')->first();

                    $data['id_skpd'] = $id_skpd;

                    foreach ($parent as $item) {
                        // $explode_number_parent = explode(".", $item->number);
                        // $implode_number_parent = implode("", $explode_number_parent);
                        $array_children = [];
                        $realisasi_this_month = 0;
                        $realisasi_until_this_month = 0;
                        $realisasi_until_last_month = 0;
                        foreach ($children as $item_1) {
                            // $explode_number_children = explode(".", $item_1->number);
                            // $implode_number_children = implode("", $explode_number_children);
                            // $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month += $item_1->realisasi_this_month->sum('value');
                                    $realisasi_until_this_month += $item_1->realisasi_until_this_month->sum('value');
                                    $realisasi_until_last_month += $item_1->realisasi_until_last_month->sum('value');
                                }
                                array_push($array_children, $item_1->id);
                            }
                        }
                        if ($change == 'tidak') {
                            $target = Account::whereIn('id', $array_children)->sum('target_before');
                        } else {
                            $target = Account::whereIn('id', $array_children)->sum('target_after');
                        }
                        $collection = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target, 'realisasi_this_month' => $realisasi_this_month, 'realisasi_until_this_month' => $realisasi_until_this_month, 'realisasi_until_last_month' => $realisasi_until_last_month]);
                        array_push($array_income, $collection);
                    }
                    foreach ($array_income as $item) {
                        if ($item['target'] != 0) {
                            array_push($array_income_final, $item);
                        }
                    }
                    foreach ($children as $item) {
                        if ($change == 'tidak') {
                            $target = Account::where('id', $item->id)->sum('target_before');
                        } else {
                            $target = Account::where('id', $item->id)->sum('target_after');
                        }
                        $collection = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target, 'realisasi_this_month' => $item->realisasi_this_month->sum('value'), 'realisasi_until_this_month' => $item->realisasi_until_this_month->sum('value'), 'realisasi_until_last_month' => $item->realisasi_until_last_month->sum('value')]);
                        array_push($array_income_final, $collection);
                    }
                }
            }
        }
        $data['income'] = $array_income_final;
        $data['skpd'] = $skpd;
        // if($date != null && $date != '')
        // {
        //   $data['month'] = $this->getMonth($split_date[1]);
        // }
        // $data['date'] = $date;
        $data['change'] = $change;
        $data['n'] = 1;

        // dd($data);
        return view('pages.report.income.index', $data);
    }

    public function printIncome()
    {

        $skpd = null;
        $change = null;
        $date = null;
        $array_income = [];
        $array_income_final = [];
        $data['account'] = [];
        $data['month'] = null;
        $data['start_date'] = null;
        $data['end_date'] = null;
        $data['filter_skpd'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        if (isset($_GET['skpd']) != null) {
            $skpd = $_GET['skpd'];
            if (isset($_GET['change']) != null) {
                $change = $_GET['change'];
                if ($_GET['start_date'] != null && $_GET['start_date'] != '') {
                    $startDate = $_GET['start_date'];
                    $endDate = $_GET['end_date'];
                    $data['start_date'] = $startDate;
                    $data['end_date'] = $endDate;

                    //   $splitDate = explode('-', $date);
                    $splitStartDate = explode('-', $startDate);
                    $splitEndDate = explode('-', $endDate);
                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            },
                            'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    }

                    $skpd = Skpd::where('id', $skpd)->pluck('name')->first();
                    foreach ($parent as $item) {
                        // $explode_number_parent = explode(".", $item->number);
                        // $implode_number_parent = implode("", $explode_number_parent);
                        $array_children = [];
                        $realisasi_this_month = 0;
                        $realisasi_until_this_month = 0;
                        $realisasi_until_last_month = 0;
                        foreach ($children as $item_1) {
                            // $explode_number_children = explode(".", $item_1->number);
                            // $implode_number_children = implode("", $explode_number_children);
                            // $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month += $item_1->realisasi_this_month->sum('value');
                                    $realisasi_until_this_month += $item_1->realisasi_until_this_month->sum('value');
                                    $realisasi_until_last_month += $item_1->realisasi_until_last_month->sum('value');
                                }
                                array_push($array_children, $item_1->id);
                            }
                        }
                        if ($change == 'tidak') {
                            $target = Account::whereIn('id', $array_children)->sum('target_before');
                        } else {
                            $target = Account::whereIn('id', $array_children)->sum('target_after');
                        }
                        $collection = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target, 'realisasi_this_month' => $realisasi_this_month, 'realisasi_until_this_month' => $realisasi_until_this_month, 'realisasi_until_last_month' => $realisasi_until_last_month]);
                        array_push($array_income, $collection);
                    }
                    foreach ($array_income as $item) {
                        if ($item['target'] != 0) {
                            array_push($array_income_final, $item);
                        }
                    }
                    foreach ($children as $item) {
                        if ($change == 'tidak') {
                            $target = Account::where('id', $item->id)->sum('target_before');
                        } else {
                            $target = Account::where('id', $item->id)->sum('target_after');
                        }
                        $collection = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target, 'realisasi_this_month' => $item->realisasi_this_month->sum('value'), 'realisasi_until_this_month' => $item->realisasi_until_this_month->sum('value'), 'realisasi_until_last_month' => $item->realisasi_until_last_month->sum('value')]);
                        array_push($array_income_final, $collection);
                    }
                }
            }
        }
        $data['income'] = $array_income_final;
        $data['skpd'] = $skpd;
        // if($date != null && $date != '')
        // {
        //   $data['month'] = $this->getMonth($split_date[1]);
        // }
        // $data['date'] = $date;
        $data['change'] = $change;
        $data['n'] = 1;
        return view('pages.report.income.print', $data);
    }

    public function exportIncome()
    {
        return (new IncomeExport($_GET['skpd'], $_GET['change'], $_GET['start_date'], $_GET['end_date'], 'http://e-penda.inotive.id/images/logo-tabalong.png'))
            ->download('Pendapatan_' . $_GET['start_date'] . ' || ' . $_GET['end_date'] . '.xlsx');
    }

    //////////////////////////////////////Laporan Keseluruhan///////////////////////////////



    public function indexOverall()
    {

        if (Auth::user()->role->reports_overall_view == 0) {
            return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
        }

        $data['n'] = 1;

        // SUMMARY ALL
        $change_summary_all = null;
        $date_summary_all = null;
        $start_date_summary_all = null;
        $end_date_summary_all = null;
        $array_summary_all = [];
        $data['account_summary_all'] = [];
        $data['month_summary_all'] = null;
        $data['start_date_summary'] = null;
        $data['end_date_summary'] = null;

        // SUMMARY RED
        $change_summary_red = null;
        $date_summary_red = null;
        $start_date_summary_red = null;
        $end_date_summary_red = null;
        $array_summary_red = [];
        $data['account_summary_red'] = [];
        $data['month_summary_red'] = null;
        $data['start_date_summary_red'] = null;
        $data['end_date_summary_red'] = null;

        // SUMMARY GREEN
        $change_summary_green = null;
        $date_summary_green = null;
        $start_date_summary_green = null;
        $end_date_summary_green = null;
        $array_summary_green = [];
        $data['account_summary_green'] = [];
        $data['month_summary_green'] = null;
        $data['start_date_summary_green'] = null;
        $data['end_date_summary_green'] = null;

        // INCOME
        $skpd_income = null;
        $id_skpd_income = null;
        $change_income = null;
        $date_income = null;
        $start_date_income = null;
        $end_date_income = null;
        $array_income = [];
        $array_income_final = [];
        $data['account_income'] = [];
        $data['month_income'] = null;
        $data['start_date_income'] = null;
        $data['end_date_income'] = null;
        $data['filter_skpd_income'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();

        // GET DATA SUMMARY ALL
        if (isset($_GET['change_summary_all']) != null) {
            $change_summary_all = $_GET['change_summary_all'];
            if (isset($_GET['start_date_summary']) != null) {
                $start_date_summary_all = $_GET['start_date_summary'];
                $end_date_summary_all = $_GET['end_date_summary'];

                $data['start_date_summary'] = $start_date_summary_all;
                $data['end_date_summary'] = $end_date_summary_all;

                $split_start_date_summary_all = explode('-', $start_date_summary_all);
                $split_end_date_summary_all = explode('-', $end_date_summary_all);


                if (Auth::user()->role->all_users_data == 1) {
                    $data['account_summary_all'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_all = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_all = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                        }
                    ])
                        ->where('year', Auth::user()->year)
                        ->get();
                } else {
                    $data['account_summary_all'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_all = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_all = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                        }
                    ])
                        ->where('year', Auth::user()->year)
                        ->get();
                }

                foreach ($parent_summary_all as $item) {
                    // $explode_number_parent_summary_all = explode(".", $item->number);
                    // $implode_number_parent_summary_all = implode("", $explode_number_parent_summary_all);
                    $array_children_summary_all = [];
                    $realisasi_this_month_summary_all_after = 0;
                    $realisasi_this_month_summary_all_before = 0;
                    $realisasi_until_this_month_summary_all_after = 0;
                    $realisasi_until_this_month_summary_all_before = 0;
                    $realisasi_until_last_month_summary_all_after = 0;
                    $realisasi_until_last_month_summary_all_before = 0;
                    foreach ($children_summary_all as $item_1) {
                        //   $explode_number_children_summary_all = explode(".", $item_1->number);
                        //   $implode_number_children_summary_all = implode("", $explode_number_children_summary_all);
                        //   $substr_number_children_summary_all = substr($implode_number_children_summary_all, 0, count($explode_number_parent_summary_all));
                        $explode_number = explode($item->number, $item_1->number);
                        if ($explode_number[0] == '') {
                            if ($item_1->number != '4.1.04.15') {
                                $realisasi_this_month_summary_all_after += $item_1->realisasi_this_month_after->sum('value');
                                $realisasi_this_month_summary_all_before += $item_1->realisasi_this_month_before->sum('value');
                                $realisasi_until_this_month_summary_all_after += $item_1->realisasi_until_this_month_after->sum('value');
                                $realisasi_until_this_month_summary_all_before += $item_1->realisasi_until_this_month_before->sum('value');
                                $realisasi_until_last_month_summary_all_after += $item_1->realisasi_until_last_month_after->sum('value');
                                $realisasi_until_last_month_summary_all_before += $item_1->realisasi_until_last_month_before->sum('value');
                            }
                            array_push($array_children_summary_all, $item_1->id);
                        }
                    }
                    if ($change_summary_all == 'sebelum_perubahan') {
                        $target_summary_all = Account::whereIn('id', $array_children_summary_all)->sum('target_before');
                    } else {
                        $target_summary_all = Account::whereIn('id', $array_children_summary_all)->sum('target_after');
                    }
                    $collection_summary_all = collect([
                        'id' => $item->id,
                        'number' => $item->number,
                        'order_number' => $item->order_number,
                        'name' => $item->name,
                        'target' => $target_summary_all,
                        'realisasi_this_month_after' => $realisasi_this_month_summary_all_after,
                        'realisasi_this_month_before' => $realisasi_this_month_summary_all_before,
                        'realisasi_until_this_month_after' => $realisasi_until_this_month_summary_all_after,
                        'realisasi_until_this_month_before' => $realisasi_until_this_month_summary_all_before,
                        'realisasi_until_last_month_after' => $realisasi_until_last_month_summary_all_after,
                        'realisasi_until_last_month_before' => $realisasi_until_last_month_summary_all_before,
                        'legal_basis' => $item->legal_basis,
                        'description' => $item->description
                    ]);
                    array_push($array_summary_all, $collection_summary_all);
                }
            }
        }

        // GET DATA SUMMARY RED
        if (isset($_GET['change_summary_red']) != null) {
            $change_summary_red = $_GET['change_summary_red'];
            if (isset($_GET['start_date_summary_red']) != null) {
                $start_date_summary_red = $_GET['start_date_summary_red'];
                $end_date_summary_red = $_GET['end_date_summary_red'];

                $data['start_date_summary_red'] = $start_date_summary_red;
                $data['end_date_summary_red'] = $end_date_summary_red;

                $split_start_date_summary_red = explode('-', $start_date_summary_red);
                $split_end_date_summary_red = explode('-', $end_date_summary_red);

                if (Auth::user()->role->all_users_data == 1) {
                    $data['account_summary_red'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_red = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_red = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                } else {
                    $data['account_summary_red'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_red = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_red = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                }
                foreach ($parent_summary_red as $item) {
                    // $explode_number_parent_summary_red = explode(".", $item->number);
                    // $implode_number_parent_summary_red = implode("", $explode_number_parent_summary_red);
                    $array_children_summary_red = [];
                    $realisasi_this_month_summary_red_after = 0;
                    $realisasi_this_month_summary_red_before = 0;
                    $realisasi_until_this_month_summary_red_after = 0;
                    $realisasi_until_this_month_summary_red_before = 0;
                    $realisasi_until_last_month_summary_red_after = 0;
                    $realisasi_until_last_month_summary_red_before = 0;
                    foreach ($children_summary_red as $item_1) {
                        //   $explode_number_children_summary_red = explode(".", $item_1->number);
                        //   $implode_number_children_summary_red = implode("", $explode_number_children_summary_red);
                        //   $substr_number_children_summary_red = substr($implode_number_children_summary_red, 0, count($explode_number_parent_summary_red));
                        $explode_number = explode($item->number, $item_1->number);
                        if ($explode_number[0] == '') {
                            if ($item_1->number != '4.1.04.15') {
                                $realisasi_this_month_summary_red_after += $item_1->realisasi_this_month_after->sum('value');
                                $realisasi_this_month_summary_red_before += $item_1->realisasi_this_month_before->sum('value');
                                $realisasi_until_this_month_summary_red_after += $item_1->realisasi_until_this_month_after->sum('value');
                                $realisasi_until_this_month_summary_red_before += $item_1->realisasi_until_this_month_before->sum('value');
                                $realisasi_until_last_month_summary_red_after += $item_1->realisasi_until_last_month_after->sum('value');
                                $realisasi_until_last_month_summary_red_before += $item_1->realisasi_until_last_month_before->sum('value');
                            }
                            array_push($array_children_summary_red, $item_1->id);
                        }
                    }
                    if ($change_summary_red == 'sebelum_perubahan') {
                        $target_summary_red = Account::whereIn('id', $array_children_summary_red)->sum('target_before');
                    } else {
                        $target_summary_red = Account::whereIn('id', $array_children_summary_red)->sum('target_after');
                    }
                    $collection_summary_red = collect([
                        'id' => $item->id,
                        'number' => $item->number,
                        'name' => $item->name,
                        'target' => $target_summary_red,
                        'order_number' => $item->order_number,
                        'realisasi_this_month_after' => $realisasi_this_month_summary_red_after,
                        'realisasi_this_month_before' => $realisasi_this_month_summary_red_before,
                        'realisasi_until_this_month_after' => $realisasi_until_this_month_summary_red_after,
                        'realisasi_until_this_month_before' => $realisasi_until_this_month_summary_red_before,
                        'realisasi_until_last_month_after' => $realisasi_until_last_month_summary_red_after,
                        'realisasi_until_last_month_before' => $realisasi_until_last_month_summary_red_before,
                        'legal_basis' => $item->legal_basis,
                        'description' => $item->description,
                        'mark' => $item->mark_2,
                    ]);
                    array_push($array_summary_red, $collection_summary_red);
                }
            }
        }

        // GET DATA SUMMARY GREEN
        if (isset($_GET['change_summary_green']) != null) {
            $change_summary_green = $_GET['change_summary_green'];
            if (isset($_GET['start_date_summary_green']) != null) {
                $start_date_summary_green = $_GET['start_date_summary_green'];
                $end_date_summary_green = $_GET['end_date_summary_green'];

                $data['start_date_summary_green'] = $start_date_summary_green;
                $data['end_date_summary_green'] = $end_date_summary_green;

                $split_start_date_summary_green = explode('-', $start_date_summary_green);
                $split_end_date_summary_green = explode('-', $end_date_summary_green);

                if (Auth::user()->role->all_users_data == 1) {
                    $data['account_summary_green'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_green = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_green = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                } else {
                    $data['account_summary_green'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_green = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_green = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                }
                foreach ($parent_summary_green as $item) {
                    // $explode_number_parent_summary_green = explode(".", $item->number);
                    // $implode_number_parent_summary_green = implode("", $explode_number_parent_summary_green);
                    $array_children_summary_green = [];
                    $realisasi_this_month_summary_green_after = 0;
                    $realisasi_this_month_summary_green_before = 0;
                    $realisasi_until_this_month_summary_green_after = 0;
                    $realisasi_until_this_month_summary_green_before = 0;
                    $realisasi_until_last_month_summary_green_after = 0;
                    $realisasi_until_last_month_summary_green_before = 0;
                    foreach ($children_summary_green as $item_1) {
                        //   $explode_number_children_summary_green = explode(".", $item_1->number);
                        //   $implode_number_children_summary_green = implode("", $explode_number_children_summary_green);
                        //   $substr_number_children_summary_green = substr($implode_number_children_summary_green, 0, count($explode_number_parent_summary_green));
                        $explode_number = explode($item->number, $item_1->number);
                        if ($explode_number[0] == '') {
                            if ($item_1->number != '4.1.04.15') {
                                $realisasi_this_month_summary_green_after += $item_1->realisasi_this_month_after->sum('value');
                                $realisasi_this_month_summary_green_before += $item_1->realisasi_this_month_before->sum('value');
                                $realisasi_until_this_month_summary_green_after += $item_1->realisasi_until_this_month_after->sum('value');
                                $realisasi_until_this_month_summary_green_before += $item_1->realisasi_until_this_month_before->sum('value');
                                $realisasi_until_last_month_summary_green_after += $item_1->realisasi_until_last_month_after->sum('value');
                                $realisasi_until_last_month_summary_green_before += $item_1->realisasi_until_last_month_before->sum('value');
                            }
                            array_push($array_children_summary_green, $item_1->id);
                        }
                    }
                    if ($change_summary_green == 'sebelum_perubahan') {
                        $target_summary_green = Account::whereIn('id', $array_children_summary_green)->sum('target_before');
                    } else {
                        $target_summary_green = Account::whereIn('id', $array_children_summary_green)->sum('target_after');
                    }
                    $collection_summary_green = collect([
                        'id' => $item->id,
                        'number' => $item->number,
                        'name' => $item->name,
                        'target' => $target_summary_green,
                        'order_number' => $item->order_number,
                        'realisasi_this_month_after' => $realisasi_this_month_summary_green_after,
                        'realisasi_this_month_before' => $realisasi_this_month_summary_green_before,
                        'realisasi_until_this_month_after' => $realisasi_until_this_month_summary_green_after,
                        'realisasi_until_this_month_before' => $realisasi_until_this_month_summary_green_before,
                        'realisasi_until_last_month_after' => $realisasi_until_last_month_summary_green_after,
                        'realisasi_until_last_month_before' => $realisasi_until_last_month_summary_green_before,
                        'legal_basis' => $item->legal_basis,
                        'description' => $item->description,
                        'mark' => $item->mark_1,
                    ]);
                    array_push($array_summary_green, $collection_summary_green);
                }
            }
        }

        // GET DATA INCOME
        $skpd_income = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        $array_income_final_3 = [];
        foreach ($skpd_income as $skpd) {
            $array_income_final_2 = [];
            $array_income_final = [];
            $array_income = [];
            //   $collection_income = [];
            array_push($array_income_final_2, $skpd->name);
            if (isset($_GET['change_income']) != null) {
                $change_income = $_GET['change_income'];
                if (isset($_GET['start_date_income']) != null) {
                    $start_date_income = $_GET['start_date_income'];
                    $end_date_income = $_GET['end_date_income'];

                    $data['start_date_income'] = $start_date_income;
                    $data['end_date_income'] = $end_date_income;

                    $split_start_date_income = explode('-', $start_date_income);
                    $split_end_date_income = explode('-', $end_date_income);

                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account_income'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent_income = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children_income = Account::with([
                            'children',
                            'skpd_accounts',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    } else {
                        $data['account_income'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent_income = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children_income = Account::with([
                            'children',
                            'skpd_accounts',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    }
                    //   $childrens_income = Account::with(['children', 'realisasi_this_month' => function($q) use($split_date_income){
                    //     $q->whereMonth('date', $split_date_income[1]);
                    //   }, 'realisasi_until_this_month' => function($q) use($split_date_income){
                    //     $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date_income[1]);
                    //   }, 'realisasi_until_last_month' => function($q) use($split_date_income){
                    //     $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date_income[1] - 1);
                    //   }])
                    //   ->whereDoesntHave('children')
                    //   ->whereHas('skpd_accounts', function($q) use($skpd){
                    //     $q->where('skpd_id', $skpd->id);
                    //   })
                    //   ->where('year', Auth::user()->year)
                    //   ->get();


                    foreach ($parent_income as $item) {
                        // $explode_number_parent_income = explode(".", $item->number);
                        // $implode_number_parent_income = implode("", $explode_number_parent_income);
                        $array_children_income = [];
                        $realisasi_this_month_income = 0;
                        $realisasi_until_this_month_income = 0;
                        $realisasi_until_last_month_income = 0;
                        foreach ($children_income as $item_1) {
                            //   $explode_number_children_income = explode(".", $item_1->number);
                            //   $implode_number_children_income = implode("", $explode_number_children_income);
                            //   $substr_number_children_income = substr($implode_number_children_income, 0, count($explode_number_parent_income));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month_income += $item_1->realisasi_this_month->sum('value');
                                    $realisasi_until_this_month_income += $item_1->realisasi_until_this_month->sum('value');
                                    $realisasi_until_last_month_income += $item_1->realisasi_until_last_month->sum('value');
                                }
                                array_push($array_children_income, $item_1->id);
                            }
                        }
                        if ($change_income == 'tidak') {
                            $target_income = Account::whereIn('id', $array_children_income)->sum('target_before');
                        } else {
                            $target_income = Account::whereIn('id', $array_children_income)->sum('target_after');
                        }
                        $collection_income = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target_income, 'realisasi_this_month' => $realisasi_this_month_income, 'realisasi_until_this_month' => $realisasi_until_this_month_income, 'realisasi_until_last_month' => $realisasi_until_last_month_income]);
                        array_push($array_income, $collection_income);
                    }
                    foreach ($array_income as $item) {
                        if ($item['target'] != 0) {
                            array_push($array_income_final, $item);
                        }
                    }
                    foreach ($children_income as $item) {
                        if ($change_income == 'tidak') {
                            $target_income = Account::where('id', $item->id)->sum('target_before');
                        } else {
                            $target_income = Account::where('id', $item->id)->sum('target_after');
                        }
                        $collection_income = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target_income, 'realisasi_this_month' => $item->realisasi_this_month->sum('value'), 'realisasi_until_this_month' => $item->realisasi_until_this_month->sum('value'), 'realisasi_until_last_month' => $item->realisasi_until_last_month->sum('value')]);
                        array_push($array_income_final, $collection_income);
                    }
                }
            }
            array_push($array_income_final_2, $array_income_final);
            array_push($array_income_final_3, $array_income_final_2);
        }

        //   dd($array_income_final_3);

        // SUMMARY ALL
        $data['array_summary_all'] = $array_summary_all;
        $data['change_summary_all'] = $change_summary_all;
        // $data['date_summary_all'] = $date_summary_all;
        // if($date_summary_all != null)
        // {
        //   $data['month_summary_all'] = $this->getMonth($split_date_summary_all[1]);
        // }

        // SUMMARY RED
        $data['array_summary_red'] = $array_summary_red;
        $data['change_summary_red'] = $change_summary_red;
        // $data['date_summary_red'] = $date_summary_red;
        // if($date_summary_red != null)
        // {
        //   $data['month_summary_red'] = $this->getMonth($split_date_summary_red[1]);
        // }

        // SUMMARY GREEN
        $data['array_summary_green'] = $array_summary_green;
        $data['change_summary_green'] = $change_summary_green;
        // $data['date_summary_green'] = $date_summary_green;
        // if($date_summary_green != null)
        // {
        //   $data['month_summary_green'] = $this->getMonth($split_date_summary_green[1]);
        // }

        // INCOME
        $data['income'] = $array_income_final_3;
        // dd($data['income']);
        $data['skpd_income'] = $skpd_income;
        // if($date_income != null)
        // {
        //   $data['month_income'] = $this->getMonth($split_date_income[1]);
        // }
        // $data['date_income'] = $date_income;
        $data['change_income'] = $change_income;

        return view('pages.report.overall.index', $data);
    }

    public function printOverall()
    {

        $data['n'] = 1;
        $data['ttgl'] = request('ttgl');

        // SUMMARY ALL
        $change_summary_all = null;
        $date_summary_all = null;
        $start_date_summary_all = null;
        $end_date_summary_all = null;
        $array_summary_all = [];
        $data['account_summary_all'] = [];
        $data['month_summary_all'] = null;
        $data['start_date_summary'] = null;
        $data['end_date_summary'] = null;

        // SUMMARY RED
        $change_summary_red = null;
        $date_summary_red = null;
        $start_date_summary_red = null;
        $end_date_summary_red = null;
        $array_summary_red = [];
        $data['account_summary_red'] = [];
        $data['month_summary_red'] = null;
        $data['start_date_summary_red'] = null;
        $data['end_date_summary_red'] = null;

        // SUMMARY GREEN
        $change_summary_green = null;
        $date_summary_green = null;
        $start_date_summary_green = null;
        $end_date_summary_green = null;
        $array_summary_green = [];
        $data['account_summary_green'] = [];
        $data['month_summary_green'] = null;
        $data['start_date_summary_green'] = null;
        $data['end_date_summary_green'] = null;

        // INCOME
        $skpd_income = null;
        $id_skpd_income = null;
        $change_income = null;
        $date_income = null;
        $start_date_income = null;
        $end_date_income = null;
        $array_income = [];
        $array_income_final = [];
        $data['account_income'] = [];
        $data['month_income'] = null;
        $data['start_date_income'] = null;
        $data['end_date_income'] = null;
        $data['filter_skpd_income'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();

        // GET DATA SUMMARY ALL
        if (isset($_GET['change_summary_all']) != null) {
            $change_summary_all = $_GET['change_summary_all'];
            if (isset($_GET['start_date_summary']) != null) {
                $start_date_summary_all = $_GET['start_date_summary'];
                $end_date_summary_all = $_GET['end_date_summary'];

                $data['start_date_summary'] = $start_date_summary_all;
                $data['end_date_summary'] = $end_date_summary_all;

                $split_start_date_summary_all = explode('-', $start_date_summary_all);
                $split_end_date_summary_all = explode('-', $end_date_summary_all);

                if (Auth::user()->role->all_users_data == 1) {
                    $data['account_summary_all'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                } else {
                    $data['account_summary_all'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                }
                $parent_summary_all = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                    ->get();
                $children_summary_all = Account::with([
                    'children',
                    'realisasi_this_month_after' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                        $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                    },
                    'realisasi_this_month_before' => function ($q) use ($start_date_summary_all, $end_date_summary_all) {
                        $q->whereBetween('date', [$start_date_summary_all, $end_date_summary_all]);
                    },
                    'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_all) {
                        $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_all);
                    },
                    'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_all) {
                        $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_all);
                    },
                    'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_all) {
                        $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_all[1] - 1);
                    },
                    'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_all) {
                        $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_all[1] - 1);
                    }
                ])
                    ->where('year', Auth::user()->year)
                    ->get();
                foreach ($parent_summary_all as $item) {
                    // $explode_number_parent_summary_all = explode(".", $item->number);
                    // $implode_number_parent_summary_all = implode("", $explode_number_parent_summary_all);
                    $array_children_summary_all = [];
                    $realisasi_this_month_summary_all_after = 0;
                    $realisasi_this_month_summary_all_before = 0;
                    $realisasi_until_this_month_summary_all_after = 0;
                    $realisasi_until_this_month_summary_all_before = 0;
                    $realisasi_until_last_month_summary_all_after = 0;
                    $realisasi_until_last_month_summary_all_before = 0;
                    foreach ($children_summary_all as $item_1) {
                        //   $explode_number_children_summary_all = explode(".", $item_1->number);
                        //   $implode_number_children_summary_all = implode("", $explode_number_children_summary_all);
                        //   $substr_number_children_summary_all = substr($implode_number_children_summary_all, 0, count($explode_number_parent_summary_all));
                        $explode_number = explode($item->number, $item_1->number);
                        if ($explode_number[0] == '') {
                            if ($item_1->number != '4.1.04.15') {
                                $realisasi_this_month_summary_all_after += $item_1->realisasi_this_month_after->sum('value');
                                $realisasi_this_month_summary_all_before += $item_1->realisasi_this_month_before->sum('value');
                                $realisasi_until_this_month_summary_all_after += $item_1->realisasi_until_this_month_after->sum('value');
                                $realisasi_until_this_month_summary_all_before += $item_1->realisasi_until_this_month_before->sum('value');
                                $realisasi_until_last_month_summary_all_after += $item_1->realisasi_until_last_month_after->sum('value');
                                $realisasi_until_last_month_summary_all_before += $item_1->realisasi_until_last_month_before->sum('value');
                            }
                            array_push($array_children_summary_all, $item_1->id);
                        }
                    }
                    if ($change_summary_all == 'sebelum_perubahan') {
                        $target_summary_all = Account::whereIn('id', $array_children_summary_all)->sum('target_before');
                    } else {
                        $target_summary_all = Account::whereIn('id', $array_children_summary_all)->sum('target_after');
                    }
                    $collection_summary_all = collect([
                        'id' => $item->id,
                        'number' => $item->number,
                        'order_number' => $item->order_number,
                        'name' => $item->name,
                        'target' => $target_summary_all,
                        'realisasi_this_month_after' => $realisasi_this_month_summary_all_after,
                        'realisasi_this_month_before' => $realisasi_this_month_summary_all_before,
                        'realisasi_until_this_month_after' => $realisasi_until_this_month_summary_all_after,
                        'realisasi_until_this_month_before' => $realisasi_until_this_month_summary_all_before,
                        'realisasi_until_last_month_after' => $realisasi_until_last_month_summary_all_after,
                        'realisasi_until_last_month_before' => $realisasi_until_last_month_summary_all_before,
                        'legal_basis' => $item->legal_basis,
                        'description' => $item->description
                    ]);
                    array_push($array_summary_all, $collection_summary_all);
                }
            }
        }

        // GET DATA SUMMARY RED
        if (isset($_GET['change_summary_red']) != null) {
            $change_summary_red = $_GET['change_summary_red'];
            if (isset($_GET['start_date_summary_red']) != null) {
                $start_date_summary_red = $_GET['start_date_summary_red'];
                $end_date_summary_red = $_GET['end_date_summary_red'];

                $data['start_date_summary_red'] = $start_date_summary_red;
                $data['end_date_summary_red'] = $end_date_summary_red;

                $split_start_date_summary_red = explode('-', $start_date_summary_red);
                $split_end_date_summary_red = explode('-', $end_date_summary_red);

                if (Auth::user()->role->all_users_data == 1) {
                    $data['account_summary_red'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_red = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_red = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                } else {
                    $data['account_summary_red'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_red = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_red = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_red, $end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_red, $end_date_summary_red]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_red);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_red);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_red[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_red) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_red[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                }
                foreach ($parent_summary_red as $item) {
                    // $explode_number_parent_summary_red = explode(".", $item->number);
                    // $implode_number_parent_summary_red = implode("", $explode_number_parent_summary_red);
                    $array_children_summary_red = [];
                    $realisasi_this_month_summary_red_after = 0;
                    $realisasi_this_month_summary_red_before = 0;
                    $realisasi_until_this_month_summary_red_after = 0;
                    $realisasi_until_this_month_summary_red_before = 0;
                    $realisasi_until_last_month_summary_red_after = 0;
                    $realisasi_until_last_month_summary_red_before = 0;
                    foreach ($children_summary_red as $item_1) {
                        //   $explode_number_children_summary_red = explode(".", $item_1->number);
                        //   $implode_number_children_summary_red = implode("", $explode_number_children_summary_red);
                        //   $substr_number_children_summary_red = substr($implode_number_children_summary_red, 0, count($explode_number_parent_summary_red));
                        $explode_number = explode($item->number, $item_1->number);
                        if ($explode_number[0] == '') {
                            if ($item_1->number != '4.1.04.15') {
                                $realisasi_this_month_summary_red_after += $item_1->realisasi_this_month_after->sum('value');
                                $realisasi_this_month_summary_red_before += $item_1->realisasi_this_month_before->sum('value');
                                $realisasi_until_this_month_summary_red_after += $item_1->realisasi_until_this_month_after->sum('value');
                                $realisasi_until_this_month_summary_red_before += $item_1->realisasi_until_this_month_before->sum('value');
                                $realisasi_until_last_month_summary_red_after += $item_1->realisasi_until_last_month_after->sum('value');
                                $realisasi_until_last_month_summary_red_before += $item_1->realisasi_until_last_month_before->sum('value');
                            }
                            array_push($array_children_summary_red, $item_1->id);
                        }
                    }
                    if ($change_summary_red == 'sebelum_perubahan') {
                        $target_summary_red = Account::whereIn('id', $array_children_summary_red)->sum('target_before');
                    } else {
                        $target_summary_red = Account::whereIn('id', $array_children_summary_red)->sum('target_after');
                    }
                    $collection_summary_red = collect([
                        'id' => $item->id,
                        'number' => $item->number,
                        'name' => $item->name,
                        'target' => $target_summary_red,
                        'order_number' => $item->order_number,
                        'realisasi_this_month_after' => $realisasi_this_month_summary_red_after,
                        'realisasi_this_month_before' => $realisasi_this_month_summary_red_before,
                        'realisasi_until_this_month_after' => $realisasi_until_this_month_summary_red_after,
                        'realisasi_until_this_month_before' => $realisasi_until_this_month_summary_red_before,
                        'realisasi_until_last_month_after' => $realisasi_until_last_month_summary_red_after,
                        'realisasi_until_last_month_before' => $realisasi_until_last_month_summary_red_before,
                        'legal_basis' => $item->legal_basis,
                        'description' => $item->description,
                        'mark' => $item->mark_2,
                    ]);
                    array_push($array_summary_red, $collection_summary_red);
                }
            }
        }

        // GET DATA SUMMARY GREEN
        if (isset($_GET['change_summary_green']) != null) {
            $change_summary_green = $_GET['change_summary_green'];
            if (isset($_GET['start_date_summary_green']) != null) {
                $start_date_summary_green = $_GET['start_date_summary_green'];
                $end_date_summary_green = $_GET['end_date_summary_green'];

                $data['start_date_summary_green'] = $start_date_summary_green;
                $data['end_date_summary_green'] = $end_date_summary_green;

                $split_start_date_summary_green = explode('-', $start_date_summary_green);
                $split_end_date_summary_green = explode('-', $end_date_summary_green);


                if (Auth::user()->role->all_users_data == 1) {
                    $data['account_summary_green'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_green = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_green = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                } else {
                    $data['account_summary_green'] = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->where('year', Auth::user()->year)->orderBy('number', 'asc')
                        ->get();
                    $parent_summary_green = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)
                        ->get();
                    $children_summary_green = Account::with([
                        'children',
                        'realisasi_this_month_after' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_this_month_before' => function ($q) use ($start_date_summary_green, $end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_summary_green, $end_date_summary_green]);
                        },
                        'realisasi_until_this_month_after' => function ($q) use ($end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_summary_green);
                        },
                        'realisasi_until_this_month_before' => function ($q) use ($start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $start_date_summary_green);
                        },
                        'realisasi_until_last_month_after' => function ($q) use ($split_end_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_end_date_summary_green[1] - 1);
                        },
                        'realisasi_until_last_month_before' => function ($q) use ($split_start_date_summary_green) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_summary_green[1] - 1);
                        }
                    ])->with('children')
                        ->where('year', Auth::user()->year)
                        ->get();
                }
                foreach ($parent_summary_green as $item) {
                    // $explode_number_parent_summary_green = explode(".", $item->number);
                    // $implode_number_parent_summary_green = implode("", $explode_number_parent_summary_green);
                    $array_children_summary_green = [];
                    $realisasi_this_month_summary_green_after = 0;
                    $realisasi_this_month_summary_green_before = 0;
                    $realisasi_until_this_month_summary_green_after = 0;
                    $realisasi_until_this_month_summary_green_before = 0;
                    $realisasi_until_last_month_summary_green_after = 0;
                    $realisasi_until_last_month_summary_green_before = 0;
                    foreach ($children_summary_green as $item_1) {
                        //   $explode_number_children_summary_green = explode(".", $item_1->number);
                        //   $implode_number_children_summary_green = implode("", $explode_number_children_summary_green);
                        //   $substr_number_children_summary_green = substr($implode_number_children_summary_green, 0, count($explode_number_parent_summary_green));
                        $explode_number = explode($item->number, $item_1->number);
                        if ($explode_number[0] == '') {
                            if ($item_1->number != '4.1.04.15') {
                                $realisasi_this_month_summary_green_after += $item_1->realisasi_this_month_after->sum('value');
                                $realisasi_this_month_summary_green_before += $item_1->realisasi_this_month_before->sum('value');
                                $realisasi_until_this_month_summary_green_after += $item_1->realisasi_until_this_month_after->sum('value');
                                $realisasi_until_this_month_summary_green_before += $item_1->realisasi_until_this_month_before->sum('value');
                                $realisasi_until_last_month_summary_green_after += $item_1->realisasi_until_last_month_after->sum('value');
                                $realisasi_until_last_month_summary_green_before += $item_1->realisasi_until_last_month_before->sum('value');
                            }
                            array_push($array_children_summary_green, $item_1->id);
                        }
                    }
                    if ($change_summary_green == 'sebelum_perubahan') {
                        $target_summary_green = Account::whereIn('id', $array_children_summary_green)->sum('target_before');
                    } else {
                        $target_summary_green = Account::whereIn('id', $array_children_summary_green)->sum('target_after');
                    }
                    $collection_summary_green = collect([
                        'id' => $item->id,
                        'number' => $item->number,
                        'name' => $item->name,
                        'target' => $target_summary_green,
                        'order_number' => $item->order_number,
                        'realisasi_this_month_after' => $realisasi_this_month_summary_green_after,
                        'realisasi_this_month_before' => $realisasi_this_month_summary_green_before,
                        'realisasi_until_this_month_after' => $realisasi_until_this_month_summary_green_after,
                        'realisasi_until_this_month_before' => $realisasi_until_this_month_summary_green_before,
                        'realisasi_until_last_month_after' => $realisasi_until_last_month_summary_green_after,
                        'realisasi_until_last_month_before' => $realisasi_until_last_month_summary_green_before,
                        'legal_basis' => $item->legal_basis,
                        'description' => $item->description,
                        'mark' => $item->mark_1,
                    ]);
                    array_push($array_summary_green, $collection_summary_green);
                }
            }
        }

        // GET DATA INCOME
        $skpd_income = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        $array_income_final_3 = [];
        foreach ($skpd_income as $skpd) {
            $array_income_final_2 = [];
            $array_income_final = [];
            $array_income = [];
            array_push($array_income_final_2, $skpd->name);
            if (isset($_GET['change_income']) != null) {
                $change_income = $_GET['change_income'];
                if (isset($_GET['start_date_income']) != null) {
                    $start_date_income = $_GET['start_date_income'];
                    $end_date_income = $_GET['end_date_income'];

                    $data['start_date_income'] = $start_date_income;
                    $data['end_date_income'] = $end_date_income;

                    $split_start_date_income = explode('-', $start_date_income);
                    $split_end_date_income = explode('-', $end_date_income);

                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account_income'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent_income = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children_income = Account::with([
                            'children',
                            'skpd_accounts',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                        $childrens_income = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereDoesntHave('children')
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    } else {
                        $data['account_income'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)->orderBy('number', 'asc')
                            ->get();
                        $parent_income = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children_income = Account::with([
                            'children',
                            'skpd_accounts',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                        $childrens_income = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($start_date_income, $end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$start_date_income, $end_date_income]);
                            },
                            'realisasi_until_this_month' => function ($q) use ($end_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $end_date_income[1]);
                            },
                            'realisasi_until_last_month' => function ($q) use ($split_start_date_income) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_start_date_income[1] - 1);
                            }
                        ])
                            ->whereDoesntHave('children')
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd->id);
                            })
                            ->where('year', Auth::user()->year)
                            ->get();
                    }

                    foreach ($parent_income as $item) {
                        // $explode_number_parent_income = explode(".", $item->number);
                        // $implode_number_parent_income = implode("", $explode_number_parent_income);
                        $array_children_income = [];
                        $realisasi_this_month_income = 0;
                        $realisasi_until_this_month_income = 0;
                        $realisasi_until_last_month_income = 0;
                        foreach ($children_income as $item_1) {
                            //   $explode_number_children_income = explode(".", $item_1->number);
                            //   $implode_number_children_income = implode("", $explode_number_children_income);
                            //   $substr_number_children_income = substr($implode_number_children_income, 0, count($explode_number_parent_income));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month_income += $item_1->realisasi_this_month->sum('value');
                                    $realisasi_until_this_month_income += $item_1->realisasi_until_this_month->sum('value');
                                    $realisasi_until_last_month_income += $item_1->realisasi_until_last_month->sum('value');
                                }
                                array_push($array_children_income, $item_1->id);
                            }
                        }
                        if ($change_income == 'tidak') {
                            $target_income = Account::whereIn('id', $array_children_income)->sum('target_before');
                        } else {
                            $target_income = Account::whereIn('id', $array_children_income)->sum('target_after');
                        }
                        $collection_income = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target_income, 'realisasi_this_month' => $realisasi_this_month_income, 'realisasi_until_this_month' => $realisasi_until_this_month_income, 'realisasi_until_last_month' => $realisasi_until_last_month_income]);
                        array_push($array_income, $collection_income);
                    }
                    foreach ($array_income as $item) {
                        if ($item['target'] != 0) {
                            array_push($array_income_final, $item);
                        }
                    }
                    foreach ($children_income as $item) {
                        if ($change_income == 'tidak') {
                            $target_income = Account::where('id', $item->id)->sum('target_before');
                        } else {
                            $target_income = Account::where('id', $item->id)->sum('target_after');
                        }
                        $collection_income = collect(['id' => $item->id, 'number' => $item->number, 'order_number' => $item->order_number, 'name' => $item->name, 'target' => $target_income, 'realisasi_this_month' => $item->realisasi_this_month->sum('value'), 'realisasi_until_this_month' => $item->realisasi_until_this_month->sum('value'), 'realisasi_until_last_month' => $item->realisasi_until_last_month->sum('value')]);
                        array_push($array_income_final, $collection_income);
                    }
                }
            }
            array_push($array_income_final_2, $array_income_final);
            array_push($array_income_final_3, $array_income_final_2);
        }

        // SUMMARY ALL
        $data['array_summary_all'] = $array_summary_all;
        $data['change_summary_all'] = $change_summary_all;

        // SUMMARY RED
        $data['array_summary_red'] = $array_summary_red;
        $data['change_summary_red'] = $change_summary_red;

        // SUMMARY GREEN
        $data['array_summary_green'] = $array_summary_green;
        $data['change_summary_green'] = $change_summary_green;

        // INCOME
        $data['income'] = $array_income_final_3;
        $data['skpd_income'] = $skpd_income;
        $data['change_income'] = $change_income;

        return view('pages.report.overall.print', $data);
    }

    //////////////////////////////////////WP/WR///////////////////////////////
    public function indexWpWr()
    {
        $account = null;
        $date = null;
        $data['tahun'] = null;
        $data['month'] = null;
        $data['wp_wr'] = [];
        $data['skpd_account'] = [];
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['account'] = null;
        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();

        if (isset($_GET['account']) != null) {
            $account = $_GET['account'];
            $data['account'] = $account;
            $parent_id = explode("-", $account);

            if (request('account_id') != 0 || $account != null || $account != '') {
                if (isset($_GET['tahun'])) {
                    $account = Account::where('year', $_GET['tahun'])->where('number', $parent_id[0])->pluck('id')->first();
                } else {
                    $account = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
                }
            }

            if ($_GET['date'] != null && $_GET['date'] != '') {
                $date = $_GET['date'];
                $split_date = explode('-', $date);

                if (Auth::user()->role->all_users_data == 1) {
                    $data['wp_wr'] = Journal::where('account_id', $account)->whereMonth('date', $split_date[1])->whereYear('date', $split_date[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where([['account_id', $account], ['last_year', 0]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where([['account_id', $account], ['last_year', 1]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                } else {
                    $data['wp_wr'] = Journal::where('user_id', Auth::user()->id)->where('account_id', $account)->whereMonth('date', $split_date[1])->whereYear('date', $split_date[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 0]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 1]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                }
            } else {

                if (Auth::user()->role->all_users_data == 1) {

                    $data['wp_wr'] = Journal::where('account_id', $account)->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where([['account_id', $account], ['last_year', 0]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where([['account_id', $account], ['last_year', 1]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                } else {

                    $data['wp_wr'] = Journal::where('user_id', Auth::user()->id)->where('account_id', $account)->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->get();

                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 0]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 1]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                }
            }
        }

        // dd($parent_id);
        if ($date != null && $date != '') {
            $data['month'] = $this->getMonth($split_date[1]);
        } else if (isset($_GET['tahun'])) {
            $data['month'] = $_GET['tahun'];
            $data['tahun'] = $_GET['tahun'];
        }
        $data['date'] = $date;

        $data['n'] = 1;

        return view('pages.report.wp-wr.index', $data);
    }

    public function printWpWr()
    {

        $account = null;
        $date = null;
        $data['month'] = null;
        $data['wp_wr'] = [];
        $data['skpd_account'] = [];
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['account'] = null;
        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();
        if (isset($_GET['account']) != null) {
            $account = $_GET['account'];
            $data['account'] = $account;
            $parent_id = explode("-", $account);
            if (request('account_id') != 0 || $account != null || $account != '') {
                if (isset($_GET['tahun'])) {
                    $account = Account::where('year', $_GET['tahun'])->where('number', $parent_id[0])->pluck('id')->first();
                } else {
                    $account = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
                }
            }
            if ($_GET['date'] != null && $_GET['date'] != '') {
                $date = $_GET['date'];
                $split_date = explode('-', $date);
                if (Auth::user()->role->all_users_data == 1) {
                    $data['wp_wr'] = Journal::where('account_id', $account)->whereMonth('date', $split_date[1])->whereYear('date', $split_date[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where([['account_id', $account], ['last_year', 0]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where([['account_id', $account], ['last_year', 1]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                } else {
                    $data['wp_wr'] = Journal::where('user_id', Auth::user()->id)->where('account_id', $account)->whereMonth('date', $split_date[1])->whereYear('date', $split_date[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 0]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 1]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                }
            } else {
                if (Auth::user()->role->all_users_data == 1) {
                    $data['wp_wr'] = Journal::where('account_id', $account)->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where([['account_id', $account], ['last_year', 0]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where([['account_id', $account], ['last_year', 1]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                } else {
                    $data['wp_wr'] = Journal::where('user_id', Auth::user()->id)->where('account_id', $account)->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 0]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 1]])->whereYear('date', $_GET['tahun'])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                }
            }
        }

        // dd($parent_id);
        if ($date != null && $date != '') {
            $data['month'] = $this->getMonth($split_date[1]);
        } else if (isset($_GET['tahun'])) {
            $data['month'] = $_GET['tahun'];
            $data['tahun'] = $_GET['tahun'];
        }
        $data['date'] = $date;

        $data['n'] = 1;
        return view('pages.report.wp-wr.print', $data);
    }

    public function exportWpWr()
    {
        return (new WpWrExport)
            ->account($_GET['account'])
            ->date($_GET['date'])
            ->tahun($_GET['tahun'])
            ->download('WP_WR' . '.xlsx');
    }

    public function exportOverall()
    {
        return (new OverallExport)
            ->change_summary_all($_GET['change_summary_all'])
            ->start_date_summary($_GET['start_date_summary'])
            ->end_date_summary($_GET['start_date_summary'])
            ->change_summary_red($_GET['change_summary_red'])
            ->start_date_summary_red($_GET['start_date_summary_red'])
            ->end_date_summary_red($_GET['end_date_summary_red'])
            ->change_summary_green($_GET['change_summary_green'])
            ->start_date_summary_green($_GET['start_date_summary_green'])
            ->end_date_summary_green($_GET['end_date_summary_green'])
            ->change_income($_GET['change_income'])
            ->start_date_income($_GET['start_date_income'])
            ->end_date_income($_GET['end_date_income'])
            ->download('Keseluruhan.xlsx');
    }

    public function getMonth($month)
    {
        if ($month == '01') {
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
}
