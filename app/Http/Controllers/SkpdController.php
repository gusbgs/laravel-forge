<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skpd;
use Auth;

class SkpdController extends Controller
{
    public function index()
    {
      if (Auth::user()->role->skpd_view == 0) {
        return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
      }

        $data['skpd'] = Skpd::where('year', Auth::user()->year)->orderBy('name', 'asc')->get();
        return view('pages.referensi.skpd.index', $data);
    }

    public function store()
    {
        Skpd::create([
            'name' => request('name'),
            'year' => Auth::user()->year,
        ]);

        return redirect()->back()->with("OK", "Berhasil menambahkan data");
    }

    public function edit($id)
    {
        $data = Skpd::findOrFail($id);

        return $data;
    }

    public function update($id)
    {
        $data = Skpd::findOrFail($id);
        $data->update([
            'name' => request('name'),
        ]);

        return redirect()->back()->with("OK", "Berhasil mengubah data");
    }

    public function destroy($id)
    {
        $data = Skpd::findOrFail($id);
        $data->delete();

        return redirect()->back()->with("OK", "Berhasil menghapus data");
    }
}
