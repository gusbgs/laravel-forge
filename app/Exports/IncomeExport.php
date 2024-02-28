<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Account;
use App\Skpd;
use Auth;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class IncomeExport implements FromView, WithTitle, WithColumnFormatting
{

    use Exportable;

    private $skpd;
    private $change;
    private $startDate;
    private $endDate;

    public function __construct($skpd, $change, $startDate, $endDate)
    {
        $this->skpd = $skpd;
        $this->change = $change;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $skpd = $this->skpd;
        $id_skpd = $this->skpd;
        $change = $this->change;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $array_income = [];
        $array_income_final = [];
        $data['account'] = [];
        $data['month'] = null;
        $data['filter_skpd'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        if ($skpd != 0) {
            if ($change != null) {
                if ($startDate != null) {
                    $data['start_date'] = $startDate;
                    $data['end_date'] = $endDate;

                    $splitStartDate = explode('-', $startDate);
                    $splitEndDate = explode('-', $endDate);
                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->whereBetween('date', [$startDate, $endDate]);
                            }, 'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            }, 'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            ->get();
                        $parent = Account::with(['children', 'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                            $q->whereBetween('date', [$startDate, $endDate]);
                        }, 'realisasi_until_this_month' => function ($q) use ($endDate) {
                            $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                        }, 'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                        }])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                                $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                            }, 'realisasi_until_this_month' => function ($q) use ($endDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                            }, 'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                            }
                        ])
                            ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                                $q->where('skpd_id', $skpd);
                            })
                            ->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            ->get();
                        $parent = Account::with(['children', 'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                            $q->where('user_id', Auth::user()->id)->whereBetween('date', [$startDate, $endDate]);
                        }, 'realisasi_until_this_month' => function ($q) use ($endDate) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                        }, 'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                        }])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                    }
                    $children = Account::with(['children', 'realisasi_this_month' => function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('date', [$startDate, $endDate]);
                    }, 'realisasi_until_this_month' => function ($q) use ($endDate) {
                        $q->whereMonth('date', '>=', 01)->whereDate('date', '<=', $endDate);
                    }, 'realisasi_until_last_month' => function ($q) use ($splitEndDate) {
                        $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $splitEndDate[1] - 1);
                    }])
                        ->whereHas('skpd_accounts', function ($q) use ($skpd) {
                            $q->where('skpd_id', $skpd);
                        })
                        ->where('year', Auth::user()->year)
                        ->get();
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
                            //   $explode_number_children = explode(".", $item_1->number);
                            //   $implode_number_children = implode("", $explode_number_children);
                            //   $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month += $item_1->realisasi_this_month->sum('value');
                                    $realisasi_until_this_month += $item_1->realisasi_until_this_month->sum('value');
                                    $realisasi_until_last_month += $item_1->realisasi_until_last_month->sum('value');
                                    array_push($array_children, $item_1->id);
                                }
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
        } else {
            if ($change != null) {
                if ($date != null) {
                    $split_date = explode('-', $date);
                    if (Auth::user()->role->all_users_data == 1) {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($split_date) {
                                $q->whereMonth('date', $split_date[1]);
                            }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                            }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            ->get();
                        $parent = Account::with(['children', 'realisasi_this_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', $split_date[1]);
                        }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                        }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                        }])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children = Account::with(['children', 'realisasi_this_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', $split_date[1]);
                        }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                        }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                        }])
                            ->where('year', Auth::user()->year)
                            ->get();
                        $childrens = Account::with(['children', 'realisasi_this_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', $split_date[1]);
                        }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                        }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                            $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                        }])
                            ->whereDoesntHave('children')
                            ->where('year', Auth::user()->year)
                            ->get();
                    } else {
                        $data['account'] = Account::with([
                            'children',
                            'realisasi_this_month' => function ($q) use ($split_date) {
                                $q->whereMonth('date', $split_date[1]);
                            }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                                $q->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                            }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                                $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                            }
                        ])
                            ->where('year', Auth::user()->year)->orderBy('order_number', 'asc')
                            ->get();
                        $parent = Account::with(['children', 'realisasi_this_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', $split_date[1]);
                        }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                        }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                        }])
                            ->whereHas('children')->where('year', Auth::user()->year)
                            ->get();
                        $children = Account::with(['children', 'realisasi_this_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', $split_date[1]);
                        }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                        }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                        }])
                            ->where('year', Auth::user()->year)
                            ->get();
                        $childrens = Account::with(['children', 'realisasi_this_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', $split_date[1]);
                        }, 'realisasi_until_this_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1]);
                        }, 'realisasi_until_last_month' => function ($q) use ($split_date) {
                            $q->where('user_id', Auth::user()->id)->whereMonth('date', '>=', 01)->whereMonth('date', '<=', $split_date[1] - 1);
                        }])
                            ->whereDoesntHave('children')
                            ->where('year', Auth::user()->year)
                            ->get();
                    }

                    foreach ($parent as $item) {
                        // $explode_number_parent = explode(".", $item->number);
                        // $implode_number_parent = implode("", $explode_number_parent);
                        $array_children = [];
                        $realisasi_this_month = 0;
                        $realisasi_until_this_month = 0;
                        $realisasi_until_last_month = 0;
                        foreach ($children as $item_1) {
                            //   $explode_number_children = explode(".", $item_1->number);
                            //   $implode_number_children = implode("", $explode_number_children);
                            //   $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                            $explode_number = explode($item->number, $item_1->number);
                            if ($explode_number[0] == '') {
                                if ($item_1->number != '4.1.04.15') {
                                    $realisasi_this_month += $item_1->realisasi_this_month->sum('value');
                                    $realisasi_until_this_month += $item_1->realisasi_until_this_month->sum('value');
                                    $realisasi_until_last_month += $item_1->realisasi_until_last_month->sum('value');
                                    array_push($array_children, $item_1->id);
                                }
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
                    foreach ($childrens as $item) {
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
        $array_income_final = collect($array_income_final)->sortBy('order_number')->toArray();
        $data['income'] = $array_income_final;
        $data['skpd'] = $skpd;
        // if($date != null)
        // {
        //   $data['month'] = $this->getMonth($split_date[1]);
        // }
        // $data['date'] = $date;
        $data['change'] = $change;
        return view('pages.report.income.excel', $data);
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

    public function title(): string
    {
        return "Pendapatan";
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'M' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'O' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'Q' => NumberFormat::FORMAT_ACCOUNTING_IDR,
        ];
    }
}
