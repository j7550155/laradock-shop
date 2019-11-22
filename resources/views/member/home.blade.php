@extends('member.layouts')

@section('content')
<div class="container">
    <div class="row mt-2">
        <div class="col-md-6 offset-3">
            <div class="col-md-12 text-center">
                <h4> 你好 ! {{Auth::user()->name}} </h4>
                <div id="postsList">
                    @foreach(Auth::user()->Notifications as $key=> $notify)
                    <div class="card">
                        <div class="card-header">
                            <a class="collapsed card-link postRead" data-toggle="collapse" href="#p{{$notify->id}}" data-read="{{$notify->read_at}}">
                                {{$notify->data['title']}}
                            </a>
                        </div>
                        <div id="p{{$notify->id}}" class="collapse" data-parent="#postsList">
                            <div class="card-body">
                                {{$notify->data['content']}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.postRead').on('click', function() {
            // alert($(this).attr('href'));
            let isRead = $(this).attr('data-read');
          
            if (isRead == '') {
                let id = $(this).attr('href').substr(2);
                $.ajax({
                    url: '/readNotify',
                    type:'get',
                    data:{
                        id:id
                    },
                    error:function(res){
                        console.log('ajax fails');
                    },
                    success:function(res){
                        console.log('reading');
                       
                        // $('.unread').html('')
                        $('.unread').html(res['count_unread'])
                    }
                })
            }else{
                console.log('已讀:'+isRead);
            }
        })

    })
</script>
@endsection