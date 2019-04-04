@extends ('nav')

@section ('content')

<div class="row">
    <div class="col-md-2 col-sm-4 col-4 text-center app">
        <a href="/ad">
          <img src="svg/ad.svg" class="rounded-circle app-icon">
        </a>
          <h6>推荐码</h6>
    </div>

    <div class="col-md-2 col-sm-4 col-4 text-center app">
        <a href="/users">
          <img src="svg/user.svg" class="rounded-circle app-icon">
        </a>
          <h6>员工</h6>
    </div>

    <div class="col-md-2 col-sm-4 col-4 text-center app">
        <a href="/orgs">
          <img src="svg/org.svg" class="rounded-circle app-icon">
        </a>
          <h6>机构</h6>
    </div>

    <div class="col-md-2 col-sm-4 col-4 text-center app">
        <a href="/order">
          <img src="svg/finance.svg" class="rounded-circle app-icon">
        </a>
          <h6>财务</h6>
    </div>

    <div class="col-md-2 col-sm-4 col-4 text-center app">
        <a href="/users">
          <img src="svg/order.svg" class="rounded-circle app-icon">
        </a>
          <h6>部件订单</h6>
    </div>

    <div class="col-md-2 col-sm-4 col-4 text-center app">
        <a href="/users">
          <img src="svg/score.svg" class="rounded-circle app-icon">
        </a>
          <h6>积分</h6>
    </div>

</div>

@endsection