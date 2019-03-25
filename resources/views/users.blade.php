<?php
    $a = new App\Helpers\Au;
    $p = new App\Helpers\Prepare;
?>

@extends ('nav')

@section ('content')
<div class="d-flex justify-content-center align-items-center w-100">
<div class="col-sm-8">

  <a class="btn btn-default" href="/users"><i class="fa fa-user-o ico-space" aria-hidden="true"></i>用户</a>
  <form>
    <div class="input-group mb-3 input-group-sm col-10 col-sm-5">
      <input type="text" class="form-control">
      <div class="input-group-prepend">
        <a href="#" class="input-group-text text-dark"><i class="fa fa-search ico-space" aria-hidden="true"></i></a>
      </div>
    </div>
  </form>
  
  <div id="accordion">
    @if(isset($records))
        @if(count($records))
            @foreach($records as $record)
                <div class="card card-space">
                  <div class="card-header">
                    <a data-toggle="collapse" href="#collapse{{ $record->id }}">
                      <strong class="text-{{ $a->locked($record->id) ? "warning" : "dark" }}">
                        {{ json_decode($record->info)->name }}
                        &nbsp&nbsp{{ json_decode($record->accounts)->mobile }}
                      </strong> 
                    </a>

                    @if($a->control($record->id))
                        @if($a->locked($record->id))
                            <a href="/unlock/{{ $record->id }}" class="btn btn-default btn-sm pull-right text text-success"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                        @else
                            <a href="/lock/{{ $record->id }}" class="btn btn-default btn-sm pull-right text text-warning"><i class="fa fa-lock" aria-hidden="true"></i></a>
                        @endif
                    @endif

                  </div>
                  <div id="collapse{{ $record->id }}" class="collapse" data-parent="#accordion">
                    <div class="card-body card-body-space">
                        <p>

                          @if($a->control($record->id))
                          <div class="dropdown">
                            <a class="btn btn-sm btn-warning dropdown-toggle pull-right text-white" data-toggle="dropdown">
                              授权
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" href="/user/{{ $record->id }}/staff">员工</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="/user/{{ $record->id }}/agent">代理商</a>
                              <a class="dropdown-item" href="/user/{{ $record->id }}/salesman">代理商员工</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="/user/{{ $record->id }}/customer">客户</a>
                            </div>
                          </div> 
                          @endif

                            <span class="badge badge-pill badge-success">{{ $a->type($record->id) }}</span>
                            @if($a->locked($record->id))
                                <span class="badge badge-pill badge-warning">账号锁定</span>
                            @endif

                            @if($a->manager($record->id))
                                <span class="badge badge-pill badge-info">管理员</span>
                            @endif
                        </p>
                        <p><i class="fa fa-mobile-phone ico-space" aria-hidden="true"></i>{{  $p->show($record->accounts, 'mobile') }}<br><i class="fa fa-map-marker ico-space" aria-hidden="true"></i>{{  $p->show($record->info, 'addr') }}</p>

                        @if(count($record->child))
                            <p>
                                @foreach($record->child as $item)
                                    {{ $p->show($item->info, 'name') }}
                                @endforeach
                            </p>
                        @endif

                    </div>
                  </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-center align-items-center w-100 alert">{{ $records->links() }}</div>
        @else
            <div class="alert alert-info">尚无记录</div>
        @endif
    @else
        <div class="alert alert-danger">服务器异常</div>
    @endif
  </div>
</div>
</div>
@endsection