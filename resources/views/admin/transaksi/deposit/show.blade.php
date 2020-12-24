@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Riwayat <small>Transaksi</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="#">Transaksi</a></li>
        <li><a href="{{url('/admin/transaksi/deposit')}}" class="btn-loading">Deposit</a></li>
    	<li class="active">Detail Deposit #{{$deposits->id}}</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/admin/transaksi/deposit')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Deposit</h3>
                    <div class="box-tools">
                    </div>   
                </div>
               <div class="box-body">
                  <table class="table" style="font-size:14px;">
                     <tr>
                        <td width="30%">ID Deposit</td>
                        <td width="5%">:</td>
                        <td>#{{$deposits->id}}</td>
                     </tr>
                     <tr>
                        <td>Bank</td>
                        <td>:</td>
                        <td>{{$deposits->bank->nama_bank}}</td>
                     </tr>
                     <tr>
                        <td>Nominal Request</td>
                        <td>:</td>
                        <td>Rp {{number_format($deposits->nominal, 0 ,'.', '.')}},-</td>
                     </tr>
                     <tr>
                        <td>Nominal Transfer</td>
                        <td>:</td>
                        <td>Rp {{number_format($deposits->nominal_trf, 0 ,'.', '.')}},-</td>
                     </tr>
                     <tr>
                        <td>Note/Keterangan</td>
                        <td>:</td>
                        <td style="font-size:13px;">{!!$deposits->note!!}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        @if($deposits->status == 0)
                        <td><span class="label label-warning">MENUNGGU</span></td>
                        @elseif($deposits->status == 1)
                        <td><span class="label label-success">BERHASIL</span></td>
                        @elseif($deposits->status == 3)
                        <td><span class="label label-primary">VALIDASI</span></td>
                        @elseif($deposits->status == 2)
                        <td><span class="label label-danger">GAGAL</span></td>
                        @endif
                     </tr>
                     <tr>
                        <td>Expire</td>
                        <td>:</td>
                        @if($deposits->expire == 1)
                        <td><span class="label label-info">AKTIF</span></td>
                        @else
                        <td><span class="label label-danger">EXPIRED</span></td>
                        @endif
                     </tr>
                     <tr>
                        <td>User</td>
                        <td>:</td>
                        <td>{{$deposits->user->name}}</td>
                     </tr>
                     <tr>
                        <td>Tgl Request</td>
                        <td>:</td>
                        <td>{{$deposits->created_at}}</td>
                     </tr>
                     <tr>
                        <td>Tgl Update</td>
                        <td>:</td>
                        <td>{{$deposits->updated_at}}</td>
                     </tr>
                  </table>
               </div>
               @if($deposits->status == 0 OR  $deposits->status == 3 AND $deposits->expire == 1)
               <div class="box-footer">
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom:8px;">
                            @if($deposits->status == 3)
                            <a href="{{url('/admin/transaksi/deposit/menunggu', $deposits->id)}}" class="btn-loading btn btn-warning btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status deposit menjadi MENUNGGU ?');"><i class="fa fa-exclamation-circle"></i> MENUNGGU</a>
                            @else
                            <a href="Javascript:;" class="btn btn-warning btn-sm btn-block" disabled><i class="fa fa-exclamation-circle"></i> MENUNGGU</a>
                            @endif
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            @if($deposits->status == 0)
                            <a href="{{url('/admin/transaksi/deposit/validasi', $deposits->id)}}" class="btn-loading btn btn-primary btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status deposit menjadi VALIDASI ?');"><i class="fa fa-filter"></i> VALIDASI</a>
                            @else
                            <a href="Javascript:;" class="btn btn-primary btn-sm btn-block" disabled><i class="fa fa-filter"></i> VALIDASI</a>
                            @endif
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/deposit/success', $deposits->id)}}" class="btn-loading btn btn-success btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status deposit menjadi BERHASIL ?');"><i class="fa fa-check"></i> BERHASIL</a>
                        </div>
                        <div class="col-md-3" style="margin-bottom:8px;">
                            <a href="{{url('/admin/transaksi/deposit/gagal', $deposits->id)}}" class="btn-loading btn btn-danger btn-sm btn-block" onclick="return confirm('Anda yakin akan mengubah status deposit menjadi GAGAL ?');"><i class="fa fa-times"></i> GAGAL</a>
                        </div>
                    </div>
                    
                    
                    
                    
               </div>
               @endif
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
               <div class="box-header with-border">
                    <i class="fa fa-money"></i>
                    <h3 class="box-title">Mutasi Rekening</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
               </div><!-- /.box-header -->
               <div class="box-body" align="center">
                    <h3><b>Coming Soon</b></h3>
                    <p>Segera Hadir Mutasi Rekening</p>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
             @if($deposits->bukti != NULL)
            <div class="box box-solid box-penjelasan">
               <div class="box-header with-border">
                    <i class="fa fa-money"></i>
                    <h3 class="box-title">Bukti Pembayaran</h3>
               </div><!-- /.box-header -->
               <div class="box-body" align="center">
                  <a href="{{asset('img/validation/deposit/'.$deposits->bukti)}}" target="_blank">
                    <img class="img img-responsive" src="{{asset('img/validation/deposit/'.$deposits->bukti)}}">
                  </a>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
            @endif
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
            url: '/admin/transaksi/produk/refund/{{$deposits->id}}',
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