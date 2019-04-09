<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <a class="breadcrumb-item text-dark" href="/users"><i class="fa fa-user-circle-o ico-space" aria-hidden="true"></i>员工</a>
    <span class="breadcrumb-item active">{{ $r->show($record->info, 'name')}}</span>
</nav>
<div class="d-flex justify-content-center w-100">
    <div class="card bg-light text-dark col-12 col-sm-6 show-space">
        
        <h5>{{ $r->show($record->info, 'name')}}</h5>
        <p>
            <span class="badge badge-success">{{ $record->org->name }}</span>
        @if($r->admin($record->id))
            <span class="badge badge-info">管理员</span>
        @endif

        @if($r->master($record->id))
            <span class="badge badge-primary">负责人</span>
        @endif

        @if($r->locked($record->id))
            <span class="badge badge-warning">账号锁定</span>
        @endif

        @if($r->orgLocked($record->id))
            <span class="badge badge-danger">所在机构锁定</span>
        @endif
        </p>

        <p><i class="fa fa-mobile ico-space" aria-hidden="true"></i>{{ $r->show($record->accounts, 'mobile')}}</p>
        <p><i class="fa fa-map-marker ico-space" aria-hidden="true"></i>{{ $r->show($record->org->info, 'province') }}省{{ $r->show($record->org->info, 'city') }}市{{ $r->show($record->org->info, 'sub_city') }} {{ $r->show($record->org->info, 'addr') }}</p>
        <div class="hr-line-dashed"></div>
        @if(count($record->child))
        <strong>推荐用户</strong>
        <p>
    @foreach($record->child as $c)
        <a class="badge badge-info" href="/user/{{ $c->id }}">{{ $r->show($c->info, 'name') }}</a>
    @endforeach
        </p>
        @endif

    </div>
</div>

@endsection