@extends('member.layouts')
<style>
    .pic {
        text-align: center;
        height: 300px;
        width: 100%;
        /* background: red; */
    }

    i {
        height: 100%;
        /* width: 100%; */
        background: white;
    }

    .pic img {
        /* text-align: center; */
        display: inline-block;
        vertical-align: top;
        width: 50%;
    }
</style>
@section('content')
<h1>{{$title}}</h1>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="row mb-2" style="height:50px;">
            <div class="col-md-12 text-center">
                <div class="alert alert-success" style="display:none;">
                    <strong>加入成功!</strong> 商品加入購物車。
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="pic">
                    <i></i>
                    <img src="{{ asset($product['photo']) }}" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div style="height:250px;">
                    <h3>{{$product['products']}}</h3>
                    <h4>{{$product['descr']}}</h4>
                    <h5><b>NT.{{$product['price']}}</b></h5>
                    <div class="form-control mb-4">
                        <label for="count">選購數量:</label>
                        <select name="count" id="count">
                            @for($i=1;$i<=$product['count'];$i++) <option value="{{$i}}">{{$i}}</option>
                                @endfor
                        </select>
                    </div>
                </div>
                <button class="btn btn-success" id="addCart" data-pid="{{$product['id']}}" style="float:right;">加入購物車</button>
            </div>
        </div>

    </div>
    @if(Auth::check())
    <i style="display:none;" id="check_lohin">Y</i>
    @endif

</div>
<script>
    $(document).ready(function() {
        let user = $('#check_lohin').html();
        $('#addCart').on('click', function() {
            if (user == undefined) {
                alert('請先登入');
                return false;
            }
            let pid = $('#addCart').data('pid');
            let add = {};
            add['pid'] = pid;
            add['count'] = $('#count').val();
            console.log(JSON.stringify(add));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/cart/add',
                type: 'post',
                data: {
                    cart: JSON.stringify(add),
                },
                error: function(res) {
                    console.log('ajax fails');
                },
                success: function(res) {
                    let obj = JSON.parse(res)
                    $('.alert-success').fadeIn();
                    setTimeout(function() {
                        $('.alert-success').fadeOut();
                    }, 2000);
                    // console.log(Object.keys(obj).length);
                    // 用cookie記住
                }
            })
        })
    })
</script>

@endsection