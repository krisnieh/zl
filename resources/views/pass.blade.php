<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <span class="breadcrumb-item active"><i class="fa fa-check-square-o ico-space" aria-hidden="true"></i>审批中心</span>
</nav>
@if($r->admin() || $r->master())
    @if(isset($orgs) && count($orgs))
        @foreach($orgs as $org)
            <h5><span class="badge badge-danger">单位</span></h5>         
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>单位</th>
                    <th>区域</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $org->name }}</td> 
                  @if($r->angentOrg($org->id))
                    <td>{{ $r->show($org->info, 'province') }} / {{ $r->show($org->info, 'city') }} / {{ $r->show($org->info, 'sub_city') }}</td>
                  @elseif($r->customerOrg($org->id))
                    <td>{{ $r->show($org->info, 'addr') }}</td>
                  @else
                    <td><a href="/pass/ok/orgs/{{ $org->id }}" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a></td>
                  </tr>

                </tbody>
              </table>
        @endforeach
    @endif

    @if(isset($users) && count($users))
        @foreach($users as $user)
              <h5><span class="badge badge-warning">人员</span></h5>         
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>单位</th>
                    <th>电话</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $r->show($user->info, 'name') }}</td>
                    <td>{{ $user->org->name }}</td>
                    <td>{{ $r->show($user->accounts, 'mobile') }}</td>
                    <td><a href="/pass/ok/users/{{ $user->id }}" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a></td>
                  </tr>

                </tbody>
              </table>
        @endforeach
    @endif

@endif

@endsection