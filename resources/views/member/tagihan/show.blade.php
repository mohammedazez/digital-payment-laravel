@extends('layouts.member')

@section('content')
<style>
.table-borderless > tbody > tr > td,
.table-borderless > tbody > tr > th,
.table-borderless > tfoot > tr > td,
.table-borderless > tfoot > tr > th,
.table-borderless > thead > tr > td,
.table-borderless > thead > tr > th {
    border: none;
}
</style>
<section class="content-header hidden-xs">
	<h1>Tagihan <small>Pembayaran</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/member/tagihan-pembayaran')}}" class="btn-loading"> Tagihan Pembayaran</a></li>
    	<li class="active">Detail Tagihan #{{$tagihan->tagihan_id}}</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header with-border">
                  <h3 class="box-title"><a href="{{url('/member/tagihan-pembayaran')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Tagihan</h3>
                  <!--<div class="box-tools pull-right">-->
                  <!--   <a href=""><i class="fa fa-print fa-lg" style="margin-top: 8px;margin-right: 5px;"></i></a>-->
                  <!--</div>-->
               </div>
               <form action="{{url('/member/process/bayartagihan')}}" method="POST">
               {{csrf_field()}}
               <div class="box-body" style="color: #6E6C6C">
                    <input type="hidden" name="order_id" value="{{$tagihan->id}}">
                    
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
                     <span class="pull-left text-primary" style="font-size: 20px;font-weight: bold;">{{$tagihan->id}}</span>
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
                  </div>
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
                     
                  </div>
               </div>
               @if($tagihan->status == 0)
               <div class="box-footer">
                   {!! app('captcha')->renderCaptchaHTML() !!}
                   <button type="submit" id="bayar" class="btn btn-primary btn-block" onclick="return confirm('Apakah Anda akan membayar Tagihan {{$tagihan->product_name}} atas nama {{$tagihan->nama}} dengan jumlah pembayaran Rp {{number_format($tagihan->jumlah_bayar, 0 ,'.', '.')}} ?');">&nbsp;&nbsp;Bayar Tagihan&nbsp;&nbsp;</button>
               </div>
               @endif
               </form>
            </div>
         </div>
         <div class="col-md-6 hidden-xs hidden-ms">
            <div class="box box-default">
               <div class="box-header">
                  <h3 class="box-title"><i class="fa fa-info-circle" style="margin-right:5px;"></i> Keterangan Status Transaksi</h3>
               </div>
               <div class="box-body" style="color: #6E6C6C">
                  <table class="table table-hover table-striped">
                     <tr>
                        <th>Satus</th>
                        <th>Keterangan</th>
                     </tr>
                     <tr>
                        <td><label class="label label-warning">PROSES</label></td>
                        <td>Sedang di proses</td>
                     </tr>
                     <tr>
                        <td><label class="label label-success">BERHASIL</label></td>
                        <td>Transaksi anda berhasil</td>
                     </tr>
                     <tr>
                        <td><label class="label label-primary">REFUND</label></td>
                        <td>Saldo anda di kembalikan</td>
                     </tr>
                     <tr>
                        <td><label class="label label-danger">GAGAL</label></td>
                        <td>Transaksi Gagal diproses</td>
                     </tr>
                     <tr>
                        <td><label class="label label-warning">PENDING</label></td>
                        <td>Transaksi pending, menunggu antrian untuk di proses</td>
                     </tr>
                     <tr>
                        <td><label class="label label-success">DIPROSES</label></td>
                        <td>Transaksi telah di proses dari antrian</td>
                     </tr>
                     <tr>
                        <td><label class="label label-warning">MENUNGGU</label></td>
                        <td>Menunggu Pembayaran</td>
                     </tr>
                     <tr>
                        <td><label class="label label-primary">VALIDASI</label></td>
                        <td>Validasi Pembayaran</td>
                     </tr>
                  </table>
               </div>
            </div>
        </div>
         
      </div>
   </section>

</section>
@endsection