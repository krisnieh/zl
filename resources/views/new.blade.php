<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>

@extends('../nav')

@section('content')
<nav class="breadcrumb">
<a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
<span class="breadcrumb-item active"><i class="fa fa-user-circle-o ico-space" aria-hidden="true"></i>推荐码 [{{ $r->me()->name }}]</span>
</nav>
<div class="d-flex justify-content-center align-items-center w-100 alert">
    
    <div class="card bg-light text-dark new">
        <a href="/ad/workmate" class="text-dark"><div class="card-body"><h3><i class="fa fa-user-circle-o" aria-hidden="true"></i></h3>本单位</div></a>
    </div>

@if($r->staff())
    <div class="card bg-info text-white new">
        <a href="/ad/angent" class="text-white"><div class="card-body"><h3><i class="fa fa-user-plus" aria-hidden="true"></i></h3>代理商</div></a>
    </div>
@elseif($r->angent())
    <div class="card bg-success text-white new">
        <a href="/ad/customer" class="text-white"><div class="card-body"><h3><i class="fa fa-users" aria-hidden="true"></i></h3>客&nbsp&nbsp户</div></a>
    </div>
@endif

</div>

@endsection