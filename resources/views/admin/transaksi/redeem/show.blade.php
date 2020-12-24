@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Transaksi <small>Redeem Voucher</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="#">Transaksi</a></li>
 	    <li><a href="{{url('/admin/transaksi/redeem')}}">Data Redeem Voucher</a></li>
    	<li class="active">Detail Data Redeem #{{$redeem->id}}</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/transaksi/redeem')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Redeem Voucher</h3>
               </div>
               <div class="box-body">
                  <table class="table" style="font-size:13px;">
                     <tr>
                        <td width="40%">ID Redeem</td>
                        <td width="5%">:</td>
                        <td>#{{$redeem->id}}</td>
                     </tr>
                     <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{$redeem->user->name}}</td>
                     </tr>
                     <tr>
                        <td>Kode Voucher</td>
                        <td>:</td>
                        <td>{{$redeem->voucher->code}}</td>
                     </tr>
                     <tr>
                        <td>Bonus Redeem (Rp)</td>
                        <td>:</td>
                        <td>Rp {{number_format($redeem->voucher->bonus, 0, '.', '.')}}</td>
                     </tr>
                     <tr>
                        <td>Tanggal Redeem</td>
                        <td>:</td>
                        <td>{{$redeem->created_at}}</td>
                     </tr>
                     
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>

</section>
@endsection