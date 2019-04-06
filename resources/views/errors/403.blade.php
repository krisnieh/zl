@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="alert alert-warning col-10 col-sm-5">
        <h1><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></h1><p>权限不足</p>
    </div>
    <div class="col-10 col-sm-5"><a href="javascript:history.back(-1)" class="btn btn-info btn-block">返回</a></div>
</div>

@endsection