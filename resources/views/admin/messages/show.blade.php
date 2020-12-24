@extends('layouts.admin')
<style>
    body{
    background:#eee;
}

hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #FFFFFF;
}
a {
    color: #82b440;
    text-decoration: none;
}
.blog-comment::before,
.blog-comment::after,
.blog-comment-form::before,
.blog-comment-form::after{
    content: "";
	display: table;
	clear: both;
}

.blog-comment{
    padding-left: 5%;
	padding-right: 5%;
}

.blog-comment ul{
	list-style-type: none;
	padding: 0;
}

.blog-comment img{
	opacity: 1;
	filter: Alpha(opacity=100);
	-webkit-border-radius: 4px;
	   -moz-border-radius: 4px;
	  	 -o-border-radius: 4px;
			border-radius: 4px;
}

.blog-comment img.avatar {
	position: relative;
	float: left;
	margin-left: 0;
	margin-top: 0;
	width: 65px;
	height: 65px;
}

.blog-comment .post-comments{
	border: 1px solid #eee;
    margin-bottom: 20px;
    margin-left: 85px;
	margin-right: 0px;
    padding: 10px 20px;
    position: relative;
    -webkit-border-radius: 4px;
       -moz-border-radius: 4px;
       	 -o-border-radius: 4px;
    		border-radius: 4px;
	background: #fff;
	color: #6b6e80;
	position: relative;
}

.blog-comment .meta {
	font-size: 13px;
	color: #aaaaaa;
	padding-bottom: 8px;
	margin-bottom: 10px !important;
	border-bottom: 1px solid #eee;
}

.blog-comment ul.comments ul{
	list-style-type: none;
	padding: 0;
	margin-left: 85px;
}

.blog-comment-form{
	padding-left: 15%;
	padding-right: 15%;
	padding-top: 40px;
}

.blog-comment h3,
.blog-comment-form h3{
	margin-bottom: 40px;
	font-size: 26px;
	line-height: 30px;
	font-weight: 800;
}
   
</style>
@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Inbox <small>Pesan Masuk</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pengaturan</a></li>
        <li><a href="{{route('messages.index')}}" class="btn-loading">Pesan Masuk</a></li>
        <li class="active">Lihat Pesan Masuk</li>
   </ol>
   </section>
   <section class="content">
      <div class="row hidden-xs hidden-sm">
         <div class="col-md-12">
            <div class="box box-default">
		        <div class="blog-comment">
				<h3 class="text-success">Inbox <i><small>({{$induk_messages->subject }})</small></i></h3>
                <hr/>
    			<ul class="comments">
    				 @foreach($messages as $msg)
        				        @if($msg->from == $induk_messages->from )
            				        @if($msg->type == 'direct' )
                    			      <li class="clearfix">
                        				  @if($msg->image != null)
                                          <img src="{{asset('admin-lte/dist/img/avatar/'.$msg->image)}}" class="avatar" alt="User Image">
                                          @else
                                          <img src="{{asset('admin-lte/dist/img/avatar5.png')}}" class="avatar" alt="User Image">
                                          @endif
                    			          <div class="post-comments">
        				                      <p class="meta">{{date("d M Y H:i:s", strtotime($msg->created_at))}} <a href="{{url('/admin/users/'.$msg->from)}}">{{$msg->name}}</a> says : <i class="pull-right"><a href="#" class="modal-open" data-id="{{$msg->id}}" data-toggle="modal" data-target="#myModal"><span class="label label-primary"><i class="fa fa-reply"></i> Reply</span></a></i></p>
                    			              <p>
                    			                 {{$msg->message}}
                    			              </p>
                    			          </div>
                    			      </li>
                    			 @endif
                    			      
            				            @foreach($messages as $msg_reply)
                        				    @if($msg_reply->type == 'reply') 
                        				        @if($msg_reply->id_reply == $msg->id) 
                                			      <ul class="comments">
                                			      <li class="clearfix">
                                    				  @if($msg_reply->image != null)
                                                      <img src="{{asset('admin-lte/dist/img/avatar/'.$msg_reply->image)}}" class="avatar" alt="User Image">
                                                      @else
                                                      <img src="{{asset('admin-lte/dist/img/avatar5.png')}}" class="avatar" alt="User Image">
                                                      @endif
                                			          <div class="post-comments">
                                			              @if($msg_reply->from == Auth::user()->id)
        				                                  <p class="meta">{{date("d M Y H:i:s", strtotime($msg_reply->created_at))}} <a href="{{url('/admin/users/'.$msg_reply->from)}}">{{$msg_reply->name}}</a> says : </p>
                                			              @else
                                			              <p class="meta">{{date("d M Y H:i:s", strtotime($msg_reply->created_at))}} <a href="{{url('/admin/users/'.$msg_reply->from)}}">{{$msg_reply->name}}</a> says : <i class="pull-right"><a href="#" class="modal-open" data-id="{{$msg->id}}" data-toggle="modal" data-target="#myModal"><span class="label label-primary"><i class="fa fa-reply"></i> Reply</span></a></i></p>
                                			              @endif
                                			              <p>
                                			                 {{$msg_reply->message}}
                                			              </p>
                                			          </div>
                                			      </li>
                                			    </ul>
                            			        @endif
                            			    @endif
                            			@endforeach
                    			@endif
        			 @endforeach
        		</ul>
			</div>
			</div>
		 </div>
      </div>
      <div class="row hidden-lg hidden-md">
         <div class="col-md-12">
            <div class="box box-default">
		        <div class="blog-comment">
				<h3 class="text-success">Inbox <br/><i><small>({{$induk_messages->subject }})</small></i></h3>
                <hr/>
    			<ul class="comments">
    				 @foreach($messages as $msg)
        				        @if($msg->from == $induk_messages->from )
            				        @if($msg->type == 'direct' )
                    			      <li class="clearfix">
                        				  @if($msg->image != null)
                                          <img src="{{asset('admin-lte/dist/img/avatar/'.$msg->image)}}" class="avatar" alt="User Image">
                                          @else
                                          <img src="{{asset('admin-lte/dist/img/avatar5.png')}}" class="avatar" alt="User Image">
                                          @endif
                    			          <div class="post-comments">
        				                      <p class="meta">{{date("d M Y H:i:s", strtotime($msg->created_at))}} <a href="{{url('/admin/users/'.$msg->from)}}">{{$msg->name}}</a> says : </p>
                    			              <p>
                    			                 {{$msg->message}}
                    			              </p>
        				                      <p class="meta"><a href="#" class="modal-open" data-id="{{$msg->id}}" data-toggle="modal" data-target="#myModal"><span class="label label-primary"><i class="fa fa-reply"></i> Reply</span></a></i></p>
                    			          </div>
                    			      </li>
                    			 @endif
                    			      
            				            @foreach($messages as $msg_reply)
                        				    @if($msg_reply->type == 'reply') 
                        				        @if($msg_reply->id_reply == $msg->id) 
                                			      <li class="clearfix">
                                    				  @if($msg_reply->image != null)
                                                      <img src="{{asset('admin-lte/dist/img/avatar/'.$msg_reply->image)}}" class="avatar" alt="User Image">
                                                      @else
                                                      <img src="{{asset('admin-lte/dist/img/avatar5.png')}}" class="avatar" alt="User Image">
                                                      @endif
                                			          <div class="post-comments">
                                			              <p class="meta">{{date("d M Y H:i:s", strtotime($msg_reply->created_at))}} <a href="{{url('/admin/users/'.$msg_reply->from)}}">{{$msg_reply->name}}</a> says : </p>
                                			              <p>
                                			                 {{$msg_reply->message}}
                                			              </p>
                                			              @if($msg_reply->from != Auth::user()->id)
                                			              <p class="meta"><a href="#" class="modal-open" data-id="{{$msg->id}}" data-toggle="modal" data-target="#myModal"><span class="label label-primary"><i class="fa fa-reply"></i> Reply</span></a></i></p>
                                			              @endif
                                			          </div>
                                			      </li>
                            			        @endif
                            			    @endif
                            			@endforeach
                    			@endif
        			 @endforeach
        		</ul>
			</div>
			</div>
		 </div>
      </div>
   </section>
    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
    	<!-- konten modal-->
    	<div class="modal-content">
    		<!-- heading modal -->
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h4 class="modal-title">Balas Pesan</h4>
    		</div>
    		<!-- body modal -->
    		<div class="modal-body">
    			<form action="{{url('admin/messages/reply')}}" method="post">
                {{ csrf_field() }}
                  <div class="box-body">
                      <div class="form-group hidden">
                        <label>Type :</label>
                        <input type="text" name="type" class="form-control" value="reply" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>ID Induk :</label>
                        <input type="text" name="id_induk" class="form-control" value="{{ $induk_messages->id }}" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>ID Balas :</label>
                        <input type="text" name="id_balas" id="id_balas" class="form-control" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>From :</label>
                        <input type="text" name="from" class="form-control" value="{{ Auth::user()->id }}" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>To :</label>
                        <input type="text" name="to" class="form-control" value="{{ $induk_messages->from }}" readonly>
                     </div>
                     <div class="form-group">
                        <label>Isi Pesan :</label>
                        <textarea class="form-control" rows="7" name="isipesan" id="isipesan" placeholder="Isi Pesan" required></textarea>
                     </div>
                  </div>
                 <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Balas</button>
        		</div>
               </form>
    		</div>
    	</div>
       </div>
    </div>
</section>
@endsection
@section('js')
<script>
$(document).ready(function() {
    
    $(".modal-open").click(function () {
         var myId = $(this).data('id');
         $("#id_balas").val(myId);
    });
    
    $("#myModal").on("hidden.bs.modal", function(){
         $("#isipesan").val('');
    });
});
</script>
@endsection