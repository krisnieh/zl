@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-4 align-items-center">
           <div class="row"><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('/public/image/qrcode_logo.png', .2)->errorCorrection('H')->size(200)->generate($qrcode['qrcode'])) !!} "></div>
            <div class="row"><small class="text text-grey">{{ date('Y-m-d H:m:s', $qrcode['expire']) }}</small></div>
    </div>
    </div>
</div>

@endsection