<?php
    $r = new App\Helpers\Role;
?>

@extends ('nav')

@section ('content')
  @if(isset($records) && count($records))         
<h5><i class="fa fa-user-circle-o ico-space" aria-hidden="true"></i>员工</h5>
<p>
    <span class="badge badge-success">{{ Auth::user()->org->name }}</span>
    <span class="badge badge-light">共{{ count($records) }}人</span>
</p>   
  <table class="table">
    <thead>
      <tr>
        <th>姓名</th>
        <th>手机号</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

    @foreach($records as $record)
        @if($r->locked($record->id))
      <tr class="table-warning">
        @elseif($r->admin($record->id))
      <tr class="text-info">  
        @elseif($r->own($record->id))
      <tr class="table-success">
        @elseif($r->master($record->id))
      <tr class="table-info">
        @else
      <tr>
        @endif

        <td>{{ $r->show($record->info, 'name') }}</td>
        <td>{{ $r->show($record->accounts, 'mobile') }}</td>
        <td>

            @if($r->higher($record->id))
            <div class="dropdown">
              <a class="btn btn-sm dropdown-toggle text-info" data-toggle="dropdown">
               <i class="fa fa-cog" aria-hidden="true"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">

                @if($r->locked($record->id))
                <a class="dropdown-item text-success" href="/unlock/{{ $record->id }}"><i class="fa fa-unlock ico-space" aria-hidden="true"></i>解锁</a>
                @else
                <a class="dropdown-item text-warning" href="/lock/{{ $record->id }}"><i class="fa fa-lock ico-space" aria-hidden="true"></i>锁定</a>
                @endif

                @if($r->admin())
                <a class="dropdown-item text-danger" href="/trans/{{ $record->id }}"><i class="fa fa-retweet ico-space" aria-hidden="true"></i>转机机构</a>
                @endif

              </div>
            </div>
            @endif

        </td>
      </tr>      
    @endforeach

    </tbody>
  </table>
  @else
    <div class="card">暂无记录</div>
  @endif
@endsection