<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\SkpdAccount;
use App\Account;
use App\Journal;
use Auth;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class WpWrExport implements FromView, WithColumnFormatting
{

    use Exportable;

    public function account($account)
    {
        $this->account = $account;

        return $this;
    }

    public function date($date)
    {
        $this->date = $date;

        return $this;
    }

    public function tahun($tahun)
    {
        $this->tahun = $tahun;

        return $this;
    }

    public function view(): View
    {
        $account = $this->account;
        $date = $this->date;
        $tahun = $this->tahun;
        $data['month'] = null;
        $data['tahun'] = null;
        $data['wp_wr'] = [];
        $data['skpd_account'] = [];
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['account'] = null;
        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();
        if ($account != null) {
            $data['account'] = $account;
            $parent_id = explode("-", $account);
            if (request('account_id') != 0 || $account != null || $account != '') {
                if ($tahun != '' && $tahun != null) {
                    $account = Account::where('year', $tahun)->where('number', $parent_id[0])->pluck('id')->first();
                } else {
                    $account = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
                }
            }
            if ($date != null && $date != '') {
                $split_date = explode('-', $date);
                if (Auth::user()->role->all_users_data == 1) {
                    $data['wp_wr'] = Journal::where('account_id', $account)->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where([['account_id', $account], ['last_year', 0]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where([['account_id', $account], ['last_year', 1]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                } else {
                    $data['wp_wr'] = Journal::where('user_id', Auth::user()->id)->where('account_id', $account)->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 0]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 1]])->whereYear('date', $split_date[0])->whereMonth('date', $split_date[1])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                }
            } else {
                if (Auth::user()->role->all_users_data == 1) {
                    $data['wp_wr'] = Journal::where('account_id', $account)->whereYear('date', $tahun)->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where([['account_id', $account], ['last_year', 0]])->whereYear('date', $tahun)->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where([['account_id', $account], ['last_year', 1]])->whereYear('date', $tahun)->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                } else {
                    $data['wp_wr'] = Journal::where('user_id', Auth::user()->id)->where('account_id', $account)->whereYear('date', $tahun)->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 0]])->whereYear('date', $tahun)->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->where([['account_id', $account], ['last_year', 1]])->whereYear('date', $tahun)->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                }
            }
        }

        if ($date != null && $date != '') {
            $data['month'] = $this->getMonth($split_date[1]);
        } else {
            $data['month'] = $tahun;
        }
        $data['date'] = $date;
        return view('pages.report.wp-wr.excel', $data);
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

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'K' => NumberFormat::FORMAT_ACCOUNTING_IDR,
        ];
    }
}
