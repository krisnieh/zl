<?php
    $p = new App\Helpers\Prepare;
?>
@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-6">
        <div class="card-body">
            <img class="ok" src="{{ URL::asset('svg/logo.svg') }}">
            <h5>众乐速配</h5>
            <p class="text text-danger">省钱 . 高效</p>
            <p>
                @if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && Cache::has(session('openid')))
                    <a href="/register" class="btn btn-block btn-success">继续, 完成注册</a>
                @endif
            </p>
        </div>
    </div>
</div>

@endsection