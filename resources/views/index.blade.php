@extends('layouts')

@section('content')
<h1></h1>


<div class="row">
    <div class="col-md-2" style="background:white;">
    施工中
    </div>
    <div class="col-md-10">
        {{ $products->links() }}
        @foreach($products as $item)
        <p></p>
        <a href="/products/{{$item['id']}}">

        <div class="card mr-2 mb-2" style="width:210px; float:left;">
            <img class="card-img-top" src="{{ asset($item['photo']) }}" style="width:200px;height:300px;" alt="">
            <div class="card-body">
                <h4 class="card-title">
                    {{$item['products']}}
                </h4>
                <p class="card-text">
                    NT. {{$item['price']}}
                <span class="badge badge-success"> {{$item['Tags']}}</span>
                </p>
            </div>
        </div>
        </a>
        @endforeach

    </div>
</div>

@endsection