
<?php
  if(Auth::check()) $r = new App\Helpers\Role;
?>
@extends('../nav')

@section('content')

  @if(isset($record))
<nav class="breadcrumb">
    <a class="breadcrumb-item text-dark" href="/apps"><i class="fa fa-th ico-space" aria-hidden="true"></i>应用</a>
    <a class="breadcrumb-item text-dark" href="/orders"><i class="fa fa-cubes ico-space" aria-hidden="true"></i>订单</a>
    <span class="breadcrumb-item active">{{ $record->name }}</span>
</nav>

  @if($r->angentOrg($record->id))
    @if(count($record->sales))

      @foreach($record->sales as $a)

        <div class="card card-list">
          <div class="card-header card-h"><small>#</small> <strong>{{ $a->id }}</strong><small class="pull-right">{{ $a->created_at->diffForHumans() }} {{ $a->created_at }}</small> </div>
          <div class="card-body">
              <p class="thin-p"><span class="badge badge-info">订货方: {{ $a->from->name }}</span> 
                  @if($r->inOrg($a->to_org))
                  <a class="badge badge-danger" href="javascript:del({{ $a->id }})"><i class="fa fa-fire" aria-hidden="true"></i> 删除!!</a> 
                  <a href="javascript:finish({{ $a->id }})" class="badge badge-success"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 完成订单</a>
                  @endif 
              </p>
              客户: {{ $r->show($a->consumer->info, 'name') }} {{ $r->show($a->consumer->accounts, 'mobile') }}<br>
              地址: {{ $r->show($a->from->info, 'addr') }} <br>
              货物: <span class="badge badge-{{ $a->product_id == 1 ? 'warning' : 'dark' }}">{{ $a->goods->name }} {{ $a->goods->type }}</span> × <span class="badge badge-{{ $a->product_id == 1 ? 'warning' : 'dark' }}">{{ $a->num }} 箱</span><br>
              发货:{{ $a->to->name }}
              
          </div> 
      </div>
      @endforeach

    @else
      <div class="alert alert-info">暂无记录</div>
    @endif
  @endif

  @if($r->customerOrg($record->id))
    @if($r->customer() && $r->master())
    <p><a href="/orders/new" class="btn btn-success btn-sm"><i class="fa fa-cube" aria-hidden="true"></i> 订货</a></p>
    @endif

      @if(count($record->costs))

      @foreach($record->costs as $a)

        <div class="card card-list">
          <div class="card-header card-h"><small>#</small> <strong>{{ $a->id }}</strong><small class="pull-right">{{ $a->created_at->diffForHumans() }} {{ $a->created_at }}</small> </div>
          <div class="card-body">
              <p class="thin-p"><span class="badge badge-info">订货方: {{ $a->from->name }}</span> 
              </p>
              客户: {{ $r->show($a->consumer->info, 'name') }} {{ $r->show($a->consumer->accounts, 'mobile') }}<br>
              地址: {{ $r->show($a->from->info, 'addr') }} <br>
              货物: <span class="badge badge-{{ $a->product_id == 1 ? 'warning' : 'dark' }}">{{ $a->goods->name }} {{ $a->goods->type }}</span> × <span class="badge badge-{{ $a->product_id == 1 ? 'warning' : 'dark' }}">{{ $a->num }} 箱</span><br>
              发货:{{ $a->to->name }}
              
          </div> 
      </div>

      @endforeach

    @else
      <div class="alert alert-info">暂无记录</div>
    @endif

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
          请注意: 此操作将删除此订单且无法恢复!!
        </div>
   
        <div class="modal-footer">
          <input type="hidden" id="target">
          <a id="go" href="" class="btn btn-danger btn-sm"><i class="fa fa-fire" aria-hidden="true"></i> 删除!!</a>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">关闭</button>
        </div>
   
      </div>
    </div>
  </div>

    <div class="modal fade" id="fModal">
    <div class="modal-dialog ">
      <div class="modal-content">
   
        <div class="modal-header">
          <strong>请输入订单金额</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">¥</span>
            </div>
            <input type="number" class="form-control" id="price_f" onchange="javascript:change()">
          </div>
          <p class="text text-danger">请务必核对金额,提交后无法修改!!</p>
        </div>
   
        <div class="modal-footer">
          <input type="hidden" id="id_f">
          <a id="go_f" href="" class="btn btn-success btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 完成订单</a>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">关闭</button>
        </div>
   
      </div>
    </div>
  </div>

<script>
  // 删除
  function del(id) {
    $("#myModal").modal();
    var url = '/orders/delete/' + id;

    $("#go").attr('href', url);
  }

  // 完成
  function finish(id) {
    $("#fModal").modal();
    $("#id_f").val(id);
  }

  function change() {
    var id_f = $("#id_f").val();
    var price_f = $("#price_f").val();
    var url = '/orders/finish/' + id_f + '/' + price_f;

    $("#go_f").attr('href', url);
  }

</script>

@endsection

















