@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
    <h1>Data <small>Users</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('users.index')}}" class="btn-loading"> Users</a></li>
    	<li class="active">Detail User</li>
    </ol>
</section>
<section class="content">
  <div class="row">
     <div class="col-md-6">
        <div class="box box-default">
           <div class="box-header">
             <h3 class="box-title"><a href="{{route('users.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail User</h3>
           </div>
           <div class="box-body">
              <table class="table">
                 <tr>
                    <td width="40%">Nama Lengkap</td>
                    <td width="5%">:</td>
                    <td>{{isset($users->name)?$users->name:''}}</td>
                 </tr>
                 <tr>
                    <td>Nomor Handphone</td>
                    <td>:</td>
                    <td>{{isset($users->phone)?$users->phone:''}}</td>
                 </tr>
                 <tr>
                    <td>Alamat Email</td>
                    <td>:</td>
                    <td>{{isset($users->email)?$users->email:''}}</td>
                 </tr>
                 <tr>
                    <td>Kota Sekarang</td>
                    <td>:</td>
                    <td>{{isset($users->city)?$users->city:''}}</td>
                 </tr>
                 <tr>
                    <td>Pin</td>
                    <td>:</td>
                    <td>{{isset($users->pin)?$users->pin:''}}</td>
                 </tr>
                 <tr>
                    <td>Saldo</td>
                    <td>:</td>
                    <td>Rp {{number_format($users->saldo, 0, '.', '.')}},-</td>
                 </tr>
                 <tr>
                    <td>Hak Akses</td>
                    <td>:</td>
                    <td>{{$users->roles->first()->display_name}}</td>
                 </tr>
                 @if($users->sms_buyer != null)
                 <tr>
                    <td>SMS Buyer</td>
                    <td>:</td>
                    <td>{{isset($users->sms_buyer)?$users->sms_buyer:''}}</td>
                 </tr>
                 @endif
                 <tr>
                    <td>Status</td>
                    <td>:</td>
                    @if($users->status == 1)
                    <td><label class="label label-success">Aktif</label></td>
                    @else
                    <td><label class="label label-danger">Tidak Aktif</label></td>
                    @endif
                 </tr>
                 
                 
                 @if($users->referred_by != null)
                 <tr>
                    <td>Referred By</td>
                    <td>:</td>
                    @if(isset($referred_by->name))
                    <td><a href="{{url('/admin/users', $referred_by->id)}}" class="btn-loading">{{$referred_by->name}}</a></td>
                    @else
                    <td>-</td>
                    @endif
                 </tr>
                 @endif
                 <tr>
                    <td>Tanggal Mendaftar</td>
                    <td>:</td>
                    <td>{{isset($users->created_at)?date("d-m-Y H:i:s", strtotime($users->created_at)):''}}</td>
                 </tr>
                 <tr>
                    <td>Login Terakhir</td>
                    <td>:</td>
                    <td>{{isset($users->last_login)?date("d-m-Y H:i:s", strtotime($users->last_login)):''}}</td>
                 </tr>
              </table>
           </div>
           <div class="box-footer">
               <div>
                    <a href="{{route('users.index')}}" class="btn-loading btn btn-default"><i class="fa fa-arrow-circle-left" style="margin-right: 5px;"></i> Kembali</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-money" style="margin-right:5px;"></i> Deposit Manual</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal-ubahsaldo" data-backdrop="static" data-keyboard="false"><i class="fa fa-money" style="margin-right:5px;"></i> Ubah Saldo Manual</button>
                    
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Deposit Manual</h4>
                                </div>
                                <div class="modal-body" style="text-align:center;">
                                    <div id="body">
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div class="form-group">
                                                    <select name="bank" id="bank" class="form-control">
                                                        @foreach($bank as $data)
                                                        <option value="{{$data->id}}">{{$data->nama_bank}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Rp</div>
                                                        <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Masukkan Nominal">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="text-align:center;">
                                    <button type="button" class="btn btn-primary" id="proses">Tambah Saldo Sekarang</button>
                                </div>
                            </div>
                         </div>
                    </div>
                    <div class="modal fade" id="myModal-ubahsaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Ubah Saldo Manual</h4>
                                </div>
                                <div class="modal-body" style="text-align:center;">
                                    <div id="body">
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div class="form-group">
                                                   <textarea id="note" class="form-control" name="note" placeholder="note"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="aksi" id="aksi">
                                                        <option value="+">Tambahkan (+)</option>
                                                        <option value="-">Kurangkan (-)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Rp</div>
                                                        <input type="text" class="form-control" name="nominal_saldo" id="nominal_saldo" placeholder="Saldo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="text-align:center;">
                                    <button type="button" class="btn btn-primary" id="proses_ubahsaldo">Ubah Saldo Sekarang</button>
                                </div>
                            </div>
                         </div>
                    </div>
               </div>
               <div style="margin-top:10px!important">
                    @if($users->status_saldo != 0)
                        <a href="{{url('admin/users/block-saldo/'.$users->id)}}" class="btn btn-danger" style="margin-left:10px;"><i class="fa fa-lock" style="margin-right: 5px!important;"></i>Kunci Saldo</a>
                    @else
                        <a href="{{url('admin/users/unblock-saldo/'.$users->id)}}" class="btn btn-success"><i class="fa fa-unlock" style="margin-right:5px!important;"></i>Buka Kunci Saldo</a>
                    @endif
               </div>
           </div>
        </div>
     </div>
     <div class="col-md-6">
        <div class="box box-solid">
           <div class="box-header with-border">
              <i class="fa fa-image"></i>
              <h3 class="box-title">Avatar</h3>
           </div><!-- /.box-header -->
           <div class="box-body" align="center">

                @if($users->image != null)
                <img src="{{asset('admin-lte/dist/img/avatar/'.$users->image)}}">
                @else
                <img src="{{asset('admin-lte/dist/img/avatar5.png')}}" width="160px" height="160px">
                @endif
           </div><!-- /.box-body -->
        </div><!-- /.box -->
     </div>
     <div class="col-md-6">
        <div class="box box-solid">
           <div class="box-header with-border">
              <i class="fa fa-shopping-cart"></i>
              <h3 class="box-title">Transaksi</h3>
           </div><!-- /.box-header -->
           <div class="box-body" align="center">
              <div align="center">
                 <div>
                    <i class="fa fa-shopping-cart fa-4x"></i>
                 </div>
                 <h4 style="font-weight: bold;">Jumlah Transaksi</h4>
                 <p style="font-size:20px;font-weight: bold;">{{count($users->transaksis)}}</p>
              </div>
           </div><!-- /.box-body -->
        </div><!-- /.box -->
        
     </div>
  </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box collapsed-box">
                <div class="box-header">
                    <h3 class="box-title">Data Transaksi User - 500 Transaksi Terbaru</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="text-primary">
                            <th>ID</th>
                            <th>ID Order</th>
                            <th>Produk</th>
                            <th>No HP</th>
                            <th>ID Pel</th>
                            <th>IP Address</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                        <?php $no=1; ?>
                        @if($transaksi->count() > 0)
                        @foreach($transaksi->get() as $data)
                        <tr style="font-size: 12px;">
                            <td>{{$data->id}}</td>
                            @if($data->order_id == 0)
                            <td>-</td>
                            @else
                            <td>#{{$data->order_id}}</td>
                            @endif
                            <td>{{$data->produk}}</td>
                            <td>{{$data->target}}</td>
                            <td>{{$data->mtrpln}}</td>
                            <td>{{$data->pengirim}}</td>
                            <td>{{$data->created_at}}</td>
                            @if($data->status == 0)
                               <td><label class="label label-warning">PROSES</label></td>
                            @elseif($data->status == 1)
                               <td><label class="label label-success">BERHASIL</label></td>
                            @elseif($data->status == 2)
                            <td><span class="label label-danger">GAGAL</span></td>
                            @elseif($data->status == 3)
                            <td><span class="label label-primary">REFUND</span></td>
                            @endif
                         </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='7' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box collapsed-box">
                <div class="box-header">
                    <h3 class="box-title">Data Referral User - {{$referrals->count()}} Data</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="text-primary">
                            <th>No</th>
                            <th>USERID</th>
                            <th>Nama</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Trx bulan ini</th>
                            <th>Trx total</th>
                            <th>Tgl Daftar</th>
                        </tr>
                        <?php $no=1; ?>
                        @if($referrals->count() > 0)
                        @foreach($referrals as $data)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>#{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->city}}</td>
                            @if($data->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>{{$data->transaksis()->where('status', 1)->whereMonth('created_at', '=' ,date('m'))->whereYear('created_at', '=' ,date('Y'))->count()}}</td>
                            <td>{{$data->transaksis->where('status', 1)->count()}}</td>
                            <td>{{$data->created_at}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='8' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box collapsed-box">
                <div class="box-header">
                    <h3 class="box-title">Mutasi Saldo - 500 Data Terbaru</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="text-primary">
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Type</th>
                            <th>Jumlah</th>
                            <th>Saldo</th>
                            <th>Trxid</th>
                            <th>Keterangan</th>
                        </tr>
                        <?php $no=1; ?>
                        @if($mutasi->count() > 0)
                        @foreach($mutasi->get() as $data)
                        <tr style="font-size: 14px;">
                            <td>{{$no++}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->type}}</td>
                            <td>Rp {{number_format($data->nominal, 0, '.', '.')}}</td>
                            <td>Rp {{number_format($data->saldo, 0, '.', '.')}}</td>
                            <td>{{$data->trxid}}</td>
                            <td>{{$data->note}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='7' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
    function loading() {
        $('#body').html('<div class="text-center" style="margin-top: 20px; margin-bottom:20px;"><i class="fa fa-spinner fa-2x faa-spin animated"></i></div>');
    }
    $('#proses').on('click', function(){
        var bank = $('#bank').val();
        var nominal = $('#nominal').val();
        var user = {{$users->id}};
        loading();
        $('#proses').attr('disabled', true);
        $('#proses').text('Loading...');
         
        $.ajax({
            url: "{{ url('/admin/users/deposit-manual') }}",
            type: "post",
            data: {
                '_token': '{{csrf_token()}}',
                'bank':bank, 
                'nominal':nominal,
                'user':user,
            },
            
            success: function(data){
                if ((data.errors)){
                    alert('Nominal tidka boleh kosong.');
                    location.reload();
                }else{
                    location.reload();
                }
                
            }
        });     
    });


    $('#proses_ubahsaldo').on('click', function(){
        var nominal_saldo = $('#nominal_saldo').val();
        var note = $('#note').val();
        var aksi = $('#aksi').val();
        var user = {{$users->id}};
        loading();
        $('#proses_ubahsaldo').attr('disabled', true);
        $('#proses_ubahsaldo').text('Loading...');
         
        $.ajax({
            url: "{{ url('/admin/users/ubah-saldo-manual') }}",
            type: "post",
            data: {
                '_token': '{{csrf_token()}}',
                'nominal_saldo':nominal_saldo,
                'note':note,
                'aksi':aksi,
                'user':user,
            },
            
            success: function(data){
                if ((data.errors)){
                    alert('Nominal Saldo tidak boleh kosong.');
                    location.reload();
                }else{
                    location.reload();
                }
                
            }
        });     
    });

    $(document).ready(function() {

    function autoMoneyFormat(b){
        var _minus = false;
        if (b<0) _minus = true;
        b = b.toString();
        b=b.replace(".","");
        b=b.replace("-","");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--){
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)){
        c = b.substr(i-1,1) + "." + c;
        } else {
        c = b.substr(i-1,1) + c;
        }
        }
        if (_minus) c = "-" + c ;
        return c;
    }

      function price_to_number(v){
      if(!v){return 0;}
          v=v.split('.').join('');
          v=v.split(',').join('');
      return Number(v.replace(/[^0-9.]/g, ""));
      }
      
      function number_to_price(v){
      if(v==0){return '0,00';}
          v=parseFloat(v);
          // v=v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.split('.').join('*').split(',').join('.').split('*').join(',');
      return v;
      }
      
      function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
      }

    $('#nominal').keyup(function(){
        var nominal=parseInt(price_to_number($('#nominal').val()));

        var autoMoney = autoMoneyFormat(nominal);
        $('#nominal').val(autoMoney);
    });

    $('#nominal_saldo').keyup(function(){
        var nominal_saldo=parseInt(price_to_number($('#nominal_saldo').val()));

        var autoMoney = autoMoneyFormat(nominal_saldo);
        $('#nominal_saldo').val(autoMoney);
    });
});
</script>
@endsection