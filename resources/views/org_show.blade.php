<?php
  if(Auth::check()) $r = new App\Helpers\Role;
  if(isset($record)) $users = $record->users()->where('id', '>', 1)->get()
?>
@extends ('nav')

@section ('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <a class="breadcrumb-item text-dark" href="/orgs"><i class="fa fa-sitemap ico-space" aria-hidden="true"></i>机构</a>
    <span class="breadcrumb-item active">{{ $record->name }}</span>
</nav>
  @if(isset($record))
  <ul class="list-group">
    <li class="list-group-item list-group-item-light">
      <h5>员工 [{{ count($users) }}]</h5>
      <p>
    @if(count($users))
      @foreach($users as $u)
        <a class="badge badge-info" href="/user/{{ $u->id }}">{{ $r->show($u->info, 'name') }}</a>
      @endforeach
    @else
      尚无员工
    @endif
    </p>
    </li>
    <li class="list-group-item list-group-item-light">订单</li>
    <li class="list-group-item list-group-item-light">充值</li>
  </ul>
  @endif
@endsection