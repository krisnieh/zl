@extends ('nav')

@section ('content')
<div class="d-flex justify-content-center align-items-center w-100">
<div class="card bg-light text-dark col-sm-4">
    <br>
    <h6><i class="fa fa-{{ $icon }} ico-space" aria-hidden="true"></i>{!! $title !!}</h6>
    <div class="card-body">
        {!! form($form) !!}
    </div>
</div>
</div>

@endsection