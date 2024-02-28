@extends('layouts.layoutAuth2')

@section('title', 'Reset Password')

@section('link')

@endsection

@section('style')

@endsection

@section('content')

  <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
    <!--begin::Content body-->
    <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
      <!--begin::Signin-->
      <div class="login-form login-signin">
        <div class="text-center mb-10 mb-lg-20">
          <h3 class="font-size-h1">Reset Password</h3>
          <p class="text-muted font-weight-bold">Form Penyetelan Ulang Password</p>
        </div>
        <!--begin::Form-->
        <form class="form" method="POST" action="/reset-password/{{ $user_id }}">
          @csrf

          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-key"></i> </span></div>
              <input class="form-control h-auto bg-light border-0" id="new_password" type="password" maxlength="250" minlength="6" placeholder="Password Baru" name="password" required/>
            </div>
          </div>

          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-key"></i> </span></div>
              <input class="form-control h-auto bg-light border-0" id="confirm_new_password" type="password" maxlength="250" minlength="6" placeholder="Konfirmasi Password" name="password" required/>
            </div>
          </div>

          <!--begin::Action-->
          <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary font-weight-bold btn-block">Selesai</button>
          </div>
          <!--end::Action-->
        </form>
        <!--end::Form-->
      </div>
      <!--end::Signin-->
    </div>
    <!--end::Content body-->
    <!--begin::Content footer for mobile-->
    <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
      <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2021 Metronic</div>
    </div>
    <!--end::Content footer for mobile-->
  </div>

@endsection

@section('modal')

@endsection

@section('script')

  <script type="text/javascript">
    var new_password = document.getElementById("new_password")
    , confirm_new_password = document.getElementById("confirm_new_password");

    function validatePassword(){
      if(new_password.value != confirm_new_password.value) {
        confirm_new_password.setCustomValidity("Password Tidak Cocok!");
      } else {
        confirm_new_password.setCustomValidity('');
      }
    }
    new_password.onchange = validatePassword;
    confirm_new_password.onkeyup = validatePassword;
  </script>

@endsection
