@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="alert alert-warning col-10 col-sm-5">
        <h1><i class="fa fa-calendar-times-o" aria-hidden="true"></i></h1><p>已过期</p>
        <p><a href="javascript:history.back(-1)" class="btn btn-warning btn-sm btn-block">返回</a></p>
    </div>
</div>

@endsection