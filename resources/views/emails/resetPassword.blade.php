<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
</head>
<body>
  <div style="position: relative; background: #f2f2f2; width: 80%; height: auto; padding: 50px 100px; text-align: center; box-shadow: #333333 1px 1px 6px;">
    <img src="{{ $message->embed('images/logo-4-long-2.png') }}" alt="Images" style="width: 400px; height: 200px;">
    <h2>Setel Ulang Password</h2>
    <p>Halo, {{ $user->username }},</p>
    <p>Klik link dibawah ini untuk pergi ke halaman penyetelan ulang password : </p>
    <a href="{{ url('/') }}/forget-password/redirect/?token={{ $token }}&id={{ $user->id }}">
      CLICK THIS LINK
    </a>
  </div>
</body>
</html>
