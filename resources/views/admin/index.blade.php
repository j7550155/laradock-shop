@extends('admin.layouts')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="navbar  navbar-expand-sm bg-info navbar-dark">
            <!-- <a href="#" class="navbar-brand">後台管理</a> -->
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#posts" class="nav-link" data-toggle="collapse">公告</a></li>
                <li class="nav-item"><a href="#products" class="nav-link" data-toggle="collapse">產品</a></li>
                <li class="nav-item"><a href="#orders" class="nav-link" data-toggle="collapse">訂單</a></li>
                <li class="nav-item"><a href="#" class="nav-link">#</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-9">
        @if($errors AND count($errors))
        <ul style="color:red;">@foreach($errors->all() as $err)<li> {{ $err }} </li>@endforeach
        </ul>@endif


        <!-- 模态框  新增商品-->
        <div class="modal fade" id="addProduct">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- 模态框头部 -->
                    <div class="modal-header">
                        <h4 class="modal-title">新增產品</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- 模态框主体 -->
                    <div class="modal-body">
                        <form action="/admin/product" method="post" enctype="multipart/form-data">
                            {!!csrf_field()!!}
                            <div class="form-group">
                                <label for="products">產品名:</label>
                                <input type="text" class="form-control" name="products" id="products">
                            </div>
                            <div class="from-group">
                                <label for="price">價格:</label>
                                <input type="text" class="form-control" name="price" id="price">
                            </div>
                            <div class="from-group">
                                <label for="count">數量:</label>
                                <input type="text" class="form-control" name="count" id="count">
                            </div>
                            <div class="from-group">
                                <label for="descr">描述:</label>
                                <input type="text" class="form-control" name="descr" id="descr">
                            </div>
                            <div class="from-group">
                                <label for="tags">Tags:</label>
                                <input type="text" class="form-control" name="tags" id="tags">
                            </div>
                            <div class="from-group">
                                <label for="status">狀態:</label>
                                <div class="radio">
                                    <label><input type="radio" name="status" value='Y'>Y</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="status" value='N'>N</label>
                                </div>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name='photo[]' multiple>
                                <label class="custom-file-label" for="customFile">圖檔</label>
                            </div>

                            <button type="submit" class="btn btn-primary mt-1">新增</button>
                        </form>
                    </div>
                    <!-- 模态框底部 -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- 模态框 修改商品 -->
        <div class="modal fade" id="editProduct">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- 模态框头部 -->
                    <div class="modal-header">
                        <h4 class="modal-title">修改產品</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- 模态框主体 -->
                    <div class="modal-body">
                        <form action="/admin/editProduct" method="post" enctype="multipart/form-data">
                            {!!csrf_field()!!}
                            <input type="text" style="display:none;" class="form-control" name="id" id="ePid" value="">
                            <div class="form-group">
                                <label for="products">產品名:</label>
                                <input type="text" class="form-control" name="products" id="eProducts" value="">
                            </div>
                            <div class="from-group">
                                <label for="price">價格:</label>
                                <input type="text" class="form-control" name="price" id="ePrice">
                            </div>
                            <div class="from-group">
                                <label for="count">數量:</label>
                                <input type="text" class="form-control" name="count" id="eCount">
                            </div>
                            <div class="from-group">
                                <label for="descr">描述:</label>
                                <input type="text" class="form-control" name="descr" id="eDescr">
                            </div>
                            <div class="from-group">
                                <label for="tags">Tags:</label>
                                <input type="text" class="form-control" name="tags" id="eTags">
                            </div>
                            <div class="from-group">
                                <label for="status">狀態:</label>
                                <div class="radio">
                                    <label><input type="radio" name="status" value='Y'>Y</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="status" value='N'>N</label>
                                </div>
                            </div>
                            <!-- <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name='photo[]' multiple>
                                <label class="custom-file-label" for="customFile">圖檔</label>
                            </div> -->

                            <button type="submit" class="btn btn-primary mt-1">修改</button>
                        </form>
                    </div>
                    <!-- 模态框底部 -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- 模态框 新增公告 -->
        <div class="modal fade" id="addPost">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- 模态框头部 -->
                    <div class="modal-header">
                        <h4 class="modal-title">新增公告</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- 模态框主体 -->
                    <div class="modal-body">
                        <form action="/admin/posts" method="post" enctype="multipart/form-data">
                            {!!csrf_field()!!}
                            <input type="text" style="display:none;" class="form-control" name="id" id="ePid" value="">
                            <div class="form-group">
                                <label for="title">標題:</label>
                                <input type="text" class="form-control" name="title" id="title" value="">
                            </div>
                            <div class="from-group">
                                <label for="content">內容:</label>
                                <textarea class="form-control" name="content" id="content" cols="15" rows="5"></textarea>
                                <!-- <input type="text" class="form-control" name="content" id="content"> -->
                            </div>
                            <div class="from-group">
                                <label for="tags">Tags:</label>
                                <input type="text" class="form-control" name="tags" id="tags">
                            </div>
                            <button type="submit" class="btn btn-primary mt-1">新增</button>
                        </form>
                    </div>
                    <!-- 模态框底部 -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    </div>

                </div>
            </div>
        </div>
        <div id="list">
            <div class="collapse mt-2" id="products" data-parent="#list">
                <h3>產品</h3>
                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#addProduct">
                    新增產品
                </button>
                <table class="table table-hover table-bordered table-sm mt-2">
                    <thead class="thead-default">
                        <tr>
                            <td>產品編號</td>
                            <td>產品名</td>
                            <td>產品描述</td>
                            <td>Tags</td>
                            <td>單價</td>
                            <td>數量</td>
                            <td>狀態</td>
                            <td>修改</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr id="p-{{$product['id']}}">
                            <td class="p-id">{{$product['id']}}</td>
                            <td class="p-products">{{$product['products']}}</td>
                            <td class="p-descr">{{$product['descr']}}</td>
                            <td class="p-tags"> <span class="badge badge-success">{{$product['Tags']}}</span></td>
                            <td class="p-price">{{$product['price']}}</td>
                            <td class="p-count">{{$product['count']}}</td>
                            <td class="p-status">{{$product['status']}}</td>
                            <td><button class="btn btn-danger editBtn" id="{{$product['id']}}" 　data-id="{{$product['id']}}" data-toggle="modal" data-target="#editProduct">修改</button> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              
            </div>

            <div class="collapse mt-2" id="orders" data-parent="#list">
                <h3>訂單查詢</h3>
                <div style="width:30%;">
                    <label for="oid">訂單號碼 / 會員email:</label>
                    <input type="text" class="form-control" name="order" id="order">
                    <label class="radio-inline"><input type="radio" class="orderSwitch" name="order" value="oid">訂單編號</label>
                    <label class="radio-inline"><input type="radio" class="orderSwitch" name="order" value="email">會員email</label>
                    <button class="btn btn-primary btn-sm" id="orderBtn"> 查詢 </button>
                </div>
                <table class="table table-hover table-bordered mt-2">
                    <thead>
                        <tr>
                            <td>訂單編號</td>
                            <td>產品</td>
                            <td>總價</td>
                            <td>狀態</td>
                            <td>建立日期</td>
                            <td>訂單修改</td>
                        </tr>
                    </thead>
                    <tbody id='orderData'>

                    </tbody>
                </table>
            </div>
            <div class="collapse mt-2" id="posts" data-parent="#list">
                <h3>公告</h3>
                <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#addPost">
                    新增公告
                </button>
                <table class="table table-hover table-bordered table-sm mt-2">
                    <thead class="thead-default">
                        <tr>
                            <td>編號</td>
                            <td>標題</td>
                            <td>內容</td>
                            <td>Tags</td>
                            <td>時間</td>
                            <td>管理員</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{$post['id']}}</td>
                            <td>{{$post['title']}}</td>
                            <td>{{$post['content']}}</td>
                            <td> <span class="badge badge-success">{{$post['Tags']}}</span></td>
                            <td>{{$post['created_at']}}</td>
                            <td>{{$post['uid']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {

        $('.editBtn').on('click', function() {
            // alert($(this).attr('id'));
            let pid = $(this).attr('id');
            let products = $('#p-' + pid + ' .p-products').text();
            let descr = $('#p-' + pid + ' .p-descr').text();
            let tags = $('#p-' + pid + ' .p-tags').text();
            let price = $('#p-' + pid + ' .p-price').text();
            let count = $('#p-' + pid + ' .p-count').text();
            let status = $('#p-' + pid + ' .p-status').text();
            console.log(descr)
            $('#ePid').val(pid)
            $('#eProducts').val(products)
            $('#eDescr').val(descr)
            $('#eTags').val(tags)
            $('#ePrice').val(price)
            $('#eCount').val(count)
            $('#eStatus').val(status)

        })

        $('#orderBtn').on('click', function() {
            let orderContent = $('#order').val();
            let orderSwitch = $('.orderSwitch:checked').val(); //:checked
            console.log(orderContent + ':' + orderSwitch);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/admin/order',
                type: 'get',
                data: {
                    content: orderContent,
                    switch: orderSwitch,
                },
                error: function(res) {
                    console.log('ajax fails');
                },
                success: function(res) {
                    console.log(res);
                    $('#orderData').html('');
                    let tbody = '';
                    // console.log(val)
                    $.each(res, function(index, val) {

                        let str = '<tr><td>' + val['id'] + '</td><td>' + val['id'] + '</td><td>' + val['total_price'] + '</td><td>' + val['status'] + '</td><td>' + val['updated_at'] + '</td><td>施工中</td></tr>'
                        tbody += str;
                    })
                    $('#orderData').append(tbody);


                }
            })

        })
    })
</script>
@endsection