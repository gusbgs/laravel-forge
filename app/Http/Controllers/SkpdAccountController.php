<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SkpdAccount;
use App\Account;
use App\Skpd;
use Auth;

class SkpdAccountController extends Controller
{
    public function index($id)
    {
      if (Auth::user()->role->skpd_account == 0) {
        return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
      }

        $data['account2'] = Account::with('children')->where('year', Auth::user()->year)->whereDoesntHave('parent')->get();
        $data['skpd_account'] = SkpdAccount::with('account')->where('skpd_id', $id)->get();
        $data['skpd_name'] = Skpd::where('id', $id)->pluck('name')->first();
        $data['skpd_id'] = $id;

        return view('pages.referensi.skpd-akun.index', $data);
    }

    public function store()
    {
      $parent = null;
      $parent_id = explode("-", request('account_id'));
      if(request('account_id') != 0 || request('account_id') != null || request('account_id') != '')
      {
          $parent = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
      }
      $skpd_account = SkpdAccount::where([['skpd_id', request('skpd_id')], ['account_id', $parent]])->first();
      if($skpd_account != null)
      {
          return redirect()->back()->with("ERR", "Akun telah digunakan");
      }
        SkpdAccount::create([
            'account_id' => $parent,
            'skpd_id' => request('skpd_id'),
        ]);

        return redirect()->back()->with("OK", "Berhasil menambahkan data");
    }

    public function edit($id)
    {
        $skpd_account = SkpdAccount::with('account')->findOrFail($id);

        return $skpd_account;
    }

    public function update($id)
    {
        $skpd_account = SkpdAccount::findOrFail($id);
        $parent = $skpd_account->account_id;
        $parent_id = explode("-", request('account_id'));
        if(count($parent_id) > 0)
        {
            $parent = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
        }
        $check_skpd_account = SkpdAccount::where([['skpd_id', request('skpd_id')], ['account_id', $parent]])->first();
        if($check_skpd_account != null)
        {
            if($check_skpd_account->id != $skpd_account->id)
            {
                return redirect()->back()->with("ERR", "Akun telah digunakan");
            }
        }
        $skpd_account->update([
           'account_id' => $parent
        ]);

        return redirect()->back()->with("OK", "Berhasil mengubah data");
    }

    public function destroy($id)
    {
        $skpd_account = SkpdAccount::findOrFail($id);
        $skpd_account->delete();

        return redirect()->back()->with("OK", "Berhasil menghapus data");
    }
}
