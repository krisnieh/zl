<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <a class="breadcrumb-item text-dark" href="/finance"><i class="fa fa-jpy ico-space" aria-hidden="true"></i>财务</a>
    <span class="breadcrumb-item active">{{ isset($record) ? $record->name : null }}</span>
</nav>
    @if(isset($record) && $r->angent())
      @if(count($record->accept))
        @foreach($record->accept as $a)
            <div class="card card-list">
                <div class="card-header card-h"><small>#</small> <strong>{{ $a->id }}</strong>
                    @if($a->state > 0 && $a->to_user)
                    <span class="pull-right badge badge-success">
                        {{ $r->show($a->seller->info, 'name') }} {{ $a->updated_at->diffForHumans() }}确认
                    </span>
                    @else
                    <small class="pull-right">{{ $a->created_at->diffForHumans() }} {{ $a->created_at }}</small> 
                    @endif
                </div>
                <div class="card-body">
                    <p class="thin-p"><span class="badge badge-{{ $a->add ? 'success' : 'danger' }}">{{ $a->from->name }} 充值 ¥{{ $a->pay }}</span> 
                        @if($r->inOrg($a->to_org) && $r->master() && $a->state == 0)
                        <a href="javascript:finish({{ $a->id }})" class="badge badge-warning"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 确认充值</a>
                        @endif 
                    </p>
                    @if($r->show($a->from->auth, 'vip'))
                    <span class="badge badge-dark">{{ $r->show($a->from->auth, 'vip') }}VIP, 可用¥:{{ $a->sum('pay') }}</span><br>
                    @endif
                    客户: {{ $r->show($a->consumer->info, 'name') }} {{ $r->show($a->consumer->accounts, 'mobile') }}<br>
                    地址: {{ $r->show($a->from->info, 'addr') }} <br>
                    金额: ¥{{ $a->pay }} <br>
                    时长: {{ $a->month }}个月 <br>
                    接收: {{ $a->to->name }}
                </div> 
            </div>
        @endforeach
      @else
        <div class="alert alert-info">暂无记录</div>
      @endif

    @elseif(isset($record) && $r->customer())

    @if($r->customer() && $r->master())
    <p><a href="/finance/new" class="btn btn-success btn-sm"><i class="fa fa-jpy" aria-hidden="true"></i> 充值</a></p>
    @endif

      @if(count($record->give))
        @foreach($record->give as $a)
            <div class="card card-list">
                <div class="card-header card-h"><small>#</small> <strong>{{ $a->id }}</strong>
                    @if($a->state > 0 && $a->to_user)
                    <span class="pull-right badge badge-success">
                        {{ $r->show($a->seller->info, 'name') }} {{ $a->updated_at->diffForHumans() }}确认
                    </span>
                    @else
                    <small class="pull-right">{{ $a->created_at->diffForHumans() }} {{ $a->created_at }}</small> 
                    @endif
                </div>
                <div class="card-body">
                    <p class="thin-p"><span class="badge badge-{{ $a->add ? 'success' : 'danger' }}">{{ $a->from->name }} 充值 ¥{{ $a->pay }}</span> 
                        @if($r->own($a->from_user) && $a->state == 0)
                        <a class="badge badge-danger" href="javascript:del({{ $a->id }})"><i class="fa fa-fire" aria-hidden="true"></i> 删除!!</a>
                        @endif 
                    </p>
                    
                    @if($r->show($a->from->auth, 'vip'))
                    <span class="badge badge-dark">{{ $r->show($a->from->auth, 'vip') }}VIP, 可用¥:{{ $a->sum('pay') }}</span><br>
                    @endif
                    
                    客户: {{ $r->show($a->consumer->info, 'name') }} {{ $r->show($a->consumer->accounts, 'mobile') }}<br>
                    地址: {{ $r->show($a->from->info, 'addr') }} <br>
                    金额: ¥{{ $a->pay }} <br>
                    时长: {{ $a->month }}个月 <br>
                    接收: {{ $a->to->name }}
                </div> 
            </div>
        @endforeach
      @else
        <div class="alert alert-info">暂无记录</div>
      @endif
    @endif
<!-- 模态框 -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog ">
      <div class="modal-content">
   
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   
        <div class="modal-body">
          请注意: 此操作将删除此充值记录且无法恢复!!
        </div>
   
        <div class="modal-footer">
          <input type="hidden" id="target">
          <a id="go" href="#" class="btn btn-danger btn-sm"><i class="fa fa-fire" aria-hidden="true"></i> 删除!!</a>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">关闭</button>
        </div>
   
      </div>
    </div>
  </div>

    <div class="modal fade" id="fModal">
    <div class="modal-dialog ">
      <div class="modal-content">
   
        <div class="modal-header">
          <strong>请输入充值信息</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   
        <div class="modal-body">

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">时长:月</span>
            </div>
            <input type="number" min="1" max="24" class="form-control" id="month" onchange="javascript:change()">
          </div>

          <div class="form-group">
              <select class="form-control" id="vip" name="level" onchange="javascript:change()">
                <option value="0">无vip设置</option>
                <option value="1">白银VIP</option>
                <option value="2">黄金VIP</option>
                <option value="3">钻石VIP</option>
              </select>
            </div>
          
        </div>
   
        <div class="modal-footer">
          <input type="hidden" id="id_f">
          <a id="go_f" href="#" class="btn btn-warning btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 确认充值</a>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">关闭</button>
        </div>
   
      </div>
    </div>
  </div>

<script>
  // 删除
  function del(id) {
    $("#myModal").modal();
    var url = '/finance/delete/' + id;

    $("#go").attr('href', url);
  }

  // 完成
  function finish(id) {
    $("#fModal").modal();
    $("#id_f").val(id);
  }

  function change() {
    var id_f = $("#id_f").val();
    var month = $("#month").val();
    var vip = $("#vip option:selected").val();
    var url = '/finance/finish/' + id_f + '/' + month + '/' + vip;

    if(month >= 1 && month <= 24) $("#go_f").attr('href', url);
  }

</script>

@endsection