@extends('layouts.layoutAuth')

@section('title', 'Hak Akses')

@section('link')

@endsection

@section('style')

@endsection

@section('content')

  <!--begin::Login Sign in form-->
  <div class="login-signin">
    <div class="mb-5">
      <h3>Form Login</h3>
      <p class="opacity-60 font-weight-bold">Anda Harus Login untuk Dapat Melanjutkan</p>
    </div>
    <form class="form">
      <div class="form-group">
        <div class="input-group input-group-lg">
          <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-user"></i> </span></div>
          <input class="form-control form-control-solid bg-light border-0" type="text" placeholder="Username" name="username" autocomplete="off" required/>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group input-group-lg">
          <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-key"></i> </span></div>
          <input class="form-control h-auto bg-light border-0" type="password" placeholder="Password" name="password" required/>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group input-group-lg" id="kt_datetimepicker_1" data-target-input="nearest" data-toggle="datetimepicker">
          <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-calendar"></i> </span></div>
          <input type="text" class="form-control h-auto bg-light border-0 datetimepicker-input" placeholder="Tahun SKPD" data-target="#kt_datetimepicker_1"/>
        </div>
      </div>
      <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8">
        <div class="checkbox-inline">
        </div>
        <a id="tombolForgetPassword" class="card-link text-white font-weight-bold" style="cursor: pointer">Lupa Password ?</a>
      </div>
      <div class="form-group text-center mt-10">
        <button id="kt_login_signin_submit" class="btn btn-block btn-dark font-weight-bold px-15 py-3">Login</button>
      </div>
    </form>

  </div>
  <!--end::Login Sign in form-->

@endsection

@section('modal')

  <!-- MODAL FORGOT PASSWORD -->
  <div class="modal fade" id="modalForgetPassword">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white"> <b>Form Lupa Password</b> </h5>
          <button class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            @csrf
            <div class="form-group">
              <div class="input-group input-group-lg">
                <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-envelope"></i> </span></div>
                <input type="email" class="form-control" name="email" maxlength="210" minlength="1" placeholder="Alamat Email" autofocus required>
              </div>
              <small>Kami akan mengirim link penyetelan ulang password ke alamat email anda</small>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary">Kirim</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- ENDMODAL -->

@endsection

@section('script')

  <script type="text/javascript">
  $('#kt_datetimepicker_1').datetimepicker({
    format: "YYYY",
    viewMode: "years"
  });
  </script>

  <script type="text/javascript">
    $("#tombolForgetPassword").on("click", function(){
      $("#modalForgetPassword").modal();
    });
  </script>

@endsection
