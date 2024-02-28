<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="">
  <meta charset="utf-8" />
  <title>E-penda | @yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <!--end::Fonts-->
  <!--begin::Page Vendors Styles(used by this page)-->
  <link href="/metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Page Vendors Styles-->
  <!--begin::Global Theme Styles(used by all pages)-->
  <link href="/metronic/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="/metronic/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
  <link href="/metronic/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Global Theme Styles-->
  <!--begin::Layout Themes(used by all pages)-->
  <!--end::Layout Themes-->
  <link rel="shortcut icon" href="/images/logo-4-small.png" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

  @yield('link')

  @yield('style')

  <style media="screen">
  .content{
    padding: 12px 0 0 0 !important;
  }

  .logout-button{
    text-align: left;
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
  }

  .logo {
    background-color: white;
    border-radius: 255px;
    padding: 5px 15px;
    box-shadow: 0px 0px 10px #ffffff;
    height: 40px;
    width: auto;
}
</style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading">
  <!--begin::Main-->
  <!--begin::Header Mobile-->
  <div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
    <!--begin::Logo-->
    <a href="/">
      <img alt="Logo" src="/images/logo-4-long.png" class="logo max-h-30px" />
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
      <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
        <span></span>
      </button>
      <button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
        <span class="svg-icon svg-icon-xl">
          <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <polygon points="0 0 24 0 24 24 0 24" />
              <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
              <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
            </g>
          </svg>
          <!--end::Svg Icon-->
        </span>
      </button>
    </div>
    <!--end::Toolbar-->
  </div>
  <!--end::Header Mobile-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
      <!--begin::Wrapper-->
      <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" class="header flex-column header-fixed">
          <!--begin::Top-->
          <div class="header-top">
            <!--begin::Container-->
            <div class="container">
              <!--begin::Left-->
              <div class="d-none d-lg-flex align-items-center mr-3">
                <!--begin::Logo-->
                <a href="#" class="mr-20">
                  <img alt="Logo" src="/images/logo-4-long-2.png" class="logo max-h-60px" />
                </a>
                <!--end::Logo-->
                <!--begin::Tab Navs(for desktop mode)-->
                <ul class="header-tabs nav align-self-end font-size-lg" role="tablist">
                  <!--begin::Item-->
                  <li class="nav-item">
                    <a href="#" class="nav-link py-4 px-6" data-toggle="tab" id="kt_header_menu_1" data-target="#kt_header_tab_1" role="tab">Dasboard</a>
                  </li>
                  <!--end::Item-->

                  @if (Auth::user()->role->reports_summary_view == 1 || Auth::user()->role->reports_ledger_view == 1 || Auth::user()->role->reports_income_view == 1 || Auth::user()->role->reports_overall_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                      <a href="#" class="nav-link py-4 px-6" data-toggle="tab" id="kt_header_menu_2" data-target="#kt_header_tab_2" role="tab">Laporan</a>
                    </li>
                    <!--end::Item-->
                  @endif

                  @if (Auth::user()->role->accounts_view == 1 || Auth::user()->role->skpd_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                      <a href="#" class="nav-link py-4 px-6" data-toggle="tab" id="kt_header_menu_3" data-target="#kt_header_tab_3" role="tab">Referensi</a>
                    </li>
                    <!--end::Item-->
                  @endif

                  @if (Auth::user()->role->journals_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                      <a href="#" class="nav-link py-4 px-6" data-toggle="tab" id="kt_header_menu_4" data-target="#kt_header_tab_4" role="tab">Jurnal</a>
                    </li>
                    <!--end::Item-->
                  @endif

                  @if (Auth::user()->role->users_view == 1 || Auth::user()->role->roles_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                      <a href="#" class="nav-link py-4 px-6" data-toggle="tab" id="kt_header_menu_5" data-target="#kt_header_tab_5" role="tab">Manajemen Pengguna</a>
                    </li>
                    <!--end::Item-->
                  @endif
                </ul>
                <!--begin::Tab Navs-->
              </div>
              <!--end::Left-->
              <!--begin::Topbar-->
              <div class="topbar bg-primary">
                <!--begin::User-->
                <div class="topbar-item">
                  <div class="btn btn-icon btn-hover-transparent-white w-sm-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <div class="d-flex flex-column text-right pr-sm-3">
                      <span class="text-white font-weight-bold font-size-sm d-sm-inline mr-2">{{ Auth::user()->name }} </span>
                      <span class="text-white opacity-80 font-weight-bolder font-size-sm d-none d-sm-inline mr-2">Tahun Anggaran {{ Auth::user()->year }}</span>
                    </div>
                    <span class="symbol symbol-35">
                      <span class="symbol-label font-weight-bold text-white bg-white-o-30">
                        <i class="fa fa-user" style="font-size:18px"></i>
                      </span>
                    </span>
                  </div>
                </div>
                <!--end::User-->
              </div>
              <!--end::Topbar-->
            </div>
            <!--end::Container-->
          </div>
          <!--end::Top-->
          <!--begin::Bottom-->
          <div class="header-bottom">
            <!--begin::Container-->
            <div class="container">
              <!--begin::Header Menu Wrapper-->
              <div class="header-navs header-navs-left" id="kt_header_navs">
                <!--begin::Tab Navs(for tablet and mobile modes)-->
                <ul class="header-tabs p-5 p-lg-0 d-flex d-lg-none nav nav-bold nav-tabs" role="tablist">
                  <!--begin::Item-->
                  <li class="nav-item mr-2">
                    <a href="#" class="nav-link btn btn-clean" data-toggle="tab" id="kt_header_menu_mobile_1" data-target="#kt_header_tab_1" role="tab">Dashboard</a>
                  </li>
                  <!--end::Item-->

                  @if (Auth::user()->role->reports_summary_view == 1 || Auth::user()->role->reports_ledger_view == 1 || Auth::user()->role->reports_income_view == 1 || Auth::user()->role->reports_overall_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                      <a href="#" class="nav-link btn btn-clean" data-toggle="tab" id="kt_header_menu_mobile_2" data-target="#kt_header_tab_2" role="tab">Laporan</a>
                    </li>
                    <!--end::Item-->
                  @endif

                  @if (Auth::user()->role->accounts_view == 1 || Auth::user()->role->skpd_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                      <a href="#" class="nav-link btn btn-clean" data-toggle="tab" id="kt_header_menu_mobile_3" data-target="#kt_header_tab_3" role="tab">Referensi</a>
                    </li>
                    <!--end::Item-->
                  @endif

                  @if (Auth::user()->role->journals_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                      <a href="#" class="nav-link btn btn-clean" data-toggle="tab" id="kt_header_menu_mobile_4" data-target="#kt_header_tab_4" role="tab">Jurnal</a>
                    </li>
                    <!--end::Item-->
                  @endif

                  @if (Auth::user()->role->users_view == 1 || Auth::user()->role->roles_view == 1)
                    <!--begin::Item-->
                    <li class="nav-item mr-2">
                      <a href="#" class="nav-link btn btn-clean" data-toggle="tab" id="kt_header_menu_mobile_5" data-target="#kt_header_tab_5" role="tab">Manajemen Pengguna</a>
                    </li>
                    <!--end::Item-->
                  @endif

                </ul>

                <!--begin::Tab Navs-->

                <!--begin::Tab Content-->
                <div class="tab-content">
                  <!--begin::Tab Pane-->
                  <div class="tab-pane py-5 p-lg-0" id="kt_header_tab_1">
                    <!--begin::Menu-->
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                      <!--begin::Nav-->
                      <ul class="menu-nav">
                        <li class="menu-item" aria-haspopup="true" id="menu_welcome">
                          <a href="{{ route('dashboard.welcome') }}" class="menu-link">
                            <span class="menu-text">Welcome</span>
                          </a>
                        </li>

                        @if (Auth::user()->role->profile_edit == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_profile">
                            <a href="{{ route('dashboard.profile') }}" class="menu-link">
                              <span class="menu-text">Profil</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->about_edit == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_about">
                            <a href="{{ route('dashboard.about') }}" class="menu-link">
                              <span class="menu-text">Tentang Aplikasi</span>
                            </a>
                          </li>
                          <li class="menu-item" aria-haspopup="true" id="menu_short_report">
                            <a href="{{ route('dashboard.shortReport.index') }}" class="menu-link">
                              <span class="menu-text">Laporan Singkat</span>
                            </a>
                          </li>
                        @endif

                      </ul>
                      <!--end::Nav-->
                    </div>
                    <!--end::Menu-->
                  </div>
                  <!--end::Tab Pane-->

                  <!--begin::Tab Pane-->
                  <div class="tab-pane py-5 p-lg-0" id="kt_header_tab_2">
                    <!--begin::Menu-->
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                      <!--begin::Nav-->
                      <ul class="menu-nav">

                        @if (Auth::user()->role->reports_summary_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_summary">
                            <a href="{{ route('report.summary') }}" class="menu-link">
                              <span class="menu-text">Ringkasan dan PAD</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->reports_ledger_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_ledger">
                            <a href="{{ route('report.ledger') }}" class="menu-link">
                              <span class="menu-text">Buku Besar</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->reports_income_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_income">
                            <a href="{{ route('report.income') }}" class="menu-link">
                              <span class="menu-text">Pendapatan</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->reports_ledger_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_wp_wr">
                            <a href="{{ route('report.wp-wr') }}" class="menu-link">
                              <span class="menu-text">WP/WR</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->reports_overall_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_overall">
                            <a href="{{ route('report.overall') }}" class="menu-link">
                              <span class="menu-text">Keseluruhan</span>
                            </a>
                          </li>
                        @endif

                      </ul>
                      <!--end::Nav-->
                    </div>
                    <!--end::Menu-->
                  </div>
                  <!--end::Tab Pane-->

                  <!--begin::Tab Pane-->
                  <div class="tab-pane py-5 p-lg-0" id="kt_header_tab_3">
                    <!--begin::Menu-->
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                      <!--begin::Nav-->
                      <ul class="menu-nav">

                        @if (Auth::user()->role->accounts_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_akun">
                            <a href="{{ route('referensi.akun.index') }}" class="menu-link">
                              <span class="menu-text">Daftar Akun</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->skpd_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_skpd">
                            <a href="{{ route('referensi.skpd.index') }}" class="menu-link">
                              <span class="menu-text">Daftar SKPD</span>
                            </a>
                          </li>
                        @endif

                      </ul>
                      <!--end::Nav-->
                    </div>
                    <!--end::Menu-->
                  </div>
                  <!--end::Tab Pane-->

                  <!--begin::Tab Pane-->
                  <div class="tab-pane py-5 p-lg-0" id="kt_header_tab_4">
                    <!--begin::Menu-->
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                      <!--begin::Nav-->
                      <ul class="menu-nav">

                        @if (Auth::user()->role->journals_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_journal">
                            <a href="{{ route('journal.journal.index', ['date' => date('Y-m-d')]) }}" class="menu-link">
                              <span class="menu-text">Semua Jurnal</span>
                            </a>
                          </li>
                        @endif
                            @if (Auth::user()->role->journals_view == 1)
                                <li class="menu-item" aria-haspopup="true" id="menu_journal_create">
                                    <a href="{{ route('journal.journal.create') }}" class="menu-link">
                                        <span class="menu-text">Tambah Jurnal</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->role->journals_verify == 1)
                                <li class="menu-item" aria-haspopup="true" id="menu_journal_verifikasi">
                                    <a href="{{ route('journal.verifyJournal') }}" class="menu-link">
                                        <span class="menu-text">Verifikasi Jurnal</span>
                                    </a>
                                </li>
                            @endif
                      </ul>
                      <!--end::Nav-->
                    </div>
                    <!--end::Menu-->
                  </div>
                  <!--end::Tab Pane-->

                  <!--begin::Tab Pane-->
                  <div class="tab-pane py-5 p-lg-0" id="kt_header_tab_5">
                    <!--begin::Menu-->
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                      <!--begin::Nav-->
                      <ul class="menu-nav">

                        @if (Auth::user()->role->roles_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_role">
                            <a href="{{ route('userManagement.role') }}" class="menu-link">
                              <span class="menu-text">Hak Akses</span>
                            </a>
                          </li>
                        @endif

                        @if (Auth::user()->role->users_view == 1)
                          <li class="menu-item" aria-haspopup="true" id="menu_user">
                            <a href="{{ route('userManagement.user') }}" class="menu-link">
                              <span class="menu-text">Pengguna</span>
                            </a>
                          </li>
                        @endif

                      </ul>
                      <!--end::Nav-->
                    </div>
                    <!--end::Menu-->
                  </div>
                  <!--end::Tab Pane-->

                </div>
                <!--end::Tab Content-->
              </div>
              <!--end::Header Menu Wrapper-->
            </div>
            <!--end::Container-->
          </div>
          <!--end::Bottom-->
        </div>
        <!--end::Header-->

        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

          @yield('navigation')

          <!--begin::Entry-->
          <div class=" {{Route::currentRouteName() == "journal.journal.create" ? '' : 'd-flex flex-column-fluid'}}">
            <!--begin::Container-->
            <div class="{{Route::currentRouteName() == "journal.journal.create" ? 'mx-10' : 'container'}}">

              @yield('content')

            </div>
            <!--end::Container-->
          </div>
          <!--end::Entry-->
        </div>
        <!--end::Content-->

        <!--begin::Footer-->
        <div class="footer bg-white py-4 mt-4 d-flex flex-lg-column " id="kt_footer">
          <!--begin::Container-->
          <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <!--begin::Copyright-->
            <div class="text-dark order-2 order-md-1">
              <span class="text-muted font-weight-bold mr-2">2021©</span>
              <a href="https://inotive.id/" target="_blank" class="text-dark-75 text-hover-primary">Inotive Technology</a>
            </div>
            <!--end::Copyright-->
            <!--begin::Nav-->
            <div class="nav nav-dark order-1 order-md-2">
              <a href="{{ route('dashboard.welcome') }}" class="nav-link pr-3 pl-0">Tentang Aplikasi</a>
            </div>
            <!--end::Nav-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::Footer-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Page-->
  </div>
  <!--end::Main-->

  <!-- begin::User Panel -->
  <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <!--end::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5" style="" kt-hidden-height="39">
      <h3 class="font-weight-bold m-0" id="greeting"></h3>
      <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-danger" id="kt_quick_user_close" style="position: absolute; right:20px;">
        <i class="ki ki-close icon-xs text-muted"></i>
      </a>
    </div>
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5" style="overflow: auto; height: 593px;">
      <!--begin::Header-->
      <div class="d-flex align-items-center mt-5">
        <div class="symbol symbol-100 mr-5">
          <div class="symbol-label" style="background-image:url({{ Auth::user()->profile_picture ??  '/images/user-blank-1.png'}})"></div>
          <i class="symbol-badge bg-success"></i>
        </div>
        <div class="d-flex flex-column">
          <div class="font-weight-bold font-size-h5 text-dark-75 mb-2">{{ Auth::user()->name }}</div>
          <div class="text-muted mt-1"><i class="fa fa-user-shield" style="color:#3699ff;"></i> {{ Auth::user()->role->name }}</div>
          <div class="text-muted mt-1"><i class="fa fa-envelope" style="color:#3699ff;"></i> {{ Auth::user()->email }}</div>
        </div>
      </div>
      <!--end::Header-->
      <!--begin::Separator-->
      <div class="separator separator-dashed mt-8 mb-5"></div>
      <!--end::Separator-->
      <!--begin::Nav-->
      <div class="navi navi-spacer-x-0 p-0">

        @if (Auth::user()->role->profile_edit == 1)
          <!--begin::Item-->
          <a href="{{ route('dashboard.profile') }}" class="navi-item">
            <div class="navi-link">
              <div class="symbol symbol-40 bg-light mr-3">
                <div class="symbol-label">
                  <span class="svg-icon svg-icon-md">
                    <i class="fa fa-user" style="color:gold"></i>
                  </span>
                </div>
              </div>
              <div class="navi-text">
                <div class="font-weight-bold">Profil</div>
                <div class="text-muted">Pengaturan Profil Pribadi
                </div>
              </div>
            </div>
          </a>
          <!--end:Item-->
        @endif

        <!--begin::Item-->
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="logout-button">
            <a class="navi-item">
              <div class="navi-link">
                <div class="symbol symbol-40 bg-light mr-3">
                  <div class="symbol-label">
                    <span class="svg-icon svg-icon-md">
                      <i class="fa fa-sign-out-alt" style="color:#ff3333;"></i>
                    </span>
                  </div>
                </div>
                <div class="navi-text">
                  <div class="font-weight-bold">Sign Out</div>
                  <div class="text-muted">Sign out dari akun ini</div>
                </div>
              </div>
            </a>
          </button>
        </form>

        <!--end:Item-->

      </div>
      <!--end::Nav-->
      <!--begin::Separator-->
      <div class="separator separator-dashed my-7"></div>
      <!--end::Separator-->
    </div>
    <!--end::Content-->
  </div>

  {{-- <div class="offcanvas-overlay"></div> --}}
  <!-- end::User Panel-->

  <!--begin::Scrolltop-->
  <div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
      <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <polygon points="0 0 24 0 24 24 0 24" />
          <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
          <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
        </g>
      </svg>
      <!--end::Svg Icon-->
    </span>
  </div>
  <!--end::Scrolltop-->

  @yield('modal')

  <!--begin::Global Config(global config for global JS scripts)-->
  <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
  <!--end::Global Config-->
  <!--begin::Global Theme Bundle(used by all pages)-->
  <script src="/metronic/assets/plugins/global/plugins.bundle.js"></script>
  <script src="/metronic/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
  <script src="/metronic/assets/js/scripts.bundle.js"></script>
  <!--end::Global Theme Bundle-->
  <!--begin::Page Vendors(used by this page)-->
  <script src="/metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
  <!--end::Page Vendors-->
  <!--begin::Page Scripts(used by this page)-->
  <script src="/metronic/assets/js/pages/features/cards/tools.js"></script>
  <script src="/metronic/assets/js/pages/widgets.js"></script>
  <!--end::Page Scripts-->

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>


  <script type="text/javascript">
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>

  <script>
    var d = new Date();
    var time = d.getHours();

    if (time <= 24 && time <= 12) {
      document.getElementById("greeting").innerHTML = "<i class='fa fa-sun' style='color:gold'></i> Selamat Pagi";
    }
    if (time >= 12 && time <= 16) {
      document.getElementById("greeting").innerHTML = "<i class='fa fa-sun' style='color:gold'></i> Selamat Siang";
    }
    if (time >= 16 && time <= 19) {
      document.getElementById("greeting").innerHTML = "<i class='fa fa-moon' style='color:#3699ff'></i> Selamat Sore";
    }
    if (time >= 19 && time <= 24) {
      document.getElementById("greeting").innerHTML = "<i class='fa fa-moon' style='color:#3699ff'></i> Selamat Malam";
    }
  </script>

  @if(session('OK'))
    <script>
      Swal.fire("Berhasil!", "{{ session("OK") }}", "success");
    </script>
  @endif

  @if(session('ERR'))
    <script>
      Swal.fire("Gagal!", "{{ session("ERR") }}", "error");
    </script>
  @endif

  @yield('script')
</body>
<!--end::Body-->
</html>
