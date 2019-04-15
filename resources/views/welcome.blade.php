<?php
    $p = new App\Helpers\Prepare;
?>
@extends('../nav')

@section('content')

    <div class="col-12 col-sm-6 cent">
        <div class="cent">
            <img class="ok" src="{{ URL::asset('svg/logo.svg') }}">
            <h5>众乐速配</h5>
            <p class="text text-danger">高能 . 高效</p>
            <p>
                @if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && Cache::has(session('openid')))
                    <a href="/register" class="btn btn-block btn-success">继续, 完成注册</a>
                @else
                    <a href="/apps" class="btn btn-success btn-sm"><i class="fa fa-th ico-space" aria-hidden="true"></i> 前往应用中心</a>
                @endif
            </p>
            <div>
            <div><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('/public/image/jh.jpg', .2)->errorCorrection('H')->size(200)->generate('https://u.wechat.com/MDIPFmQjFRrvOV-W5t72JlU')) !!} "></div>
            <small>欢迎关注众乐速配-江和自补液。江和携手经销商，助您2019生意腾飞! 若需有业务/代理或者需要帮助,请扫码添加微信,谢谢!</small>
            
        </div>
        </div>
    </div>


@endsection