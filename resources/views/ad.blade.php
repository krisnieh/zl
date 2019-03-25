@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-6">
        <div class="card-body">
            <img class="ok" src="{{ URL::asset('svg/logo.svg') }}">
            <h5>众乐速配</h5>
            <p class="text text-danger">{!! QrCode::generate('Make me into a QrCode!'); !!}</p>
            <p>
                
            </p>
        </div>
    </div>
</div>

@endsection