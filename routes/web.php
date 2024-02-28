<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DashboardController@redirect');

Route::group(['middleware' => 'guest'], function () {
  Route::get('login/laporan-singkat', 'AuthController@summary')->name('login');
  Route::get('login', 'AuthController@indexLogin')->name('login');
  Route::post('login', 'AuthController@doLogin')->name('doLogin');

  Route::post('forget-password', 'AuthController@forgetPassword')->name('forgetPassword');
  Route::get('forget-password/redirect/', 'AuthController@forgetPasswordRedirect')->name('forget_password.redirect');

  Route::get('reset-password/{id}', 'AuthController@indexResetPassword')->name('reset_password.index');
  Route::post('reset-password/{id}', 'AuthController@resetPassword')->name('reset_password');
});

Route::group(['middleware' => ['auth']], function () {
  Route::post('logout', 'AuthController@doLogout')->name('logout');
  Route::put('profile/update/{id}', 'DashboardController@updateProfile')->name('editProfile');
  Route::get('revisi-jurnal', 'JournalController@revisijurnal');
  Route::prefix('dashboard')->group(function () {

    Route::prefix('shortReport')->group(function () {
      Route::get('/', 'ShortReportController@index')->name('dashboard.shortReport.index');
      Route::post('/create', 'ShortReportController@create')->name('dashboard.shortReport.create');
      Route::get('/edit/{id}', 'ShortReportController@edit')->name('dashboard.shortReport.edit');
      Route::put('/update/{id}', 'ShortReportController@update')->name('dashboard.shortReport.update');
      Route::post('/delete/{id}', 'ShortReportController@destroy')->name('dashboard.shortReport.delete');
    });

    Route::prefix('welcome')->group(function () {
      Route::get('/', 'DashboardController@indexWelcome')->name('dashboard.welcome');
    });

    Route::prefix('profile')->group(function () {
      Route::get('/', 'DashboardController@indexProfile')->name('dashboard.profile');
    });

    Route::prefix('about')->group(function () {
      Route::get('/', 'DashboardController@indexAbout')->name('dashboard.about');
      Route::put('/update/{id}', 'DashboardController@updateAbout')->name('dashboard.about.update');
      Route::post('/upload/{id}', 'DashboardController@uploadAbout')->name('dashboard.about.upload');
    });

    //Chart Api
    Route::prefix('chart')->group(function () {
      Route::get('/', 'DashboardController@charts')->name('dashboard.chart.week');
    });
  });

  Route::prefix('report')->group(function () {
    Route::prefix('summary')->group(function () {
      Route::get('/', 'ReportController@indexSummary')->name('report.summary');
      Route::get('/print', 'ReportController@printSummary')->name('report.summary.print');
      Route::get('/export', 'ReportController@exportSummary')->name('report.summary.export');
    });

    Route::prefix('ledger')->group(function () {
      Route::get('/', 'ReportController@indexLedger')->name('report.ledger');
      Route::get('/print', 'ReportController@printLedger')->name('report.ledger.print');
      Route::get('/export', 'ReportController@exportLedger')->name('report.ledger.export');
    });

    Route::prefix('income')->group(function () {
      Route::get('/', 'ReportController@indexIncome')->name('report.income');
      Route::get('/print', 'ReportController@printIncome')->name('report.income.print');
      Route::get('/export', 'ReportController@exportIncome')->name('report.income.export');
    });

    Route::prefix('overall')->group(function () {
      Route::get('/', 'ReportController@indexOverall')->name('report.overall');
      Route::get('/print', 'ReportController@printOverall')->name('report.overall.print');
      Route::get('/export', 'ReportController@exportOverall')->name('report.overall.export');
    });
  });

  Route::prefix('wp-wr')->group(function () {
    Route::get('/', 'ReportController@indexWpWr')->name('report.wp-wr');
    Route::get('/print', 'ReportController@printWpWr')->name('report.wp-wr.print');
    Route::get('/export', 'ReportController@exportWpWr')->name('report.wp-wr.export');
  });

  Route::prefix('referensi')->name('referensi.')->group(function () {
    Route::resource('skpd', 'SkpdController');
    Route::resource('akun', 'AccountController');
    Route::get('/akun/{id}/tandai-no', 'AccountController@markNumber');
    Route::get('/akun/{id}/tandai-nama', 'AccountController@markName');
    Route::post('/akun/{id}/target', 'AccountController@updateTarget');
    Route::get('/skpd-akun/{id}', 'SkpdAccountController@index')->name('skpd-akun.index');
    Route::resource('skpd-akun', 'SkpdAccountController')->except(['index', 'show']);
  });

  Route::prefix('journal')->name('journal.')->group(function () {
    Route::resource('journal', 'JournalController');
    Route::post('journal/get-skpd-akun', 'JournalController@getSkpdAccount');
    Route::get('/journal/{id}/tandai', 'JournalController@mark');
    // Route::get('get-journals', 'JournalController@getJournals')->name('journals.get');
    // Route::get('/create', 'JournalController@create')->name('create');
    Route::post('/journal/getJournals', 'JournalController@getJournals')->name('getJournals');
    Route::post('/journal/updateBulk', 'JournalController@updateBulkData')->name('updateBulk');
    Route::post('/journal/bulkDelete', 'JournalController@bulkDelete')->name('deleteBulk');
    Route::get('journal/getJournalsEdit/{id}', 'JournalController@getJournalsEdit')->name('getJournalsEdit');
    Route::get('verifikasi-jurnal', 'JournalController@verifyJournal')->name('verifyJournal');
    Route::post('verifikasi-jurnal/store', 'JournalController@verifyJournalStore')->name('verifyJournalStore');
  });

  Route::prefix('userManagement')->group(function () {
    Route::prefix('role')->group(function () {
      Route::get('/', 'RoleController@indexRole')->name('userManagement.role');
      Route::post('/create', 'RoleController@createRole')->name('userManagement.role.create');
      Route::get('/edit/{id}', 'RoleController@editRole')->name('userManagement.role.edit');
      Route::put('/update/{id}', 'RoleController@updateRole')->name('userManagement.role.update');
      Route::post('/delete/{id}', 'RoleController@deleteRole')->name('userManagement.role.delete');
    });

    Route::prefix('user')->group(function () {
      Route::get('/', 'UserController@indexUser')->name('userManagement.user');
      Route::post('/create', 'UserController@createUser')->name('userManagement.user.create');
      Route::get('/edit/{id}', 'UserController@editUser')->name('userManagement.user.edit');
      Route::put('/update/{id}', 'UserController@updateUser')->name('userManagement.user.update');
      Route::post('/delete/{id}', 'UserController@deleteUser')->name('userManagement.user.delete');
    });
  });
});
