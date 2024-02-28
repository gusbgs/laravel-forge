<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
use App\About;
use App\Journal;
use App\Skpd;
use Image;
use Cache;
use Auth;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function redirect()
  {
    return redirect()->route('login');
  }

  public function indexWelcome()
  {
    $data['n'] = 1;
    $data['about'] = About::first();
    $data['penerimaan'] = $this->summaryPenerimaan();
    $data['penerimaan_tahunan'] =  $this->penerimaan_tahunan();
    return view('pages.dashboard.welcome.index', $data);
  }

  public function indexProfile()
  {
    if (Auth::user()->role->profile_edit == 0) {
      return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
    }
    $data['n'] = 1;
    return view('pages.dashboard.profile.index', $data);
  }

  public function indexAbout()
  {
    if (Auth::user()->role->about_edit == 0) {
      return redirect()->back()->with("ERR", "Anda Tidak Memiliki Hak Akses ke Halaman Tersebut");
    }
    $data['n'] = 1;
    $data['about'] = About::first();
    return view('pages.dashboard.about.index', $data);
  }

  public function updateAbout(Request $request, $id)
  {
    $data = About::findOrFail($id);

    $data->update([
      'description' => $request['description'],
    ]);

    return redirect()->back()->with("OK", "Berhasil Mengedit Tentang Aplikasi");
  }

  public function uploadAbout(Request $request, $id)
  {
    $data = About::findOrFail($id);

    $df = $data->file;
    if ($request->hasFile('file')) {
      $path = '/public/aboutFile/';
      $filename = $request->file('file')->hashName();
      $file = $request->file('file')->store($path);
      $df = '/storage/aboutFile/' . $filename;
      $readlfilename = $request->file('file')->getClientOriginalName();
    }

    $data->update([
      'file' => $df,
      'file_name' => $readlfilename,
    ]);

    return redirect()->back()->with("OK", "Berhasil Mengedit Tentang Aplikasi");
  }

  public function updateProfile(Request $request, $id)
  {

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
      unlink(storage_path('app/public/profilePicture/' . $oldFilePath));
      $file = $request->file('profile_picture');
      $path = '/storage/profilePicture/';
      $image = Image::make($file);
      $image->orientate();
      $filename = $request->file('profile_picture')->hashName();
      $image->save(public_path($path . $filename));
      $profile_picture = $path . $filename;
    }

    $user->update([
      'username' => $request['username'],
      'name' => $request['name'],
      'email' => $request['email'],
      'phone_number' => $request['phone_number'],
      'password' => $checkPassword,
      'profile_picture' => $profile_picture,
    ]);

    return redirect()->back()->with("OK", "Berhasil Mengedit Profil");
  }

  public function summaryPenerimaan()
  {
    try {
      $today = Journal::whereDate('date', Carbon::now())->sum('value') ?? 0;
      $this_month = Journal::whereMonth('date', Carbon::now()->format('m'))->sum('value') ?? 0;
      $this_year = Journal::whereYear('date', Carbon::now()->format('Y'))->sum('value') ?? 0;
      $data = [];
      $data['today'] = $today;
      $data['this_month'] = $this_month;
      $data['this_year'] = $this_year;
      return $data;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
  public function charts(Request $request)
  {
    $x_data = [];
    $y_data = [];

    if ($request->type == "week") {
      $date_7_day_before = Carbon::now()->subDays(7);
      $date_current =  $date_7_day_before;
      for ($i = 0; $i < 8; $i++) {
        array_push($x_data, $date_7_day_before->format('d-m-Y'));
        $sum = Journal::whereDate('date', $date_current)->sum('value') ?? 0;
        array_push($y_data, ($sum));
        $date_current = $date_current->addDays(1);
      }
    } else if ($request->type == "month") {
      for ($i = 0; $i < date('t'); $i++) {
        array_push($x_data, $i + 1);
        $sum = Journal::whereDay('date', $i + 1)->whereMonth('date', Carbon::now()->format('m'))->whereYear('date', Carbon::now()->format('Y'))->sum('value') ?? 0;
        array_push($y_data, ($sum));
      }
    } else if ($request->type == "year") {
      $month_list = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      for ($i = 0; $i < count($month_list); $i++) {
        array_push($x_data, $month_list[$i]);
        $sum = Journal::whereMonth('date', $i + 1)->whereYear('date', Carbon::now()->format('Y'))->sum('value') ?? 0;
        array_push($y_data, ($sum));
      }
    } else if ($request->type == "pie") {
      $data = Skpd::withCount(['journals as sum' => function ($query) use ($request) {
        $query->select(DB::raw("SUM(value) as sum"))->whereYear('date', Carbon::parse($request->year)->format('Y'));
      }])->where('year',$request->year )
          ->get();

      foreach ($data as $key => $value) {
        array_push($x_data, $value->sum ?? 0);
        array_push($y_data, $value->name ?? '-');
      }
    }
    return ['x_data' => $x_data, 'y_data' => $y_data];
  }
  public function penerimaan_tahunan()
  {
    $data = [];
    $min_year = Journal::orderBy('date', 'asc')->whereNotNull('date')->first();
    $max_year = Carbon::now()->format('Y');
    $min_year_counter = Carbon::parse($min_year->date)->format('Y');

    $year_diff = $max_year - $min_year_counter;
    for ($i = 0; $i <= $year_diff; $i++) {
      array_push($data, [
        'year' => (string) $min_year_counter,
        'sum' => Journal::whereYear('date', $min_year_counter)->sum('value') ?? 0
      ]);
      $min_year_counter++;
    }
    for ($i = 0; $i < count($data); $i++) {
      if ($i != 0) {
        if ($data[$i]['sum'] < $data[$i - 1]['sum']) {
          $data[$i]['is_down'] = true;
          $data[$i]['percentage'] = ($data[$i]['sum'] - $data[$i - 1]['sum']) / $data[$i - 1]['sum']  * 100;
        } else {
          $data[$i]['is_down'] = false;
          $data[$i]['percentage'] = ($data[$i]['sum'] - $data[$i - 1]['sum']) / $data[$i - 1]['sum']  * 100;
        }
      } else {
        $data[$i]['percentage'] = null;
        $data[$i]['is_down'] = null;
      }
    }
    return $data;
  }
}
