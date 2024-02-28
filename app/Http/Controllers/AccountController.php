<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Auth;

class AccountController extends Controller
{
  public function index()
  {
    if (Auth::user()->role->accounts_view == 0) {
      return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
    }

    $data['account'] = Account::with('children')->where('year', Auth::user()->year)->get();
    $data['account2'] = Account::where('year', Auth::user()->year)->whereDoesntHave('parent')->get();
    $parent = Account::with('children')->whereHas('children')->where('year', Auth::user()->year)->get();
    $parent_updates = Account::with('children')->where('target_before', '!=', 0)->whereHas('children')->where('year', Auth::user()->year)->get();
    foreach($parent_updates as $parent_update)
    {
        $parent_update->update([
           'target_before' => 0 
        ]);
    }
    $children = Account::whereHas('parent')->with('children')->where('year', Auth::user()->year)->get();
    $array_target = [];
    foreach($parent as $item)
    {
        // $explode_number_parent = explode(".", $item->number);
        // $implode_number_parent = implode("", $explode_number_parent);
        $array_children = [];
        foreach($children as $item_1)
        {
            // $explode_number_children = explode(".", $item_1->number);
            // $implode_number_children = implode("", $explode_number_children);
            // $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
            $explode_number = explode($item->number, $item_1->number);
            if($explode_number[0] == '')
            {
                array_push($array_children, $item_1->id);
            }
        }
        $target_before = Account::whereIn('id', $array_children)->sum('target_before');
        $target_after = Account::whereIn('id', $array_children)->sum('target_after');
        $collection = collect(['id' => $item->id, 'number' => $item->number, 'target_before' => $target_before, 'target_after' => $target_after]);
        array_push($array_target, $collection);
    }
    $data['array_target'] = $array_target;

    return view('pages.referensi.akun.index', $data);
  }

  public function store()
  {
    $parent = null;
    $parent_id = explode("-", request('parent_id'));
    if(count($parent_id) > 1)
    {
        $parent = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
    } else if(request('parent_id') != 0 || request('parent_id') != '')
    {
        return redirect()->back()->with("ERR", "Parent tidak ditemukan");
    }


    if($parent != null)
    {
        $level = Account::where('year', Auth::user()->year)->where('id', $parent)->pluck('level')->first();
        $get_number = Account::where('year', Auth::user()->year)->where('id', $parent)->pluck('number')->first();
        $number = $get_number . '.' . request('number');
    } else {
        $level = 0;
        $number = request('number');
    }
    $check_number = Account::where('year', Auth::user()->year)->where('number', $number . '.' . request('number'))->first();
    if($check_number != null)
    {
      return redirect()->back()->with("ERR", "Akun Nomor telah digunakan");
    }
    $account = Account::create([
      'parent_id' => $parent,
      'level' => $level + 1,
      'name' => request('name'),
      'number' => $number,
      'legal_basis' => request('legal_basis'),
      'description' => request('description'),
      'year' => Auth::user()->year,
    ]);

    return redirect()->back()->with("OK", "Berhasil menambahkan data");
  }

  public function edit($id)
  {
    $data = Account::with('parent', 'children')->findOrFail($id);

    return $data;
  }

  public function update($id)
  {
    $data = Account::findOrFail($id);
    $parent = $data->parent_id;
    $parent_id = explode("-", request('parent_id'));
    if(count($parent_id) > 1)
    {
        $parent = Account::where('year', Auth::user()->year)->where('number', $parent_id[0])->pluck('id')->first();
    } else if(request('parent_id') != 0 || request('parent_id') != '')
    {
        return redirect()->back()->with("ERR", "Parent tidak ditemukan");
    }
    if($parent != null)
    {
      $level = Account::where('year', Auth::user()->year)->where('id', $parent)->pluck('level')->first();
      $parent_number = Account::where('year', Auth::user()->year)->where('id', $parent)->pluck('number')->first();
      $number = $parent_number . '.' . request('number');
    } else {
        $level = $data->level - 1;
        $number = request('number');
    }

    if(request('number') == null)
    {
        $number = $data->number;
    }

    $check_number = Account::where('year', Auth::user()->year)->where('number', $number . '.' . request('number'))->first();
    if($check_number != null)
    {
      if($check_number->id != $data->id)
      {
        return redirect()->back()->with("ERR", "Akun Nomor telah digunakan");
      }
    }
    $data->update([
        'parent_id' => $parent,
        'level' => $level + 1,
        'name' => request('name'),
        'number' => $number,
        'legal_basis' => request('legal_basis'),
        'description' => request('description'),
    ]);
    
    $explode_accounts = explode('.', $data->number);
    
    $order_number = null;
    foreach($explode_accounts as $explode_account)
    {
        $length = strlen($explode_account);
        if($length == 1)
        {
            $order_number = $order_number . '.' . '0' . $explode_account;
        } else {
            $order_number = $order_number . '.' . $explode_account;
        }
    }
    $order_number = substr($order_number, 1, strlen($order_number) - 1);
    $data->update([
      'order_number' => $order_number
    ]);

    if(request('children') == 1)
    {
        $data->update([
            'target_before'  => request('target_before'),
            'target_after'  => request('target_after')
        ]);
    }

    return redirect()->back()->with("OK", "Berhasil mengubah data");
  }

  public function destroy($id)
  {
    $data = Account::findOrFail($id);
    $data->delete();

    return redirect()->back()->with("OK", "Berhasil menghapus data");
  }

  public function markNumber($id)
  {
    $data = Account::findOrFail($id);
    if($data->mark_1 == 0)
    {
      $data->update([
      'mark_1' => 1
      ]);
    } else {
      $data->update([
      'mark_1' => 0
      ]);
    }

    return redirect()->back();
  }

  public function markName($id)
  {
    $data = Account::findOrFail($id);
    if($data->mark_2 == 0)
    {
      $data->update([
      'mark_2' => 1
      ]);
    } else {
      $data->update([
      'mark_2' => 0
      ]);
    }

    return redirect()->back();
  }

  public function updateTarget($id)
  {
    $data = Account::findOrFail($id);
    $data->update([
    'target_before'  => request('target_before'),
    'target_after'  => request('target_after')
    ]);

    return redirect()->back()->with("OK", "Berhasil mengubah target");
  }

}
