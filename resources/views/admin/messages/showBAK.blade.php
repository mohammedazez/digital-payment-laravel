@extends('layouts.admin')

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
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('messages.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Lihat Pesan Masuk</h3>
               </div>
               <form>
                  <div class="box-body">
                     <div class="form-group">
                        <label>Nama Pengirim :</label>
                        <input type="text" class="form-control" value="{{ $messages->name }}" readonly>
                     </div>
                     <div class="form-group">
                        <label>Email Pengirim :</label>
                        <input type="text" class="form-control" value="{{ $messages->email }}" readonly>
                     </div>
                     <div class="form-group">
                        <label>Nomor Handphone Pengirim :</label>
                        <input type="text" class="form-control" value="{{ $messages->phone }}" readonly>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
               <form>
                  <div class="box-body">
                     <div class="form-group">
                        <label>Isi Pesan :</label>
                        <textarea class="form-control" rows="7" readonly>{{$messages->message}}</textarea>
                     </div>
                     <div class="form-group">
                        <label>Dikirm Tanggal :</label>
                        <input type="text" class="form-control" value="{{ $messages->created_at }}" readonly>
                     </div>
                  </div>
               </form>
                  <div class="box-footer">
                     <a href="{{route('messages.index')}}" class="btn-loading btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                     <button type="button" class="btn-loading btn btn-primary" data-toggle="modal" data-target="#myModal">Balas</button>
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
    			<form action="{{url('admin/messages/send')}}" method="post">
                {{ csrf_field() }}
                  <div class="box-body">
                      <div class="form-group hidden">
                        <label>Type :</label>
                        <input type="text" name="type" class="form-control" value="reply" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>ID :</label>
                        <input type="text" name="id_balas" class="form-control" value="{{ $messages->id }}" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>From :</label>
                        <input type="text" name="from" class="form-control" value="{{ Auth::user()->id }}" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>To :</label>
                        <input type="text" name="to" class="form-control" value="{{ $messages->from }}" readonly>
                     </div>
                     <div class="form-group">
                        <label>Isi Pesan :</label>
                        <textarea class="form-control" rows="7" name="isipesan" placeholder="Isi Pesan"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                 </div>
               </form>
    		</div>
    		<!-- footer modal -->
    		<div class="modal-footer">
    			<button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
    		</div>
    	</div>
       </div>
    </div>
</section>
@endsection