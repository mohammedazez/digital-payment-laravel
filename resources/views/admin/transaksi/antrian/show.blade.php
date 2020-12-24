@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Transaksi <small>Antrian Pembelian</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="#">Transaksi</a></li>
        <li><a href="{{url('/admin/transaksi/antrian')}}" class="btn-loading">Antrian Pembelian</a></li>
    	<li class="active">Detail Antrian Pembelian</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/transaksi/antrian')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Antrian Pembelian #{{$antrian->id}}</h3>
               </div>
               <div class="box-body">
                  <table class="table" style="font-size:14px;">
                     <tr>
                        <td>ID Antrian</td>
                        <td>:</td>
                        <td>#{{$antrian->id}}</td>
                     </tr>
                     <tr>
                        <td>Kode Produk</td>
                        <td>:</td>
                        <td>{{$antrian->code}}</td>
                     </tr>
                     <tr>
                        <td>Produk</td>
                        <td>:</td>
                        <td>{{$antrian->produk}}</td>
                     </tr>
                     <tr>
                        <td>NoHP</td>
                        <td>:</td>
                        <td>{{$antrian->target}}</td>
                     </tr>
                     <tr>
                        <td>IDPel</td>
                        <td>:</td>
                        <td>{{$antrian->mtrpln}}</td>
                     </tr>
                     <tr>
                        <td>Note/Keterangan</td>
                        <td>:</td>
                        <td>{!!$antrian->note!!}</td>
                     </tr>
                     <tr>
                        <td>Pengirim</td>
                        <td>:</td>
                        <td>{{$antrian->user->name}}</td>
                     </tr>
                     <tr>
                        <td>IP Address</td>
                        <td>:</td>
                        <td>{{$antrian->pengirim}}</td>
                     </tr>
                     <tr>
                        <td>Tgl Request</td>
                        <td>:</td>
                        <td>{{$antrian->created_at}}</td>
                     </tr>
                     <tr>
                        <td>Tgl Update</td>
                        <td>:</td>
                        <td>{{$antrian->updated_at}}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        @if($antrian->status == 0)
                        <td><span class="label label-warning">PENDING</span></td>
                        @elseif($antrian->status == 1)
                        <td><span class="label label-success">DIPROSES</span></td>
                        @else
                        <td><span class="label label-danger">GAGAL</span></td>
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