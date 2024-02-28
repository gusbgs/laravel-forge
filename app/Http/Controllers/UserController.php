<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\About;
use App\Skpd;
use Image;
use Auth;

class UserController extends Controller
{
  public function indexUser()
  {
    if (Auth::user()->role->users_view == 0) {
      return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
    }

    $data['n'] = 1;
    $data['users'] = User::with('role', 'skpd')->get();
    $data['roles'] = Role::all();
    $data['skpd'] = Skpd::where('year', Auth::user()->year)->get();
    return view('pages.userManagement.user.index', $data);
  }

  public function createUser(Request $request) {

    $checkUsername = User::where('username', $request['username'])->first();
    if ($checkUsername != null) {
      return redirect()->back()->with('ERR', 'Username Telah Digunakan');
    }

    $checkEmail = User::where('email', $request['email'])->first();
    if ($checkEmail != null) {
      return redirect()->back()->with('ERR', 'Email Telah Digunakan');
    }

    $blankImage = [
      '/images/user-blank-1.png',
      '/images/user-blank-2.png',
      '/images/user-blank-3.png',
      '/images/user-blank-4.png',
      '/images/user-blank-5.png',
    ];

    $profile_picture = $blankImage[array_rand($blankImage)];
    if ($request->hasFile('profile_picture')) {
      $file = $request->file('profile_picture');
      $path = '/storage/profilePicture/';
      $image = Image::make($file);
      $image->orientate();
      $filename = $request->file('profile_picture')->hashName();
      $image->save(public_path($path.$filename));
      $profile_picture = $path.$filename;
    }

    $skpd_id = $request['skpd_id'];
    if ($skpd_id == 'this_skpd_all') {
      $skpd_id = null;
    }

    $user = User::create([
      'role_id' => $request['role_id'],
      'skpd_id' => $skpd_id,
      'name' => $request['name'],
      'email' => $request['email'],
      'username' => $request['username'],
      'phone_number' => $request['phone_number'],
      'password' => bcrypt($request['password']),
      'profile_picture' => $profile_picture,
    ]);

    return redirect()->back()->with("OK", "Berhasil Menambahkan Pengguna");
  }

  public function editUser($id) {
    $data = User::findOrFail($id);
    return $data;
  }

  public function updateUser(Request $request, $id) {

    if ($request->password != null) {
      if ($request->password != $request->confirm_password) {
        return redirect()->back()->with('ERR', 'Password Tidak Sama Dengan Konfirmasi Password.');
      }
    }

    $user = User::findOrFail($id);

    $checkUsername = User::where('username', $request['username'])->first();
    if ($checkUsername != null && $checkUsername->id != $user->id) {
      return redirect()->back()->with('ERR', 'Username telah digunakan.');
    }

    $checkEmail = User::where('email', $request['email'])->first();
    if ($checkEmail != null && $checkEmail->id != $user->id) {
      return redirect()->back()->with('ERR', 'Email telah digunakan.');
    }

    $checkPassword = $user->password;
    if ($request->password != null) {
      $checkPassword = bcrypt($request['password']);
    }

    $profile_picture = $user->profile_picture;
    if ($request->hasFile('profile_picture')) {
      $oldFilePath = str_replace('/storage/profilePicture/', '', $profile_picture);
      if (is_file(storage_path('app/public/profilePicture/'.$oldFilePath))) {
        unlink(storage_path('app/public/profilePicture/'.$oldFilePath));
      }
      $file = $request->file('profile_picture');
      $path = '/storage/profilePicture/';
      $image = Image::make($file);
      $image->orientate();
      $filename = $request->file('profile_picture')->hashName();
      $image->save(public_path($path.$filename));
      $profile_picture = $path.$filename;
    }

    $skpd_id = $request['skpd_id'];
    if ($skpd_id == 'this_skpd_all') {
      $skpd_id = null;
    }

    $user->update([
      'role_id' => $request['role_id'],
      'skpd_id' => $skpd_id,
      'name' => $request['name'],
      'email' => $request['email'],
      'username' => $request['username'],
      'phone_number' => $request['phone_number'],
      'password' => $checkPassword,
      'profile_picture' => $profile_picture,
    ]);

    return redirect()->back()->with("OK", "Berhasil Mengedit Pengguna");
  }

  public function deleteUser($id) {
    $user = User::findOrFail($id);

    $profile_picture = $user->profile_picture;
    $oldFilePath = str_replace('/storage/profilePicture/', '', $profile_picture);

    if (is_file(storage_path('app/public/profilePicture/'.$oldFilePath))) {
      unlink(storage_path('app/public/profilePicture/'.$oldFilePath));
    }

    $user->delete();
    return redirect()->back()->with("OK", "Berhasil Menghapus Pengguna");
  }
}
