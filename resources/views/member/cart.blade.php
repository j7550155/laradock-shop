@extends('member.layouts')

@section('content')
<h1>購物車</h1>

@if($errors AND count($errors))
<ul style="color:red;">@foreach($errors->all() as $err)<li> {{ $err }} </li>@endforeach
</ul>@endif
<div class="row">
    <div class="col-md-2" >
    </div>
    <div class="col-md-8">
        <table class="table table-hover">
            <tr>
                <td>#</td>
                <td>產品</td>
                <td>價格</td>
                <td>數量</td>
                <td>總價</td>
                <td>刪除</td>
            </tr>
            @php
            $total=0;
            @endphp
            @if($cart!=null)
            @foreach($cart as $item)
            <tr>
                <td>#</td>
                <td><a href="/products/{{$item['id']}}">{{$item['products']}}</a></td>
                <td>{{$item['price']}}</td>
                <td>{{$item['buyCount']}}</td>
                <td>{{$item['price'] * $item['buyCount'] }}</td>
                <td><a href="/cart/del/{{$item['cartId']}}">取消</a></td>
            </tr>
            @php
            $total+=$item['price'] * $item['buyCount'];
            @endphp
            @endforeach
            @endif
        </table>


        <a href="/buy" class="btn btn-success mt-2" style="float:right;">
            <p> 總金額:{{$total}}</p>結帳
        </a>


    </div>
</div>

@endsection