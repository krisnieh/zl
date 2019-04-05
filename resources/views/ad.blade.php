<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <span class="breadcrumb-item active"><i class="fa fa-qrcode ico-space" aria-hidden="true"></i>{{ $r->me()->name }}的推荐码</span>
</nav>

<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-4 align-items-center">
        <br>
        @if(count($qrcode))
           <div class="row"><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('/public/image/qrcode_logo.png', .2)->errorCorrection('H')->size(200)->generate($qrcode['url'])) !!} "></div>
            <div class="row"><small class="text text-danger">{{ date('Y-m-d  h:i:s', $qrcode['expire']) }} 后过期</small></div>
        @else
            <h3>获取推荐码失败</h3>
        @endif
            <br>
    </div>
    </div>
</div>
@endsection