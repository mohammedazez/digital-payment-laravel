@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Detail <small>Deposit</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url('/member/deposit')}}" class="btn-loading"> Deposit</a></li>
    	<li class="active">Detail Deposit #{{$deposits->id}}</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header with-border">
                  <h3 class="box-title"><a href="{{url('/member/deposit')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Deposit</h3>
                  <div class="box-tools pull-right">
                     <a href=""><i class="fa fa-print fa-lg" style="margin-top: 8px;margin-right: 5px;"></i></a>
                  </div>
               </div>
               <div class="box-body" style="color: #6E6C6C">
                  <table>
                     <tr>
                        <td width="50px">
                           <img src="{{asset('images/logo-FIRTZPAY-2020.png')}}" style="display: inline;width: 100px; margin-right:10px;">
                        </td>
                        <td>
                           <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">SALDO {{strtoupper($GeneralSettings->nama_sistem)}}</span><br>
                           <span>TOPUP Saldo</span>
                        </td>
                     </tr>
                  </table>
                  <div style="margin-top: 10px;">
                     <span class="pull-left">Order ID</span>
                     <span class="pull-right">Tanggal</span>
                  </div>
                  <div class="clearfix"></div>
                  <div>
                     <span class="pull-left custom__text-green" style="font-size: 20px;font-weight: bold;">{{$deposits->id}}</span>
                     <span class="pull-right">{{date("d M Y H:m:s", strtotime($deposits->created_at))}}</span>
                  </div>
                  <div class="clearfix"></div>
                  <div style="margin-top: 10px;">
                     <span">Metode Pembayaran</span>
                  </div>
                  <div>
                     <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">{{$deposits->bank->nama_bank}}</span>
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Nominal Transfer</span>
                  </div>
                  <div>
                     @if($deposits->bank_id=='5')
                        <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">BTC ({{$deposits->nominal_trf}})</span>
                     @else
                        <span class="custom__text-green" style="font-size: 20px;font-weight: bold;">Rp {{number_format($deposits->nominal_trf, 0 ,'.', '.')}},-</span>
                     @endif
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Status</span>
                  </div>
                  <div>
                     @if($deposits->status == 0)
                     <span class="text-warning" style="font-size: 20px;font-weight: bold;">MENUNGGU</span>
                     @elseif($deposits->status == 1)
                     <span class="text-success" style="font-size: 20px;font-weight: bold;">BERHASIL</span>
                     @elseif($deposits->status == 3)
                     <span class="text-primary" style="font-size: 20px;font-weight: bold;">VALIDASI</span>
                     @elseif($deposits->status == 2)
                     <span class="text-danger" style="font-size: 20px;font-weight: bold;">GAGAL</span>
                     @endif
                     
                  </div>
                  <div style="margin-top: 10px;">
                     <span">Catatan</span>
                  </div>
                  <div>
                     @if($deposits->bank_id=='5')
                        @if($deposits->status == 0)
                           <small>Menunggu pembayaran sebesar BTC ({{$deposits->nominal_trf}}). Mohon transfer sesuai nominal dibawah</small>
                        @elseif($deposits->status == 1)
                           <small>Deposit sebesar BTC ({{$deposits->nominal_trf}}) berhasil ditambahkan</small>
                        @elseif($deposits->status == 3)
                           <small>Pembayaran telah di konfirmasi, proses validasi pembayaran. Jika kami belum menerima pembayaran anda atau anda tidak transfer sesuai nominal yang tertera, maka deposit oromatis akan kembali kepada status MENUNGGU.</small>
                        @elseif($deposits->status == 2)
                           <small>Transaksi anda sudah dibatalkan, silahkan ulangi.</small>
                        @endif
                     @else
                        @if($deposits->status == 0)
                           <small>Menunggu pembayaran sebesar Rp {{number_format($deposits->nominal_trf, 0 ,'.', '.')}}. Nominal sudah termasuk kode unik dan akan dijadikan saldo. Mohon transfer sesuai nominal dibawah</small>
                        @elseif($deposits->status == 1)
                           <small>Deposit sebesar Rp {{number_format($deposits->nominal_trf, 0 ,'.', '.')}} berhasil ditambahkan</small>
                        @elseif($deposits->status == 3)
                           <small>Pembayaran telah di konfirmasi, proses validasi pembayaran. Jika kami belum menerima pembayaran anda atau anda tidak transfer sesuai nominal yang tertera, maka deposit oromatis akan kembali kepada status MENUNGGU.</small>
                        @elseif($deposits->status == 2)
                           <small>Transaksi anda sudah dibatalkan, silahkan ulangi.</small>
                        @endif
                     @endif
                  </div>
               </div>
            </div>
         </div>
         @if($deposits->status != 1 and $deposits->status == 0)
         <div class="col-md-6">
            <div class="box box-solid">
               <div class="box-header with-border">
                  <h3 class="box-title">#Step 1 - Detail Pembayaran</h3>
               </div><!-- /.box-header -->
               <div class="box-body">

                  @if($deposits->bank_id=='5')
                     <div align="center">
                        <p>Silahkan melakukan pembayaran ke addres BTC dibawah ini</p>
                        <img src="{{asset('img/banks/'.$deposits->bank->image)}}" alt="{{$deposits->bank->nama_bank}}" width="25%" class="">
                        <p>
                        <div class="container text-center" style="border: 1px solid #a1a1a1;padding: 5px;width: 20%;">
                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG($deposits->code_unik, 'QRCODE')}}" alt="barcode" />
                        </div>
                        <p>Address BTC: <b>{{$deposits->code_unik}}</b></p>
                        <p>Silahkan Transfer BTC tepat sebesar :</p>
                        <center><span style="background-color:#D5D5D5;color:#4F4F4F;font-weight:bold;font-size:18px;padding:5px 8px;">{{$deposits->nominal_trf}}</span></center>
                     </div>  
                  @else
                     <div align="center">
                        <p>Silahkan melakukan pembayaran ke nomor rekening dibawah ini</p>
                        <img src="{{asset('img/banks/'.$deposits->bank->image)}}" alt="{{$deposits->bank->nama_bank}}" width="25%" class="">
                        <p style="margin-top: 10px;font-weight: bold;">
                           {{$deposits->bank->no_rek}} <br>
                           {{$deposits->bank->atas_nama}}
                        </p>
                        <p>Silahkan Transfer tepat sebesar :</p>
                        <center><span style="background-color:#D5D5D5;color:#4F4F4F;font-weight:bold;font-size:18px;padding:5px 8px;">{{$deposits->nominal_trf}}</span></center>
                     </div>                  
                  @endif
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
         <div class="col-md-6">
            <div class="box box-solid">
               <div class="box-header with-border">
                  <h3 class="box-title">#Step 2 - Konfirmasi Pembayaran</h3>
               </div><!-- /.box-header -->
               <div class="box-body">
                  <div align="center">
                      <form action="{{url('member/deposit/konfirmasi')}}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <label>Upload Bukti Pembayaran</label>
                              <input class="form-control" name="bukti" id="bukti" type="file">
                              <input type="hidden" name="id" value="{{$deposits->id}}">
                          </div>
                         <p>Setelah anda melakukan pembayaran kerekening di atas, silahkan upload bukti pembayaran dan konfirmasi Pembayaran Anda dengan mengkil tombol di bawah ini</p>
                         <button type="submit" class="submit btn btn-primary btn-block">Saya Sudah Transfer</button>
                      </form>
                  </div>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
         @else
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
         @endif
      </div>
   </section>

</section>
@endsection