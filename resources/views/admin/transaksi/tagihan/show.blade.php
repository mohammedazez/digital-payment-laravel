@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Transaksi <small>Tagihan Pembayaran</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/admin/transaksi/tagihan')}}" class="btn-loading"> Tagihan Pembayaran</a></li>
    	<li class="active">Detail Tagihan #{{$tagihan->tagihan_id}}</li>
   </ol>
</section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/transaksi/tagihan')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Tagihan</h3>
               </div>
               <div class="box-body">
                  <table>
                     <tr>
                        <td width="50px">
                           <img src="{{asset('/assets/images/icons/icon-152x152.png')}}" style="display: inline;width: 40px;">
                        <td>
                           <span class="text-primary" style="font-size: 20px;font-weight: bold;">Tagihan PPOB</span><br>
                           <span>{{$tagihan->product_name}}</span>
                        </td>
                     </tr>
                  </table>
                  <div style="margin-top: 10px;">
                     <span class="pull-left">Order ID</span>
                     <span class="pull-right">Tanggal</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     <span class="pull-left text-primary" style="font-size: 20px;font-weight: bold;">{{$tagihan->id}} / #{{$tagihan->tagihan_id}}</span>
                     <span class="pull-right">{{date("d M Y H:m:s", strtotime($tagihan->created_at))}}</span>
                  </div>
                  <div class="clearfix"></div>
                  <div style="margin-top: 10px;">
                     <span>Nomor Handphone</span>
                     <span class="pull-right">Jumlah Tagihan</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     <span class="text-primary" style="font-size: 20px;font-weight: bold;">{{$tagihan->phone}}</span>
                     <span class="pull-right text-primary" style="font-size: 20px;font-weight: bold;">Rp {{number_format($tagihan->jumlah_tagihan, 0, '.', '.')}}</span>
                  </div>
                   <div class="clearfix"></div>
                  <div style="margin-top: 10px;">
                     <span>Nomor / ID Pelanggan</span>
                     <span class="pull-right">Admin</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     <span class="text-primary" style="font-size: 20px;font-weight: bold;">{{$tagihan->no_pelanggan}}</span>
                     <span class="pull-right text-primary" style="font-size: 20px;font-weight: bold;">Rp {{number_format($tagihan->admin, 0, '.', '.')}}</span>
                  </div>
                  <div class="clearfix"></div>
                  <div style="margin-top: 10px;">
                     <span>Nama</span>
                     <span class="pull-right">Jumlah Bayar</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     <span class="text-primary" style="font-size: 20px;font-weight: bold;">{{$tagihan->nama}}</span>
                     <span class="pull-right text-primary" style="font-size: 20px;font-weight: bold;">Rp {{number_format($tagihan->jumlah_bayar, 0 ,'.', '.')}}</span>
                  </div>
                  <div class="clearfix"></div>
                  <div style="margin-top: 10px;">
                     <span>Status</span>
                     <span class="pull-right">Pengirim</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     @if($tagihan->status == 0)
                     <span class="text-warning" style="font-size: 20px;font-weight: bold;">MENUNGGU</span>
                     @elseif($tagihan->status == 1)
                     <span class="text-primary" style="font-size: 20px;font-weight: bold;">PROSES</span>
                     @elseif($tagihan->status == 2)
                     <span class="text-success" style="font-size: 20px;font-weight: bold;">BERHASIL</span>
                     @else
                     <span class="text-danger" style="font-size: 20px;font-weight: bold;">GAGAL</span>
                     @endif
                     <span class="pull-right text-primary" style="font-size: 15px;font-weight: bold;">{{$tagihan->user->name}}</span>
                  </div>
               </div>
               <div class="box-footer">
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/tagihan/menunggu', $tagihan->id)}}" class="btn-loading btn btn-warning btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status PEMBAYARAN menjadi MENUNGGU ?');"><i class="fa fa-exclamation-circle"></i> MENUNGGU</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/tagihan/refund', $tagihan->id)}}" class="btn-loading btn btn-primary btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status PEMBAYARAN menjadi REFUND ?');"><i class="fa fa-refresh"></i> RAFUND</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/tagihan/success', $tagihan->id)}}" class="btn-loading btn btn-success btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status PEMBAYARAN menjadi BERHASIL ?');"><i class="fa fa-check"></i> BERHASIL</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/tagihan/gagal', $tagihan->id)}}" class="btn-loading btn btn-danger btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status PEMBAYARAN menjadi GAGAL ?');"><i class="fa fa-times"></i> GAGAL</a>
                        </div>
                    </div>
               </div>
            </div>
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script type="text/javascript">
    
    function loading() {
        $('#body').html('<div class="text-center" style="margin-top: 20px; margin-bottom:20px;"><i class="fa fa-spinner fa-2x faa-spin animated"></i></div>');
    }
    $('#proses').on('click', function(){
        var order_id = $('#order_id').val();
        loading();
        $('#proses').attr('disabled', true);
        $('#proses').text('Loading...');
         
        $.ajax({
            url: '/admin/transaksi/produk/refund/{{$tagihan->id}}',
            type: "post",
            data: {
                '_token': '{{csrf_token()}}',
                'order_id':order_id, 
            },
            
            success: function(data){
                if ((data.errors)){
                	$('#body').text(data.errors);
                }else{
                    location.reload();
                }
                
            }
        });     
    });
</script>
@endsection