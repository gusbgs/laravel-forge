@extends('layouts.layoutDashboard')

@section('title', 'Halaman Profil')

@section('link')

@endsection

@section('style')

  <style media="screen">

  .save-button{
    text-align: left;
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
  }

  </style>

@endsection

@section('navigation')

@endsection

@section('content')

  <div class="d-flex flex-row">
    <!--begin::Content-->
    <div class="flex-row-fluid">
      <!--begin::Card-->
      <form class="form" action="{{ route('editProfile', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card card-custom card-stretch">
          <!--begin::Header-->
          <div class="card-header py-3">
            <div class="card-title mt-5">
              <span class="card-icon mr-5">
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
                  <i class="fa fa-user" style="color:#3699ff; font-size:28px"></i>
                  <!--end::Svg Icon-->
                </span>
              </span>
              <h3 class="card-label">
                Pengaturan Profil
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                  <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted active">
                    <a href="#" class="text-muted">Profil</a>
                  </li>
                </ul>
              </h3>
            </div>
            <div class="card-toolbar">
              <!--begin::Button-->
              <button type="submit" class="save-button mt-2 mr-4">
                <a class="btn btn-success">
                  <i class="fa fa-save"></i>Simpan
                </a>
              </button>

              <font id="change-password-profile-btn" class="btn btn-primary mt-2">
                <i class="fa fa-key"></i> Ubah Password
              </font>
              <!--end::Button-->
            </div>
          </div>
          <!--end::Header-->
          <!--begin::Form-->
          <!--begin::Body-->
          <div class="card-body">
            <div class="form-group row">
              <label class="col-xl-3 col-lg-3 col-form-label">Foto Profil</label>
              <div class="col-lg-9 col-xl-6">
                <div class="image-input image-input-outline" id="kt_image_1">
                  <div class="image-input-wrapper" style="background-image: url({{ Auth::user()->profile_picture ?? '/images/user-blank.png' }})"></div>

                  <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="profile_picture" accept=".png, .jpg, .jpeg"/>
                    <input type="hidden" name="profile_avatar_remove"/>
                  </label>

                  <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                  </span>
                </div>
                <span class="form-text text-muted">File yang diperbolehkan: png, jpg, jpeg.</span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-xl-3 col-lg-3 col-form-label">Username</label>
              <div class="col-lg-9 col-xl-6">
                <div class="input-group input-group-lg input-group-solid">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-id-card"></i>
                    </span>
                  </div>
                  <input type="text" name="username" minlength="3" maxlength="250" class="form-control form-control-lg form-control-solid" value="{{ Auth::user()->username }}" placeholder="Username" autocomplete="off" required>
                </div>
                {{-- <span class="form-text text-muted">We'll never share your email with anyone else.</span> --}}
              </div>
            </div>

            <div id="change-password-profile-form" hidden>
              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Password Baru</label>
                <div class="col-lg-9 col-xl-6">
                  <div class="input-group input-group-lg input-group-solid">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-key"></i>
                      </span>
                    </div>
                    <input id="profile_password" minlength="6" maxlength="250" name="password" type="password" class="form-control form-control-lg form-control-solid" value="" placeholder="Password Baru">
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Konfirmasi Password</label>
                <div class="col-lg-9 col-xl-6">
                  <div class="input-group input-group-lg input-group-solid">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-key"></i>
                      </span>
                    </div>
                    <input id="profile_confirm_password" minlength="6" maxlength="250" type="password" class="form-control form-control-lg form-control-solid" value="" placeholder="Konfirmasi Password">
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-xl-3 col-lg-3 col-form-label">Nama</label>
              <div class="col-lg-9 col-xl-6">
                <div class="input-group input-group-lg input-group-solid">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input type="text" name="name" minlength="3" maxlength="250" class="form-control form-control-lg form-control-solid" value="{{ Auth::user()->name }}" placeholder="Nama" autocomplete="off" required>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-xl-3 col-lg-3 col-form-label">Email</label>
              <div class="col-lg-9 col-xl-6">
                <div class="input-group input-group-lg input-group-solid">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-envelope"></i>
                    </span>
                  </div>
                  <input type="email" name="email" minlength="2" maxlength="250" class="form-control form-control-lg form-control-solid" value="{{ Auth::user()->email }}" placeholder="Email" autocomplete="off" required>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-xl-3 col-lg-3 col-form-label">Nomor Telepon</label>
              <div class="col-lg-9 col-xl-6">
                <div class="input-group input-group-lg input-group-solid">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-phone"></i>
                    </span>
                  </div>
                  <input type="text" name="phone_number" minlength="3" maxlength="250" class="form-control form-control-lg form-control-solid" value="{{ Auth::user()->phone_number }}" placeholder="Nomor Telepon" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <!--end::Body-->
          <!--end::Form-->
        </div>
      </form>
    </div>
    <!--end::Content-->
  </div>

@endsection

@section('modal')

@endsection

@section('script')

  <script>
		document.getElementById("change-password-profile-btn").onclick = function() {showProfilePassword()};

		function showProfilePassword() {
			document.getElementById("change-password-profile-form").hidden = false;
			document.getElementById("change-password-profile-btn").hidden = true;
		}
	</script>

  <script type="text/javascript">
		var profile_password = document.getElementById("profile_password")
		, profile_confirm_password = document.getElementById("profile_confirm_password");

		function validatePassword(){
			if(profile_password.value != profile_confirm_password.value) {
				profile_confirm_password.setCustomValidity("Passwords Tidak Cocok!");
			} else {
				profile_confirm_password.setCustomValidity('');
			}
		}
		profile_password.onchange = validatePassword;
		profile_confirm_password.onkeyup = validatePassword;
	</script>

  <script type="text/javascript">
  var avatar1 = new KTImageInput('kt_image_1');
  </script>

  <script>
    var menu_link_1 = document.getElementById("kt_header_menu_1");
    menu_link_1.classList.add("active");

    var menu_link_2 = document.getElementById("kt_header_menu_mobile_1");
    menu_link_2.classList.add("active");

    var menu_link_3 = document.getElementById("kt_header_tab_1");
    menu_link_3.classList.add("active");
    menu_link_3.classList.add("show");

    var menu_link_4 = document.getElementById("menu_profile");
    menu_link_4.classList.add("menu-item-active");
  </script>

@endsection
