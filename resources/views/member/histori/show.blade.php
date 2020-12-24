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
	<h1>Riwayat <small>Transaksi</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/member/riwayat-transaksi')}}" class="btn-loading"> Riwayat Transaksi</a></li>
    	<li class="active">Detail Transaksi #{{$transaksi->id}}</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header with-border">
                  <h3 class="box-title"><a href="{{url('/member/riwayat-transaksi')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Detail Transaksi</h3>
                  <div class="box-tools pull-right">
                       <a href="{{url('/member/trx-print',$transaksi->id)}}" target="_blank"><i class="fa fa-print fa-lg" style="margin-top: 8px;margin-right: 5px;"></i> CETAK STRUK</a>
                    </div>
               </div>
               <div class="box-body" style="color: #6E6C6C">
                  <?php
                     $produk = App\AppModel\Pembelianproduk::where('product_id', $transaksi->code)->first(); 
                  ?>
                  @if( !is_null($produk) )
                  <table>
                     <tr>
                        <td width="50px">
                           @if($produk->pembelianoperator->img_url !== null)
                           <img src="{{$produk->pembelianoperator->img_url}}" style="display: inline;width: 40px;">
                           @else
                           <img src="{{asset('/assets/images/icons/icon-152x152.png')}}" style="display: inline;width: 40px;">
                           @endif
                        <td>
                           <span class="text-primary" style="font-size: 20px;font-weight: bold;">{{$produk->pembelianoperator->product_name}}</span><br>
                           <span>{{$transaksi->produk}}</span>
                        </td>
                     </tr>
                  </table>
                  @endif
                  
                  <?php
                     $produkPembayaran = App\AppModel\Pembayaranproduk::where('code', $transaksi->code)->first(); 
                  ?>
                  @if( !is_null($produkPembayaran) )
                  <table>
                     <tr>
                        <td width="50px">
                           <img src="{{asset('/assets/images/icons/icon-152x152.png')}}" style="display: inline;width: 40px;">
                        <td>
                           <span class="custom__btn-green" style="font-size: 20px;font-weight: bold;">{{$produkPembayaran->pembayaranoperator->product_name}}</span><br>
                           <span>{{$transaksi->produk}}</span>
                        </td>
                     </tr>
                  </table>
                  @endif
                  <div style="margin-top: 10px;">
                     <span class="pull-left">Order ID</span>
                     <span class="pull-right">Tanggal</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     <span class="pull-left custom__text-green" style="font-size: 20px;font-weight: bold;">{{$transaksi->id}}</span>
                     <span class="pull-right">{{date("d M Y H:m:s", strtotime($transaksi->created_at))}}</span>
                  </div>
                  <div class="clearfix"></div>
                  <div style="margin-top: 10px;">
                     <span">Nomor Handphone</span>
                  </div>
                  <div>
                     <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">{{$transaksi->target}}</span>
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Nomor / ID Pelanggan</span>
                  </div>
                  <div>
                     <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">{{$transaksi->mtrpln}}</span>
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Serial Number / Token / Security Code</span>
                  </div>
                  <div>
                     <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">{{$transaksi->token}}</span>
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Total</span>
                  </div>
                  <div>
                     <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">Rp {{number_format($transaksi->total, 0 ,'.', '.')}}</span>
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Status</span>
                  </div>
                  <div>
                     @if($transaksi->status == 0)
                     <span class="text-warning" style="font-size: 20px;font-weight: bold;">PROSES</span>
                     @elseif($transaksi->status == 1)
                     <span class="text-success" style="font-size: 20px;font-weight: bold;">BERHASIL</span>
                     @elseif($transaksi->status == 2)
                     <span class="text-danger" style="font-size: 20px;font-weight: bold;">GAGAL</span>
                     @elseif($transaksi->status == 3)
                     <span class="text-primary" style="font-size: 20px;font-weight: bold;">REFUND</span>
                     @endif
                     
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Catatan</span>
                  </div>
                  <div>
                     <small>{{$transaksi->note}}</small>
                  </div>
               </div>
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