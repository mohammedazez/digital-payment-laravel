@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Riwayat <small>Transaksi</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/admin/transaksi/produk')}}" class="btn-loading"> Riwayat Transaksi</a></li>
    	<li class="active">Detail Transaksi #{{$transaksiProduk->id}}</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/transaksi/produk')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Transaksi</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalStatus" data-backdrop="static" data-keyboard="false"><i class="fa fa-retweet" style="margin-right:5px;"></i> Ubah Status</button>
                        <div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Ubah Status #{{$transaksiProduk->order_id}}</h4>
                                    </div>
                                    <div class="modal-body" style="text-align:center;">
                                        <div id="body">
                                            <input type="hidden" name="order_id" id="order_id" value="{{$transaksiProduk->order_id}}">
                                            
                                            <center>
                                            <div class="form-group" style="width:30%;">
                                                <!--<label for="usr">SN:</label>-->
                                                <!--<label class="control-label col-sm-2" for="SN">SN:</label>-->
                                                <input class="form-control" type="text" name="sn" placeholder="Serial Number" id="sn" value="{{$transaksiProduk->token}}">
                                            </div>
                                            <div class="form-group" style="width:30%;">
                                                <!--<label for="usr">Status:</label>-->
                                                <!--<label class="control-label col-sm-2" for="Status">Status:</label>-->
                                              <select class="form-control" id="stt">
                                                <option value="0" {{$transaksiProduk->status == 0?'selected':''}}>PROSES</option>
                                                <option value="1" {{$transaksiProduk->status == 1?'selected':''}}>BERHASIL</option>
                                                <option value="2" {{$transaksiProduk->status == 2?'selected':''}}>GAGAL</option>
                                                <!--<option value="3" {{$transaksiProduk->status == 3?'selected':''}}>REFUND</option>-->
                                              </select>
                                            </div>
                                            </center>
                                        </div>
                                        <div class="modal-footer" style="text-align:center;">
                                            <button type="button" class="btn btn-primary" id="proses_ubah_status">Ubah Status Sekarang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                        @if($transaksiProduk->status == 1) 
                       <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-retweet" style="margin-right:5px;"></i> Refund</button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Refund Transaksi #{{$transaksiProduk->order_id}}</h4>
                                    </div>
                                    <div class="modal-body" style="text-align:center;">
                                        <div id="body">
                                            <input type="hidden" name="order_id" id="order_id" value="{{$transaksiProduk->order_id}}">
                                            <small>Refund adalah pengembalian dana kepada member di karenakan transaksi tidak valid<br>yang dilakukan oleh <b>SISTEM</b>.</small><br><br>
                                            <p>Apakah anda yakin ingin melakukan refund untuk transaksi dengan ID Transaksi : #{{$transaksiProduk->order_id}} ?</p>
                                        </div>
                                        <div class="modal-footer" style="text-align:center;">
                                            <button type="button" class="btn btn-primary" id="proses">Refund Sekarang</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                       @endif
                    </div>
               </div>
               <div class="box-body">
                  <table class="table" style="font-size:13px;">
                     <tr>
                        <td width="40%">ID Order</td>
                        <td width="5%">:</td>
                        <td>#{{$transaksiProduk->id}}</td>
                     </tr>
                     <tr>
                        <td>ID Transaksi</td>
                        <td>:</td>
                        <td>#{{$transaksiProduk->order_id}}</td>
                     </tr>
                     <tr>
                        <td>Produk</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->produk}}</td>
                     </tr>
                     <tr>
                        <td>Total (Rp)</td>
                        <td>:</td>
                        <td>Rp {{number_format($transaksiProduk->total, 0 ,'.', '.')}},-</td>
                     </tr>
                     <tr>
                        <td>Saldo Sebelum Trx (Rp)</td>
                        <td>:</td>
                        <td>Rp {{number_format($transaksiProduk->saldo_before_trx, 0 ,'.', '.')}},-</td>
                     </tr>
                     <tr>
                        <td>Saldo Sesudah Trx (Rp)</td>
                        <td>:</td>
                        <td>Rp {{number_format($transaksiProduk->saldo_after_trx, 0 ,'.', '.')}},-</td>
                     </tr>
                     <tr>
                        <td>Nomor HP Pembeli</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->target}}</td>
                     </tr>
                     <tr>
                        <td>Serial Number</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->token}}</td>
                     </tr>
                     <tr>
                        <td>ID Pelanggan PLN</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->mtrpln}}</td>
                     </tr>
                     <tr>
                        <td>Note/Keterangan</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->note}}</td>
                     </tr>
                     <tr>
                        <td>User</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->user->name}}</td>
                     </tr>
                     <tr>
                        <td>IP Address</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->pengirim}}</td>
                     </tr>
                     <tr>
                        <td>Tanggal Requets</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->created_at}}</td>
                     </tr>
                     <tr>
                        <td>Tanggal Update</td>
                        <td>:</td>
                        <td>{{$transaksiProduk->updated_at}}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        @if($transaksiProduk->status == 0)
                        <td><label class="label label-warning">PROSES</label></td>
                        @elseif($transaksiProduk->status == 1)
                        <td><span class="label label-success">BERHASIL</span></td>
                        @elseif($transaksiProduk->status == 2)
                        <td><span class="label label-danger">GAGAL</span></td>
                        @elseif($transaksiProduk->status == 3)
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
@section('js')
<script type="text/javascript">
    
    function loading() {
        $('#body').html('<div class="text-center" style="margin-top: 20px; margin-bottom:20px;"><i class="fa fa-spinner fa-2x faa-spin animated"></i></div>');
    }
    
    $('#proses_ubah_status').on('click', function(){
        var order_id = $('#order_id').val();
        var stt = $('#stt').val();
        var sn = $('#sn').val();
        loading();
        $('#proses').attr('disabled', true);
        $('#proses').text('Loading...');
         
        $.ajax({
            url: '/admin/transaksi/produk/ubahStatus/{{$transaksiProduk->id}}',
            type: "post",
            data: {
                '_token': '{{csrf_token()}}',
                'order_id':order_id, 
                'stt':stt, 
                'sn':sn, 
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
    
    $('#proses').on('click', function(){
        var order_id = $('#order_id').val();
        loading();
        $('#proses').attr('disabled', true);
        $('#proses').text('Loading...');
         
        $.ajax({
            url: '/admin/transaksi/produk/refund/{{$transaksiProduk->id}}',
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