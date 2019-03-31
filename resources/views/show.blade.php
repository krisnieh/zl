<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')
<div class="d-flex justify-content-center w-100">
    <div class="card bg-light text-dark col-10 col-sm-6 show">
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
        <p><i class="fa fa-map-marker ico-space" aria-hidden="true"></i>{{ $r->show($record->info, 'addr')}}</p>
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