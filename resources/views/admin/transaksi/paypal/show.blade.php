@extends('layouts.admin')
@section('style')
   <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
@endsection
@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Transaksi <small>Saldo Paypal</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="#">Transaksi</a></li>
        <li><a href="{{url('/admin/transaksi/paypal')}}" class="btn-loading">Saldo Paypal</a></li>
    	<li class="active">Detail Trx</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/transaksi/paypal')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Trx #{{$data->id}}</h3>
               </div>
               <div class="box-body">
                  <table class="table" style="font-size:14px;">
                     <tr>
                        <td>ID</td>
                        <td>:</td>
                        <td>#{{$data->id}}</td>
                     </tr>
                     <tr>
                        <td>TRX.ID</td>
                        <td>:</td>
                        <td>#{{$data->trxid}}</td>
                     </tr>
                     <tr>
                        <td>User</td>
                        <td>:</td>
                        <td>{{$data->user->name}}</td>
                     </tr>
                     <tr>
                        <td>Address Paypal</td>
                        <td>:</td>
                        <td>{{$data->address_paypal}}</td>
                     </tr>
                     <tr>
                        <td>Rate</td>
                        <td>:</td>
                        <td>Rp {{number_format($data->rate, 0, '.', '.')}} </td>
                     </tr>
                     <tr>
                        <td>Nominal USD</td>
                        <td>:</td>
                        <td>${{$data->nominal_usd}}</td>
                     </tr>
                     <tr>
                        <td>Nominal IDR</td>
                        <td>:</td>
                        <td>Rp {{number_format($data->nominal_idr, 0, '.', '.')}} </td>
                     </tr>
                     <tr>
                        <td>Fee</td>
                        <td>:</td>
                        <td>Rp {{number_format($data->fee, 0, '.', '.')}} </td>
                     </tr>
                     <tr>
                        <td>Total</td>
                        <td>:</td>
                        <td>Rp {{number_format($data->total, 0, '.', '.')}} </td>
                     </tr>
                     <tr>
                        <td>Transaksi Kode</td>
                        <td>:</td>
                        @if($data->transaksi_code == '' || $data->transaksi_code == null )
                            <td>-</td>
                        @else
                            <td>{{ $data->transaksi_code }}</td>
                        @endif
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
                        <td>Bukti Transfer</td>
                        <td>:</td>
                        @if($data->img == null || $data->img == '')
                            <td>Belum ada bukti transaksi</td>
                        @else
                            <td>
                                <a href="{{ asset('/img/saldo_paypal/bukti_trx/'.$data->img)}}" data-fancybox data-caption="{{$data->note}}"><span> (Lihat Bukti Transaksi)</span></a>
                            </td>
                        @endif
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
                            <button type="button" class="btn-loading btn btn-warning btn-sm btn-block" data-toggle="modal" data-target="#modalStatusMenunggu" data-backdrop="static" data-keyboard="false"><i class="fa fa-check"></i> MENUNGGU</button>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <button type="button" class="btn-loading btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modalStatusRefund" data-backdrop="static" data-keyboard="false"><i class="fa fa-check"></i> REFUND</button>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <button type="button" class="btn-loading btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#modalStatus" data-backdrop="static" data-keyboard="false"><i class="fa fa-check"></i> BERHASIL</button>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <button type="button" class="btn-loading btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modalStatusGagal" data-backdrop="static" data-keyboard="false"><i class="fa fa-times"></i> GAGAL</button>
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
                <h4 class="modal-title" id="myModalLabel">Input Data #{{$data->id}}</h4>
            </div>
            <div class="modal-body">
                <div id="body">
                    <form action="{{url('/admin/transaksi/paypal/success')}}" method="POST" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" id="id" value="{{$data->id}}">
                        
                        <label for="usr">Input Transaksi ID:</label>
                        <div class="input-group" style="width:60%;margin-bottom:18px">
                            <input class="form-control" type="text" name="transaksi_code[]" placeholder="AB1455455" value="" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" onclick="addTransactionCode()"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="transaksi_code_child"></div>
                        
                        <label for="usr">Input Address Paypal Pengirim:</label>
                        <div class="input-group" style="width:60%;margin-bottom:18px">
                            <input class="form-control" type="email" name="email_pengirim[]" placeholder="paypal@gmail.com" value="" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" onclick="addSenderAddress()"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="email_pengirim_child"></div>
                        
                        <label for="usr">Bukti Transaksi : </label>
                        <div class="input-group" style="width:60%;margin-bottom:18px">
                            <input class="form-control" type="file" name="bukti_trx[]" accept="image/*">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" onclick="addTransactionImage()"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="bukti_trx_child"></div>
                        
                        <div class="form-group">
                          <label for="note">Note (Opsional):</label>
                          <textarea class="form-control" rows="5" name="note" id="note" placeholder="Note"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="submit btn btn-primary" id="proses_ubah_status">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalStatusMenunggu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Note #{{$data->id}}</h4>
            </div>
            <div class="modal-body" style="text-align:center;">
                <div id="body">
                    <form action="{{url('/admin/transaksi/paypal/menunggu')}}" method="POST" role="form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" id="id" value="{{$data->id}}">
                        <center>
                        <div class="form-group">
                          <label for="note">Note (Opsional):</label>
                          <textarea class="form-control" rows="5" name="note" id="note" placeholder="Note"></textarea>
                        </div>
                        </center>
                        <div class="modal-footer" style="text-align:center;">
                            <button type="submit" class="submit btn btn-primary" id="proses_ubah_status_menunggu">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalStatusRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Note #{{$data->id}}</h4>
            </div>
            <div class="modal-body" style="text-align:center;">
                <div id="body">
                    <form action="{{url('/admin/transaksi/paypal/refund')}}" method="POST" role="form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" id="id" value="{{$data->id}}">
                        <center>
                        <div class="form-group">
                          <label for="note">Note (Opsional):</label>
                          <textarea class="form-control" rows="5" name="note" id="note" placeholder="Note"></textarea>
                        </div>
                        </center>
                        <div class="modal-footer" style="text-align:center;">
                            <button type="submit" class="submit btn btn-primary" id="proses_ubah_status_refund">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalStatusGagal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Note #{{$data->id}}</h4>
            </div>
            <div class="modal-body" style="text-align:center;">
                <div id="body">
                    <form action="{{url('/admin/transaksi/paypal/gagal')}}" method="POST" role="form">
                        {{csrf_field()}}
                        <input type="hidden" name="id" id="id" value="{{$data->id}}">
                        <center>
                        <div class="form-group">
                          <label for="note">Note (Opsional):</label>
                          <textarea class="form-control" rows="5" name="note" id="note" placeholder="Note"></textarea>
                        </div>
                        </center>
                        <div class="modal-footer" style="text-align:center;">
                            <button type="submit" class="submit btn btn-primary" id="proses_ubah_status_gagal">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(function($){
      var addToAll = false;
      var gallery = true;
      var titlePosition = 'inside';
      $(addToAll ? 'img' : 'img.fancybox').each(function(){
          var $this = $(this);
          var title = $this.attr('title');
          var src = $this.attr('data-big') || $this.attr('src');
          var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
          $this.wrap(a);
      });
      if (gallery)
          $('a.fancybox').attr('rel', 'fancyboxgallery');
      $('a.fancybox').fancybox({
          titlePosition: titlePosition
      });
  });

});

function addTransactionCode()
{
    var id = $('.transaksi_code_child').find('.input-group').length;
    var html = '<div class="input-group transaksi_code_'+id+'" style="width:60%;margin-bottom:18px">';
        html += '<input class="form-control" type="text" name="transaksi_code[]" placeholder="AB1455455" value="" required>';
        html += '<span class="input-group-btn">';
        html += '<button type="button" class="btn btn-danger btn-flat" onclick="removeTransactionCode('+id+')">';
        html += '<i class="fa fa-remove"></i>';
        html += '</button>';
        html += '</span>';
        html += '</div>';
        
    $(html).appendTo('.transaksi_code_child');
}

function removeTransactionCode(id)
{
    $('.transaksi_code_'+id).remove();
}

function addSenderAddress()
{
    var id = $('.email_pengirim_child').find('.input-group').length;
    var html = '<div class="input-group email_pengirim_'+id+'" style="width:60%;margin-bottom:18px">';
        html += '<input class="form-control" type="email" name="email_pengirim[]" placeholder="" value="" required>';
        html += '<span class="input-group-btn">';
        html += '<button type="button" class="btn btn-danger btn-flat" onclick="removeSenderAddress('+id+')">';
        html += '<i class="fa fa-remove"></i>';
        html += '</button>';
        html += '</span>';
        html += '</div>';
        
    $(html).appendTo('.email_pengirim_child');
}

function removeSenderAddress(id)
{
    $('.email_pengirim_'+id).remove();
}

function addTransactionImage()
{
    var id = $('.bukti_trx_child').find('.input-group').length;
    var html = '<div class="input-group bukti_trx_'+id+'" style="width:60%;margin-bottom:18px">';
        html += '<input class="form-control" type="file" name="bukti_trx[]" accept="image/*">';
        html += '<span class="input-group-btn">';
        html += '<button type="button" class="btn btn-danger btn-flat" onclick="removeTransactionImage('+id+')">';
        html += '<i class="fa fa-remove"></i>';
        html += '</button>';
        html += '</span>';
        html += '</div>';
        
    $(html).appendTo('.bukti_trx_child');
}

function removeTransactionImage(id)
{
    $('.bukti_trx_'+id).remove();
}

</script>
@endsection
    