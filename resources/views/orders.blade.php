
<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')

<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <span class="breadcrumb-item active"><i class="fa fa-cubes ico-space" aria-hidden="true"></i>订单</span>
</nav>

  @if(isset($records) && count($records))         
  <div id="accordion">

    @foreach($records as $record)

<div class="card card-list">
    <div class="card-header card-h"><small>#</small> <strong>{{ $record->id }}</strong><small class="pull-right">{{ $record->created_at->diffForHumans() }} {{ $record->created_at }}</small> </div>
    <div class="card-body">
        <p class="thin-p"><span class="badge badge-info">订货方: {{ $record->from->name }}</span> 
            @if($r->inOrg($record->to_org))
            <a class="badge badge-danger" href="/orders/delete/{{ $record->id }}"><i class="fa fa-fire" aria-hidden="true"></i> 删除!!</a>
            @endif 
        </p>
        客户: {{ $r->show($record->consumer->info, 'name') }} {{ $r->show($record->consumer->accounts, 'mobile') }}<br>
        地址: {{ $r->show($record->from->info, 'addr') }} <br>
        货物: <span class="badge badge-{{ $record->product_id == 1 ? 'warning' : 'dark' }}">{{ $record->goods->name }} {{ $record->goods->type }}</span> × <span class="badge badge-{{ $record->product_id == 1 ? 'warning' : 'dark' }}">{{ $record->num }} 箱</span><br>
        发货:{{ $record->to->name }}
        
    </div> 
</div>
    @endforeach

  </div>
  @else
  <div class="alert alert-info">暂无记录</div>
  @endif

@endsection