@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Transaksi <small>Transfer Bank</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="#">Transaksi</a></li>
        <li><a href="{{url('/admin/transaksi/saldo-rekening')}}" class="btn-loading">Transfer Bank</a></li>
    	<li class="active">Detail Trx</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/transaksi/transfer-bank')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Trx #{{$data->id}}</h3>
                 <div class="box-tools">
                 </div>
               </div>
               <div class="box-body">
                  <table class="table" style="font-size:14px;">
                     <tr>
                        <td>ID</td>
                        <td>:</td>
                        <td>#{{$data->id}}</td>
                     </tr>
                     <tr>
                        <td>User pengirim</td>
                        <td>:</td>
                        <td><a href="{{url('/admin/users', $data->user->id)}}">{{$data->user->name}}</a></td>
                     </tr>
                     <tr>
                        <td>Penerima</td>
                        <td>:</td>
                        <td>{{$data->penerima}}</td>
                     </tr>
                     <tr>
                        <td>Nominal</td>
                        <td>:</td>
                        <td>Rp {{number_format($data->nominal, 0, '.', '.')}} </td>
                     </tr>
                     <tr>
                        <td>Kode Bank</td>
                        <td>:</td>
                        <td>{{$data->code_bank}}</td>
                     </tr>
                     <tr>
                        <td>Bank</td>
                        <td>:</td>
                        <td>{{$data->jenis_bank}}</td>
                     </tr>
                     <tr>
                        <td>No.Rekening</td>
                        <td>:</td>
                        <td>{{$data->no_rekening}}</td>
                     </tr>
                     <tr>
                        <td>Note/Keterangan</td>
                        <td>:</td>
                        <td>{!!$data->note!!}</td>
                     </tr>
                     <tr>
                        <td>Tgl Update</td>
                        <td>:</td>
                        <td>{{$data->created_at}}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        @if($data->status == 0)
                        <td><span class="label label-warning">PROSES</span></td>
                        @elseif($data->status == 1)
                        <td><span class="label label-success">BERHASIL</span></td>
                        @elseif($data->status == 2)
                        <td><span class="label label-danger">GAGAL</span></td>
                        @else
                        <td><span class="label label-danger">REFUND</span></td>
                        @endif
                     </tr>
                  </table>
               </div>
               <div class="box-footer">
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/transfer-bank/pending', $data->id)}}" class="btn-loading btn btn-warning btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status TRX menjadi MENUNGGU ?');"><i class="fa fa-exclamation-circle"></i> MENUNGGU</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/transfer-bank/refund', $data->id)}}" class="btn-loading btn btn-primary btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status TRX menjadi REFUND ?');"><i class="fa fa-refresh"></i> RAFUND</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/transfer-bank/success', $data->id)}}" class="btn-loading btn btn-success btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status TRX menjadi BERHASIL ?');"><i class="fa fa-check"></i> BERHASIL</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <button type="button" class="btn-loading btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalStatus" data-backdrop="static" data-keyboard="false"><i class="fa fa-times"></i> GAGAL</button>
                        </div>
                    </div>
               </div>
            </div>
         </div>
      </div>
   </section>

<div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Note #{{$data->id}}</h4>
            </div>
            <div class="modal-body" style="text-align:center;">
                <div id="body">
                    <input type="hidden" name="id" id="id" value="{{$data->id}}">
                    <center>
                    <div class="form-group">
                      <label for="note">Note:</label>
                      <textarea class="form-control" rows="5" name="note" id="note" placeholder="Note" required></textarea>
                    </div>
                    </center>
                </div>
                <div class="modal-footer" style="text-align:center;">
                    <button type="button" class="submit btn btn-primary" id="proses_ubah_status">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

</section>
@endsection
@section('js')
<script> 
$('#proses_ubah_status').on('click', function(){
    var note = $('#note').val();
    $.ajax({
        url: '/admin/transaksi/transfer-bank/failed/{{$data->id}}',
        type: "post",
        data: {
            '_token': '{{csrf_token()}}',
            'note':note, 
        },
        
        success: function(data){
            console.log(data);
            // if ((data.errors)){
            //  $('#body').text(data.errors);
            // }else{
                location.reload();
            // }
            
        }
    });     
});

</script>
@endsection