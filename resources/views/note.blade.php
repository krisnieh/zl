@extends('../nav')

@section('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <span class="breadcrumb-item active"><i class="fa fa-bell-o ico-space" aria-hidden="true"></i>通知</span>
  </nav>

<div class="alert alert-{{ isset($color) ? $color : 'success' }} col-10 col-sm-5 cent">
    <h5><i class="fa fa-{{ isset($color) ? 'exclamation-triangle' : 'check-square-o' }}" aria-hidden="true"></i></h5><p>{{ $text }}</p>
</div>


@endsection