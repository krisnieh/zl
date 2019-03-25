@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-6">
           <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->merge('/public/image/qrcode_logo.png', .2)->errorCorrection('H')->generate($url)) !!} ">
            <h5>众乐速配</h5>
            <small class="text text-grey">提示: 有效1天</small>
        </div>
    </div>
</div>

@endsection