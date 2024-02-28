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

class LedgerExport implements FromView, WithColumnFormatting
{

    use Exportable;

    public function account($account)
    {
        $this->account = $account;

        return $this;
    }

    public function startDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function endDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function view(): View
    {
        $account = $this->account;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $data['month'] = null;
        $data['book'] = [];
        $data['skpd_account'] = [];
        $data['this_year'] = 0;
        $data['last_year'] = 0;
        $data['start_date'] = null;
        $data['end_date'] = null;
        $data['account'] = null;
        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();
        if ($account != null) {
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
            if ($startDate != null) {
                $data['start_date'] = $startDate;
                $data['end_date'] = $endDate;

                $splitStartDate = explode('-', $startDate);
                $splitEndDate = explode('-', $endDate);
                if (Auth::user()->role->all_users_data == 1) {
                   
                    $data['month'] = $this->getMonth($splitStartDate[1]);
                    $data['book'] = Journal::whereBetween('date', [$startDate, $endDate])->whereIn('account_id', $accountIds)->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                    $data['this_year'] = Journal::where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    
                    //  $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $currAcc->id)->first();
                      $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $account)->first();
                
                } else {
                    $data['month'] = $this->getMonth($split_date[1]);
                    $data['book'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->whereBetween('date', [$startDate, $endDate])->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                    
                    $data['this_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['last_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                    $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $currAcc->id)->first();
                }
                
                // if (Auth::user()->role->all_users_data == 1) {
                //     $data['book'] = Journal::whereBetween('date', [$startDate, $endDate])->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                //     $data['this_year'] = Journal::where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                //     $data['last_year'] = Journal::where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                // } else {
                //     $data['book'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->whereBetween('date', [$startDate, $endDate])->whereYear('date', $splitEndDate[0])->orderBy('date', 'desc')->get();
                //     $data['this_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 0)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                //     $data['last_year'] = Journal::where('user_id', Auth::user()->id)->whereIn('account_id', $accountIds)->where('last_year', 1)->whereYear('date', $splitEndDate[0])->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'desc')->sum('value');
                // }
                $data['skpd_account'] = SkpdAccount::with('skpd', 'account')->where('account_id', $currAcc->id)->first();
            }
        }
        return view('pages.report.ledger.excel', $data);
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
            'K' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'M' => NumberFormat::FORMAT_ACCOUNTING_IDR,
        ];
    }
}
