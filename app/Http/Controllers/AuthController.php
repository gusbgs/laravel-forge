<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Mail\EmailResetPassword;
use Illuminate\Http\Request;
use App\ShortReport;
use App\SkpdAccount;
use App\Account;
use App\Skpd;
use App\User;
use App\Role;
use Auth;
use Mail;

class AuthController extends Controller
{
  public function indexLogin()
  {
    $data['n'] = 1;
    $year = date('Y');
    $change = 'sebelum_perubahan';
    $array_summary = [];
    $data['account'] = [];
    if($change != null)
    {
        if(isset($_GET['change']))    
        {
            $change = $_GET['change'];
        }
        if($year != null)
        {
            if(isset($_GET['change']))    
            {
                $year = $_GET['year'];
            }
          $data['account'] = Account::with([
          'children',
          'realisasi_until_this_month_after' => function($q) use($year){
            $q->whereYear('date', $year);
          },
          'realisasi_until_this_month_before' => function($q) use($year){
            $q->whereYear('date', $year);
          },
          ])->where('year', $year)->orderBy('number', 'asc')
          ->get();
          $short_report = ShortReport::pluck('number');
          $parent = Account::with('children')->whereIn('number', $short_report)->where('year', $year)
          ->orderBy('number', 'asc')
          ->get();
          $children = Account::with([
          'children',
          'realisasi_until_this_month_after' => function($q) use($year){
            $q->whereYear('date', $year);
          },
          'realisasi_until_this_month_before' => function($q) use($year){
            $q->whereYear('date', $year);
          },
          ])
          ->where('year', $year)
          ->get();
          foreach($parent as $item)
          {
            // $explode_number_parent = explode(".", $item->number);
            // $implode_number_parent = implode("", $explode_number_parent);
            $array_children = [];
            $realisasi_until_this_month_after = 0;
            $realisasi_until_this_month_before = 0;
            foreach($children as $item_1)
            {
            //   $explode_number_children = explode(".", $item_1->number);
            //   $implode_number_children = implode("", $explode_number_children);
            //   $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
              $explode_number = explode($item->number, $item_1->number);
              if($explode_number[0] == '')
              {
                $realisasi_until_this_month_after += $item_1->realisasi_until_this_month_after->sum('value');
                $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');
                array_push($array_children, $item_1->id);
              }
            }
            if($change == 'sebelum_perubahan')
            {
              $target = Account::whereIn('id', $array_children)->sum('target_before');
            } else {
              $target = Account::whereIn('id', $array_children)->sum('target_after');
            }
            
            if($target != 0)
            {
                $persen = ($realisasi_until_this_month_after + $realisasi_until_this_month_before) / $target * 100;
            } else {
                $persen = 0;
            }
            $collection = collect([
                'number' => $item->number,
                'name' => $item->name,
                'target' => $target,
                'realisasi' => $realisasi_until_this_month_after + $realisasi_until_this_month_before,
                'persen' => $persen
            ]);
            array_push($array_summary, $collection);
          }
        }
    }

    $data['array'] = $array_summary;
    $data['change'] = $change;
    $data['year'] = $year;

    return view('auth.login2', $data);
  }
  
  public function summary()
  {
        $data['n'] = 1;
        $year = date('Y');
        $change = 'sebelum_perubahan';
        $array_summary = [];
        $data['account'] = [];
        if($change != null)
        {
            if(isset($_GET['change']))    
            {
                $change = $_GET['change'];
            }
            if($year != null)
            {
                if(isset($_GET['change']))    
                {
                    $year = $_GET['year'];
                }
              $data['account'] = Account::with([
              'children',
              'realisasi_until_this_month_after' => function($q) use($year){
                $q->whereYear('date', $year);
              },
              'realisasi_until_this_month_before' => function($q) use($year){
                $q->whereYear('date', $year);
              },
              ])->where('year', $year)->orderBy('number', 'asc')
              ->get();
              $short_report = ShortReport::pluck('number');
              $parent = Account::with('children')->whereIn('number', $short_report)->where('year', $year)
              ->orderBy('number', 'asc')
              ->get();
              $children = Account::with([
              'children',
              'realisasi_until_this_month_after' => function($q) use($year){
                $q->whereYear('date', $year);
              },
              'realisasi_until_this_month_before' => function($q) use($year){
                $q->whereYear('date', $year);
              },
              ])
              ->where('year', $year)
              ->get();
              foreach($parent as $item)
              {
                // $explode_number_parent = explode(".", $item->number);
                // $implode_number_parent = implode("", $explode_number_parent);
                $array_children = [];
                $realisasi_until_this_month_after = 0;
                $realisasi_until_this_month_before = 0;
                foreach($children as $item_1)
                {
                //   $explode_number_children = explode(".", $item_1->number);
                //   $implode_number_children = implode("", $explode_number_children);
                //   $substr_number_children = substr($implode_number_children, 0, count($explode_number_parent));
                  $explode_number = explode($item->number, $item_1->number);
                  if($explode_number[0] == '')
                  {
                    $realisasi_until_this_month_after += $item_1->realisasi_until_this_month_after->sum('value');
                    $realisasi_until_this_month_before += $item_1->realisasi_until_this_month_before->sum('value');
                    array_push($array_children, $item_1->id);
                  }
                }
                if($change == 'sebelum_perubahan')
                {
                  $target = Account::whereIn('id', $array_children)->sum('target_before');
                } else {
                  $target = Account::whereIn('id', $array_children)->sum('target_after');
                }
                
                if($target != 0)
                {
                    $persen = ($realisasi_until_this_month_after + $realisasi_until_this_month_before) / $target * 100;
                } else {
                    $persen = 0;
                }
                $collection = collect([
                    'number' => $item->number,
                    'name' => $item->name,
                    'target' => $target,
                    'realisasi' => $realisasi_until_this_month_after + $realisasi_until_this_month_before,
                    'persen' => $persen
                ]);
                array_push($array_summary, $collection);
              }
            }
        }
    
        $data['array'] = $array_summary;
        $data['change'] = $change;
        $data['year'] = $year;
        
        return $data;
  }

  /**
  * Handle an authentication attempt.
  *
  * @param  \Illuminate\Http\Request $request
  *
  * @return Response
  */
  public function doLogin(Request $request) {
    $credentials = $request->only('username', 'password');

    $username = User::where('username', $request['username'])->first();
    if ($username == null) {
      return redirect()->back()->with('ERR', 'Username Tidak Terdaftar');
    }elseif (!Auth::attempt($credentials)) {
      return redirect()->back()->with('ERR', 'Password yang Dimasukkan Tidak Benar');
    }

    $username->update([
        'year' => request('year'),
    ]);

    if ($username->role_id == null) {
      Auth::logout();
      return redirect()->back()->with('ERR', 'Anda Tidak Memiliki Hak Akses');
    }

    return redirect()->route('dashboard.welcome')->with('OK', "Sign In Berhasil");
  }

  /**
  * Handle an authentication attempt for logout.
  *
  * @param  \Illuminate\Http\Request $request
  *
  * @return Response
  */
  public function doLogout(Request $request) {
    Auth::logout();
    return redirect()->route('login')->with('OK', 'Sign Out Berhasil');
  }

  public function forgetPassword(Request $request)
  {
    $user = User::where('email', $request['email'])->first();
    if ($user == null) {
      return redirect()->back()->with('ERR', 'Email Tidak Terdaftar');
    }
    $user->reset_token = bcrypt($user->id.$user->email);
    $user->save();
    $data['user'] = $user;
    $data['token'] = $user->reset_token;

    Mail::to($user->email)->send(new EmailResetPassword($data));
    return redirect()->back()->with('OK', 'Kami Telah Mengirim Link Penyetelan Ulang Password ke Email Anda');
  }

  public function forgetPasswordRedirect()
  {
    $user = User::find($_GET['id']);
    if ($user->reset_token == $_GET['token']) {
      return redirect('/reset-password/'.$_GET['id'])->with('OK', 'Selamat Datang di Form Penyetelan Ulang Password');
    }
    return abort('419');
  }

  public function indexResetPassword($id)
  {
    if (!session('OK')) {
      return redirect()->route('login');
    }
    $data['user_id'] = $id;
    return view('auth.resetPassword', $data);
  }

  public function resetPassword(Request $request, $id)
  {
    $user = User::find($id);
    $new_token = bcrypt($user->id.$user->name.date('Y-m-d H:i:s'));
    $user->update([
    'password' => bcrypt($request['password']),
    'reset_token' => $new_token,
    ]);
    return redirect()->route('login')->with('OK', 'Password Telah Berhasil di Setel Ulang');
  }
  
    public function generateAccountAndSkpd()
    {
        $years = [];
    
        for($i=8; $i <= 100; $i++)
        {
            array_push($years, 2000 + $i);
        }
            
        $accounts = Account::where('year', '2021')->orderBy('level', 'asc')->get();
        $skpds = Skpd::where('year', '2021')->get();
        
        foreach($years as $year)
        {
            // foreach($accounts as $account)
            // {   
            //     $check_account = Account::where([['year', $year], ['number', $account->number]])->first();
            //     if($check_account == null)
            //     {
            //         $check_account_parent = Account::where([['year', '2021'], ['number', $account->number]])->first();
            //         if($check_account_parent->parent == true)
            //         {
            //             $get_parent = Account::where([['year', $year], ['number', $check_account_parent->parent->number]])->pluck('id')->first();
            //         } else {
            //             $get_parent = null;
            //         }
            //         Account::create([
            //             'parent_id' => $get_parent,
            //             'number' => $account->number,
            //             'level' => $account->level,
            //             'name' => $account->name,
            //             'year' => $year,
            //             'target_before' => $account->target_before,
            //             'target_after' => $account->target_after,
            //             'account_regulations' => $account->account_regulations,
            //             'legal_basis' => $account->legal_basis,
            //             'description' => $account->description,
            //             'account_editable' => $account->account_editable,
            //             'mark_1' => $account->mark_1,
            //             'mark_2' => $account->mark_2,
            //         ]);
            //     }
            // }
            
            // foreach($skpds as $skpd)
            // {
            //     $check_skpd = Skpd::where([['year', $year], ['name', $skpd->name]])->first();
            //     if($check_skpd == null)
            //     {
            //         Skpd::create([
            //           'name' => $skpd->name,
            //           'year' => $year
            //         ]);
            //     }
            // }
        }
        $years = [];
    
    for($i=8; $i <= 100; $i++)
    {
        array_push($years, 2000 + $i);
    }
    
    $skpd_accounts = SkpdAccount::with('skpd', 'account')
    ->whereHas('skpd', function($q){
        $q->where('year', '2021');
    })
    ->whereHas('account', function($q){
        $q->where('year', '2021');
    })->get();
    
    foreach($years as $year)
    {
        foreach($skpd_accounts as $skpd_account)
        {
            $check_skpd_account = SkpdAccount::
            whereHas('skpd', function($q) use($skpd_account, $year){
                $q->where('name', $skpd_account->skpd->name)->where('year', $year);
            })->whereHas('account', function($q) use($skpd_account, $year){
                $q->where('name', $skpd_account->account->name)->where('year', $year);
            })->first();
            if($check_skpd_account == null)
            {
                $skpd = Skpd::where('name', $skpd_account->skpd->name)->where('year', $year)->first();
                $account = Account::where('name', $skpd_account->account->name)->where('year', $year)->first();
                SkpdAccount::create([
                  'skpd_id' => $skpd->id,
                  'account_id' => $account->id
                ]);
            }
        }
    }
    }
}
