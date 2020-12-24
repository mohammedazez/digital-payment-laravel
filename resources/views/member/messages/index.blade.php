@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Inbox <small>Pesan Masuk</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
 	<li class="active">Pesan Masuk</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Pesan Masuk</h3>
                   <a href="#" class="btn-loading btn custom__btn-greenHover pull-right modal-open" data-id="" data-toggle="modal" data-target="#myModal" style="padding: 3px 7px;"><i class="fa fa-envelope-o"></i> Tulis Pesan</a>
                   
               <div class="box-tools">
                  @include('pagination.default', ['paginator' => $messages])
               </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
               <table class="table table-hover">
                  <tr class="custom__text-green">
                     <th>No</th>
                     <th>Nama</th>
                     <th>Subject</th>
                     <!--<th>Email</th>-->
                     <!--<th>No HP</th>-->
                     <th>Status</th>
                     <th>Tanggal Masuk</th>
                     <th>Action</th>
                  </tr>
                  <?php $no=1; ?>
                  @if($messages->count() > 0)
                  @foreach($messages as $data)
                  <tr style="font-size: 14px;">
                     <td>{{$no++}}</td>
                     <td>{{$data->name}}</td>
                     <td>{{$data->subject}}</td>
                     <!--<td>{{$data->email}}</td>-->
                     <!--<td>{{$data->phone}}</td>-->
                     @if($data->status == 0)
                     <td><label class="label label-warning">Belum Dibaca</label></td>
                     @else
                     <td><label class="label label-success">Sudah Dibaca</label></td>
                     @endif
                     <!--<td>{{$data->created_at}}</td>-->
                     <td>{{date("d M Y H:i:s", strtotime($data->updated_at))}}</td>
                     <td>
                        <form method="POST" action="{{ route('member.message.delete', $data->id) }}" accept-charset="UTF-8">
                           <input name="_method" type="hidden" value="DELETE">
                           <input name="_token" type="hidden" value="{{ csrf_token() }}">
                           <a href="{{route('member.message.show', $data->id)}}" class="btn-loading btn custom__btn-greenHover btn-sm" style="padding: 2px 5px;"><i class="fa fa-search"></i></a>
                           <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;"><i class="fa fa-trash"></i></button>
                        </form>
                     </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan='7' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
               @include('pagination.default', ['paginator' => $messages])
            </div>
         </div>
      </div><!-- /.box -->
   </div>
</section>

    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
    	<!-- konten modal-->
    	<div class="modal-content">
    		<!-- heading modal -->
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h4 class="modal-title">Kirim Pesan</h4>
    		</div>
    		<!-- body modal -->
    		<div class="modal-body">
    			<form action="{{url('member/messages/kirim')}}" method="post">
                {{ csrf_field() }}
                  <div class="box-body">
                      <div class="form-group hidden">
                        <label>Type :</label>
                        <input type="text" name="type" class="form-control" value="direct" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>ID Induk :</label>
                        <input type="text" name="id_induk" class="form-control" value="-" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>ID Balas :</label>
                        <input type="text" name="id_balas" id="id_balas" value="-" class="form-control" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>From :</label>
                        <input type="text" name="from" class="form-control" value="{{ Auth::user()->id }}" readonly>
                     </div>
                      <div class="form-group hidden">
                        <label>To :</label>
                        <input type="text" name="to" class="form-control" value="1" readonly>
                     </div>
                     <div class="form-group ">
                        <label>Subject :</label>
                        <input type="text" name="isisubject" id="isisubject" class="form-control" maxlength="50" required>
                     </div>
                     <div class="form-group">
                        <label>Isi Pesan :</label>
                        <textarea class="form-control" rows="7" name="isipesan" id="isipesan" placeholder="Isi Pesan" required></textarea>
                     </div>
                  </div>
                 <div class="modal-footer">
                    <button type="submit" class="btn custom__btn-greenHover">Kirim</button>
        		</div>
               </form>
    		</div>
    		<!-- footer modal -->
    		
    	</div>
       </div>
    </div>
@endsection
@section('js')
<script>
$(document).ready(function() {
    $("#myModal").on("hidden.bs.modal", function(){
        $('#isisubject').val('');
        $('#isipesan').val('');
    });
});
</script>
@endsection