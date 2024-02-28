<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Account;
use Auth;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SummaryExport implements FromView, WithTitle, WithColumnFormatting
{

    use Exportable;

    private $change;
    private $type;
    private $startDate;
    private $endDate;
    private $title;

    public function __construct($change, $type, $start_date, $end_date, $title)
    {
        $this->change = $change;
        $this->type = $type;
        $this->startDate = $start_date;
        $this->endDate = $end_date;
        $this->title = $title;
    }

    public function view(): View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $splitStartDate = explode('-', $startDate);
        $splitEndDate = explode('-', $endDate);

        $change = $this->change;
        $type = $this->type;
        $array_summary = [];

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
                //   $explode_number_children = explode(".", $item_1->number);
                //   $implode_number_children = implode("", $explode_number_children);
                //   $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                $explode_number = explode($item->number, $item_1->number);
                if ($explode_number[0] == '') {
                    if ($item_1->number != '4.1.04.15') {
                        $realisasi_this_month_after += $item_1->realisasi_this_month_after->sum('value');
                        $realisasi_this_month_before += $item_1->realisasi_this_month_before->sum('value');
                        $realisasi_until_this_month_after += $item_1->realisasi_until_this_month_after->sum('value');
                        $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');
                        $realisasi_until_last_month_after += $item_1->realisasi_until_last_month_after->sum('value');
                        $realisasi_until_last_month_before += $item_1->realisasi_until_last_month_before->sum('value');
                        array_push($array_children, $item_1->id);
                    }
                }
            }
            if ($change == 'sebelum_perubahan') {
                $target = Account::whereIn('id', $array_children)->sum('target_before');
            } else {
                $target = Account::whereIn('id', $array_children)->sum('target_after');
            }
            $collection = collect([
                'id' => $item->id,
                'number' => $item->number,
                'order_number' => $item->order_number,
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

        $data['type'] = $type;
        $data['change'] = $change;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $array_summary = collect($array_summary)->sortBy('order_number')->toArray();
        $data['array_summary'] = $array_summary;


        return view('pages.report.summary.excel', $data);
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
        return $this->title;
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'I' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'K' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'M' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'O' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'Q' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'S' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'U' => NumberFormat::FORMAT_ACCOUNTING_IDR,
        ];
    }
}
