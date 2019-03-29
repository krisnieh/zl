@extends('../nav')

@section('content')
<div class="d-flex justify-content-center align-items-center w-100 alert">
    <div class="card bg-default col-12 col-sm-4 align-items-center">
           <div class="row"><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('/public/image/qrcode_logo.png', .2)->errorCorrection('H')->size(200)->generate($qrcode['url'])) !!} "></div>
            <div class="row"><small class="text text-danger">{{ date('Y-m-d H:m:s', $qrcode['expire']) }} 后过期</small></div>
            <br>
    </div>
    </div>
</div>

    <script>
        window.onload=function(){ 
            setTimeout('getTest()',1000); 
        } 

        function getTest(){ 

               alert('加载树'); 

        } 

        function manual() {
            $('#myModal').modal();
        }

        function post_set() {
            var date_start = $("#date_start").val();
            var date_end = $("#date_end").val();

            if(date_start == '' || date_end == '') {
                alert('起止时间均不得为空!');
                return false;
            }
            if(date_start >= date_end) {
                alert('截止时间不得小于或等于起始时间!');
                return false;
            }

            var post_url = "/counter/post_set";
            var post_data = {date_start:date_start, date_end:date_end};

            $.post(
                post_url,
                post_data,
                function(message){
                    location.reload();
                    // $("#modal-msg").html(message);
                    // $("#checking"+id).html("<span class=\"label label-success\">"+message+"</span>");
               }
            );
        }
    </script>

@endsection