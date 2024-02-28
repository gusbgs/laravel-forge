<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Role;
use Auth;

class RoleController extends Controller
{
  public function indexRole()
  {
    if (Auth::user()->role->roles_view == 0) {
      return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
    }

    $data['n'] = 1;
    $data['roles'] = Role::all();
    return view('pages.userManagement.role.index', $data);
  }

  public function createRole(Request $request)
  {

    $arr = [];

    foreach (array_keys($request->all()) as $key) {
      if ($key != '_token') {
        if ($key == 'name') {
          array_push($arr, [$key => $request->$key]);
        } else {
          array_push($arr, [$key => 1]);
        }
      }
    }

    $result = array_merge(...$arr);

    $data = Role::create($result);

    return redirect()->back()->with("OK", "Berhasil Menambahkan Hak Akses");
  }

  public function editRole($id)
  {
    $data = Role::findOrFail($id);
    return $data;
  }

  public function updateRole(Request $request, $id)
  {

    $arr = [];

    $columnList = Schema::getColumnListing('roles');

    foreach ($columnList as $column) {
      if ($request->$column != true && $column != 'created_at' && $column != 'updated_at') {
        array_push($arr, [$column => 0]);
      }
    }

    foreach (array_keys($request->all()) as $key) {
      if ($key != '_token') {
        if ($key == 'name') {
          array_push($arr, [$key => $request->$key]);
        } else {
          array_push($arr, [$key => 1]);
        }
      }
    }

    $result = array_merge(...$arr);

    $data = Role::where('id', $id)->first()->update($result);

    return redirect()->back()->with("OK", "Berhasil Mengedit Hak Akses");
  }


  public function deleteRole($id)
  {
    $data = Role::findOrFail($id);
    $data->delete();
    return redirect()->back()->with("OK", "Berhasil Menghapus Hak Akses");
  }
}
