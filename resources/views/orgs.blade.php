
<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends ('nav')

@section ('content')

  @if(isset($records) && count($records))
  <nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <span class="breadcrumb-item active"><i class="fa fa-sitemap ico-space" aria-hidden="true"></i>机构</span>
  </nav>
        <!-- Nav tabs -->
        <ul id="nav-tabs" class="nav nav-tabs" role="tablist">

          @foreach($records as $record)
            @if(count($record->orgType))
          <li class="nav-item">
            <a class="nav-link text-dark" data-toggle="tab" href="#tab{{ $record->id }}">{{ $record->val }} [{{ count($record->orgType) }}]</a>
          </li>
            @endif
          @endforeach

        </ul>

        <!-- Tab panes -->
        <div id="tab-content" class="tab-content">

          @foreach($records as $record)
            @if(count($record->orgType))
          <div id="tab{{ $record->id }}" class="container tab-pane"><br>
                 <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>名称</th>
                      <th>区域/地址</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
              @foreach($record->orgType as $org)
                @if($r->oLocked($org->id))
                    <tr class="table-warning">
                @elseif($r->orgMaster($org->id))
                    <tr class="table-success">
                @else
                    <tr>
                @endif
                      <td><a class="text-dark" href="/orgs/{{ $org->id }}">{{ $org->name }}</a></td>
                      @if($r->show($org->info, 'province'))
                      <td>{{ $r->show($org->info, 'province') }} / {{ $r->show($org->info, 'city') }} / {{ $r->show($org->info, 'sub_city') }}</td>
                      @else
                      <td>{{ $r->show($org->info, 'addr') }}</td>
                      @endif
                      <td>
              @if($r->admin() && !$r->ownOrg($org->id))
                @if($r->oLocked($org->id))
            <a class="btn btn-sm text-success" href="/org/unlock/{{ $org->id }}"><i class="fa fa-unlock ico-space" aria-hidden="true"></i></a>
                @else
            <a class="btn btn-sm text-warning" href="/org/lock/{{ $org->id }}"><i class="fa fa-lock ico-space" aria-hidden="true"></i></a>
                @endif
              @endif
                      </td>
                    </tr>
              @endforeach
                  </tbody>
                </table>
          </div>
            @endif
          @endforeach

      </div>
  @endif

<script>
  $(function(){ 
    $("#tab-content div:first-child").addClass("active");
    $("#nav-tabs li:first-child a").addClass("active");
  });
</script>

@endsection














