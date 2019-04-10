<?php
    $p = new App\Helpers\Prepare;
?>
@extends('../nav')

@section('content')

    <div class="col-12 col-sm-6 cent">
        <div>
            <img class="ok" src="{{ URL::asset('svg/logo.svg') }}">
            <h5>众乐速配</h5>
            <p class="text text-danger">高能 . 高效</p>
            <p>欢迎关注众乐速配-江和自补液。江和携手经销商，助您2019生意腾飞!</p>
            <p>
                @if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && Cache::has(session('openid')))
                    <a href="/register" class="btn btn-block btn-success">继续, 完成注册</a>
                @else
                    <a href="/apps" class="btn-success btn btn-success btn-sm"><i class="fa fa-th ico-space" aria-hidden="true"></i> 前往应用中心</a>
                @endif
            </p>
        </div>
    </div>


@endsection