@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-6">
        <div class="card-body">
            <img class="ok" src="{{ URL::asset('svg/logo.svg') }}">
            <p>请关联系统账号</p>
        </div>
    </div>
</div>

@endsection