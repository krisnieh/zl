@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-4 align-items-center">
        @if(count($qrcode))
           <div class="row"><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('/public/image/qrcode_logo.png', .2)->errorCorrection('H')->size(200)->generate($qrcode['url'])) !!} "></div>
            <div class="row"><small class="text text-danger">{{ date('Y-m-d H:m:s', $qrcode['expire']) }} 后过期</small></div>
        @else
            <h3>获取推荐码失败</h3>
        @endif
            <br>
    </div>
    </div>
</div>
@endsection