@extends('layouts.layoutAuth2')

@section('title', 'Login')

@section('link')

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

@endsection

@section('style')

  <style media="screen">
    .login-form{
      margin-top: 80px;
    }

    @media only screen and (max-width: 600px) {
      .login-form{
        margin-top: 6px;
      }
    }
  </style>

@endsection

@section('content')

    <!--begin::Content body-->
    <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
      <!--begin::Signin-->
      <div class="login-form login-signin">
        <div class="text-center mb-10 mb-lg-20">
          <h3 class="font-size-h1">Sign In</h3>
          <p class="text-muted font-weight-bold">Sign in untuk dapat melanjutkan</p>
        </div>
        <!--begin::Form-->
        <form class="form" method="POST" action="{{ route('doLogin') }}" id="kt_login_signin_form">
          @csrf
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
              <input type="text" class="form-control h-auto bg-light border-0 datetimepicker-input" placeholder="Tahun SKPD" name="year" data-target="#kt_datetimepicker_1" required/>
            </div>
          </div>
          <!--begin::Action-->
          <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
            <a href="javascript:;" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">Lupa Password ?</a>
            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Sign In</button>
          </div>
          <!--end::Action-->
        </form><br><br>
        <!--end::Form-->

        <div class="text-center mb-10 mb-lg-2">
          <h3 class="font-size-h1">Laporan Singkat</h3>
          <p class="text-muted font-weight-bold">Tahun Anggaran: {{ $year }}</p>
        </div>

        <form action="/login" method="get">
          <div class="form-group row">
            <div class="col-sm-4 mb-2">
              <select class="form-control" name="change">
                  @if($change == 'sebelum_perubahan')
                  <option value="sebelum_perubahan" hidden>Sebelum Perubahan</option>
                  @else
                  <option value="sesudah_perubahan" hidden>Sesudah Perubahan</option>
                  @endif
                <option value="sebelum_perubahan">Sebelum Perubahan</option>
                <option value="sesudah_perubahan">Sesudah Perubahan</option>
              </select>
            </div>
            <div class="col-sm-4 mb-2">
              <div class="input-group" id="kt_datetimepicker_2" data-target-input="nearest" data-toggle="datetimepicker">
                <input type="text" class="form-control datetimepicker-input" value="{{ $year }}" placeholder="Tahun SKPD" name="year" data-target="#kt_datetimepicker_2" required/>
              </div>
            </div>
            <div class="col-sm-4 mb-2">
              <button type="submit" class="btn btn-block btn-primary">Filter</button>
            </div>
          </div>
        </form>
        
        <canvas id="myChart" width="400" height="400"></canvas>
      </div>
      <!--end::Signin-->
      <!--begin::Signup-->
      <div class="login-form login-signup">
        <div class="text-center mb-10 mb-lg-20">
          <h3 class="font-size-h1">Sign Up</h3>
          <p class="text-muted font-weight-bold">Enter your details to create your account</p>
        </div>
        <!--begin::Form-->
        <form class="form" novalidate="novalidate" id="kt_login_signup_form">
          <div class="form-group">
            <input class="form-control form-control-solid h-auto py-5 px-6" type="text" placeholder="Fullname" name="fullname" autocomplete="off" />
          </div>
          <div class="form-group">
            <input class="form-control form-control-solid h-auto py-5 px-6" type="email" placeholder="Email" name="email" autocomplete="off" />
          </div>
          <div class="form-group">
            <input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Password" name="password" autocomplete="off" />
          </div>
          <div class="form-group">
            <input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
          </div>
          <div class="form-group">
            <label class="checkbox mb-0">
            <input type="checkbox" name="agree" />
            <span></span>I Agree the
            <a href="#">terms and conditions</a></label>
          </div>
          <div class="form-group d-flex flex-wrap flex-center">
            <button type="button" id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
            <button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
          </div>
        </form>
        <!--end::Form-->
      </div>
      <!--end::Signup-->
      <!--begin::Forgot-->
      <div class="login-form login-forgot">
        <div class="text-center mb-10 mb-lg-20">
          <h3 class="font-size-h1">Lupa Password ?</h3>
          <p class="text-muted font-weight-bold">Kami akan mengirim link penyetelan ulang password ke alamat email anda</p>
        </div>
        <!--begin::Form-->
        <form class="form" id="kt_login_forgot_form" action="{{ route('forgetPassword') }}" method="post">
          @csrf
          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend"><span class="input-group-text" > <i class="fa fa-envelope"></i> </span></div>
              <input type="email" class="form-control border-0 bg-light" name="email" placeholder="Alamat Email" autofocus required>
            </div>
          </div>
          <div class="form-group d-flex flex-wrap flex-center">
            <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Kirim</button>
            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Batal</button>
          </div>
        </form>
        <!--end::Form-->
      </div>
      <!--end::Forgot-->
    </div>
    <!--end::Content body-->
    <!--begin::Content footer for mobile-->
    <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
      <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">
        © 2021
        <a href="https://inotive.id/" target="_blank" class="text-black text-hover-primary">Inotive Technology</a>
      </div>
    </div>
    <!--end::Content footer for mobile-->

@endsection

@section('modal')

@endsection

@section('script')

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

  <script type="text/javascript">
    $(document).ready( function () {
      $('#table_id').DataTable({
        "pageLength": 1000,
        "bLengthChange": false,
        "bFilter": false,
        "paging": false,
        "ordering": false,
        "bInfo": false,
      });
    } );
  </script>

  <script type="text/javascript">
  $('#kt_datetimepicker_1').datetimepicker({
    format: "YYYY",
    viewMode: "years"
  });

  $('#kt_datetimepicker_2').datetimepicker({
    format: "YYYY",
    viewMode: "years"
  });
  </script>
  
  <script>
    var labels = [];
    var targets = [];
    var realitations = [];
    var percents = [];
    $( document ).ready(function() {
        $.ajax({
            method: "GET",
            url: "/login/laporan-singkat?change=" + "{{ $change }}" + '&year=' + "{{ $year }}"
        }).done(function(response)
        {
            console.log(response.array);
            response.array.forEach((item) => {
                labels.push(item.name);
                targets.push(item.target);
                realitations.push(item.realisasi);
                percents.push(item.persen);
            });
            chartSummary();
        });
    });
    function chartSummary()
    {   
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                    datasets: [
                    {
                        label: 'Target (Rp.)',
                        data: targets,
                        fill: false,
                        borderColor: 'blue',
                        tension: 0.1
                    },
                    {
                        label: 'Realisas (Rp.)',
                        data: realitations,
                        fill: false,
                        borderColor: 'green',
                        tension: 0.1
                    },
                    {
                        label: 'Persen (%)',
                        data: percents,
                        fill: false,
                        borderColor: 'orange',
                        tension: 0.1
                    }
                    ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    </script>

@endsection
