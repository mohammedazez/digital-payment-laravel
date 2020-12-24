@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Riwayat <small>Riwayat Transfer Bank</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="#">Transaksi</a></li>
        <li><a href="{{url('/member/transfer-bank/history')}}" class="btn-loading">Riwayat Transfer Bank</a></li>
    	<li class="active">Detail Riwayat Transfer Bank</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/member/transfer-bank')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Riwayat Transfer Bank #{{$transaksi->id}}</h3>
               </div>
               <div class="box-body">
                  <table class="table" style="font-size:14px;">
                     <tr>
                        <td>ID Trx</td>
                        <td>:</td>
                        <td>#{{$transaksi->id}}</td>
                     </tr>
                     <tr>
                        <td>User</td>
                        <td>:</td>
                        <td>{{$transaksi->name}}</td>
                     </tr>
                     <tr>
                        <td>Kode Bank</td>
                        <td>:</td>
                        <td>{{$transaksi->code_bank}}</td>
                     </tr>
                     <tr>
                        <td>Jenis Bank</td>
                        <td>:</td>
                        <td>{{$transaksi->jenis_bank}}</td>
                     </tr>
                     <tr>
                        <td>Penerima</td>
                        <td>:</td>
                        <td>{{$transaksi->penerima}}</td>
                     </tr>
                     <tr>
                        <td>No.Rekening</td>
                        <td>:</td>
                        <td>{{$transaksi->no_rekening}}</td>
                     </tr>
                     <tr>
                        <td>Nominal</td>
                        <td>:</td>
                        <td>Rp. {{number_format($transaksi->nominal, 0, '.', '.')}}</td>
                     </tr>
                     <tr>
                        <td>Note/Keterangan</td>
                        <td>:</td>
                        <td>{!!$transaksi->note!!}</td>
                     </tr>
                     <tr>
                        <td>Tgl Request</td>
                        <td>:</td>
                        <td>{{date('d F Y H:i:s', strtotime($transaksi->created_at))}}</td>
                     </tr>
                     <tr>
                        <td>Tgl Update</td>
                        <td>:</td>
                        <td>{{date('d F Y H:i:s', strtotime($transaksi->updated_at))}}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        @if($transaksi->status == 0)
                        <td><span class="label label-warning">PROSES</span></td>
                        @elseif($transaksi->status == 1)
                        <td><span class="label label-success">BERHASIL</span></td>
                        @elseif($transaksi->status == 2)
                        <td><span class="label label-danger">BERHASIL</span></td>
                        @elseif($transaksi->status == 3)
                        <td><span class="label label-primary">REFUND</span></td>
                        @endif
                     </tr>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</section>
@endsection