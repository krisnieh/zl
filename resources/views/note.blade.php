@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="alert alert-success col-10 col-sm-5">
        <h5><i class="fa fa-check-square-o" aria-hidden="true"></i></h5><p>{{ $text }}</p>
    </div>
</div>

@endsection