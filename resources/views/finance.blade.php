<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <span class="breadcrumb-item active"><i class="fa fa-jpy ico-space" aria-hidden="true"></i>充值</span>
</nav>
    @if(isset($records) && count($records))
        @foreach($records as $record)
            <div class="card card-list">
                <div class="card-header card-h"><small>#</small> <strong>{{ $record->id }}</strong><small class="pull-right">{{ $record->created_at->diffForHumans() }} {{ $record->created_at }}</small> </div>
                <div class="card-body">
                    <p class="thin-p"><span class="badge badge-{{ $record->add ? 'success' : 'danger' }}">{{ $record->from->name }} 充值 ¥{{ $record->pay }}</span> 
                        @if($r->own($record->from_user) && $record->state == 0)
                        <a class="badge badge-danger" href="/finance/delete/{{ $record->id }}"><i class="fa fa-fire" aria-hidden="true"></i> 删除!!</a>
                        @endif 
                    </p>
                    客户: {{ $r->show($record->consumer->info, 'name') }} {{ $r->show($record->consumer->accounts, 'mobile') }}<br>
                    地址: {{ $r->show($record->from->info, 'addr') }} <br>
                    金额: ¥{{ $record->pay }} <br>
                    时长: {{ $record->month }}个月 <br>
                    接收: {{ $record->to->name }}
                </div> 
            </div>
        @endforeach
    @else
        <div class="alert alert-info">暂无记录</div>
    @endif

@endsection