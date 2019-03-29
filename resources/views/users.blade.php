<?php
    $r = new App\Helpers\Role;
?>

@extends ('nav')

@section ('content')
<h2>指定意义的颜色类</h2>
  <p>通过指定意义的颜色类可以为表格的行或者单元格设置颜色：</p>   
  @if(isset($records) && count($records))         
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
        @if($r->admin($record->id))
      <tr class="table-primary">
        @elseif($r->locked($record->id))
      <tr class="table-warning">
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
            <a class="btn btn-sm">管理</a>
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