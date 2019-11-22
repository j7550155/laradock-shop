<div>
    <span>系統自動發送!!</span>
</div>
<div>
    <h3>訂單已成立</h3>
    <span>成立時間:{{$created_at}}</span>
    <table class="table table-hover" >
        <tr>
            <td>#</td>
            <td>產品</td>
            <td>價格</td>
            <td>數量</td>
            <td>總價</td>
            
        </tr>
        @foreach($products as $item)
        <tr>
            <td>#</td>
            <td><a href="#">{{$item['products']}}</a></td>
            <td>{{$item['price']}}</td>
            <td>{{$item['buyCount']}}</td>
            <td>{{$item['total_price']}}</td>
        </tr>
        @endforeach
    </table>
    <p>總金額:{{$total_price}}</p>
</div>