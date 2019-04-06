<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
<!DOCTYPE html>
<html>
<head>
  <title>众乐速配</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" >
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar bg-light fixed-top">
  <a href="/" ><img class="logo" src="{{ URL::asset('svg/logo.svg') }}"></a>
    @if(Auth::check())
    <div class="dropdown menu">
      <button type="button" class="btn btn-light" data-toggle="dropdown">{{ $r->me()->name }}</button>
      <div class="dropdown-menu  dropdown-menu-right">
        <a class="dropdown-item" href="/ad"><i class="fa fa-qrcode ico-space" aria-hidden="true"></i>推荐码</a>
        <a class="dropdown-item" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
        @if($r->admin() || $r->master())
        <a class="dropdown-item" href="/pass"><i class="fa fa-check-square-o ico-space" aria-hidden="true"></i>审批中心</a>
        @endif
        <div class="dropdown-divider"></div>
        @if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) 
          <a class="dropdown-item text text-danger" href="/wechat/cut"><i class="fa fa-cut ico-space" aria-hidden="true"></i>解除此微信关联</a>
        @else
          <a class="dropdown-item" href="/logout"><i class="fa fa-power-off ico-space" aria-hidden="true"></i>退出</a>
        @endif
      </div>
    </div>
    @endif
</nav>
<div class="head"></div>

<div class="container-fluid">
  @yield('content')
</div>

<div class="footer">
  <small>2019 &copy; 众乐速配</small>
  <small><br><a class="text-dark" href="http://www.miitbeian.gov.cn">沪ICP备17040558号</a></small>
</div>
<script>
    // ajax csrf
    $(function(){ 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
    });
</script>
</body>
</html>