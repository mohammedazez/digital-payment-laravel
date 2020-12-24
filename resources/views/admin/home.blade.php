@extends('layouts.admin')


@section('content')
<section class="content-header hidden-xs">
<h1>Home <small>Dashboard</small></h1>
<ol class="breadcrumb">
 	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
 	<li class="active">Dashboard</li>
</ol>
</section>
<section class="content">
  <div class="row">
      <div class="col-md-12">
          <div class="box box-widget" style="margin-bottom: 10px;background-color: #FDFDFD;text-align:center;">
              <div class="pull-left" style="padding-left:10px;padding-right:10px;padding-bottom:5px;padding-top:10px;margin-top:0px;font-style:italic;">Status Server</div>
            <div class="pull-right" style="padding-left:10px;padding-right:10px;padding-bottom:5px;padding-top:10px;;margin-top:0px;font-style:italic;">
                @if($GeneralSettings->status_server == 1)
                <input type="checkbox" disabled checked data-toggle="toggle" data-size="mini" data-width="85" data-on="NORMAL" data-off="GANGGUAN">
                @else
                <input type="checkbox" disabled data-toggle="toggle" data-size="mini" data-width="85" data-on="NORMAL" data-off="GANGGUAN">
                @endif
            </div>
            <div class="clearfix"></div>
            
            <div class="pull-left" style="padding-left:10px;padding-right:10px;padding-bottom:10px;padding-top:5px;margin-top:0px;font-style:italic;">Maintenance Mode</div>
            <div class="pull-right" style="padding-left:10px;padding-right:10px;padding-bottom:10px;padding-top:5px;margin-top:0px;font-style:italic;">
                @if($GeneralSettings->status == 1)
                <input id="toggle-event" type="checkbox" checked data-toggle="toggle" data-size="mini" data-width="85" data-on="LIVE" data-off="MAINTENANCE">
                @else
                <input id="toggle-event" type="checkbox" data-toggle="toggle" data-size="mini" data-width="85" data-on="LIVE" data-off="MAINTENANCE">
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    
      <div class="col-md-6">
          <div id="pie1">
            <div class="box box-widget" style="margin-bottom: 10px;background-color: #FDFDFD;text-align:center;">
                <!-- chart -->
                <div id="chart-produk-kategori-div"></div>
                @piechart('produkkategori', 'chart-produk-kategori-div')
            </div>
        </div>
      </div>


      <div class="col-md-6">
          <div id="pie2">
            <div class="box box-widget" id="pie2" style="margin-bottom: 10px;background-color: #FDFDFD;text-align:center;">
                <!-- chart -->
                <div id="chart-produk-div"></div>
                @piechart('produk', 'chart-produk-div')
            </div>
        </div>
      </div>

      <!--<div class="col-md-12">-->
          <!--<div id="pie3">-->
      <!--  <div class="box box-widget" id="pie3" style="margin-bottom: 10px;background-color: #FDFDFD;text-align:center;">-->
            <!-- chart -->
      <!--      <div id="chart-member-trx-div"></div>-->
      <!--      @piechart('member', 'chart-member-trx-div')-->
      <!--  </div>-->
      <!--  </div>-->
      <!--</div>-->

      <div class="col-lg-3 col-xs-6">
         <!-- small box -->
         <div class="small-box bg-primary">
            <div class="inner text-center">
               <h3>{{$countTransaksi}}</h3>

               <p>Transaksi</p>
            </div>
            <a href="{{url('/admin/transaksi/produk')}}" class="btn-loading small-box-footer">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
         </div>
      </div>
     <!-- ./col -->
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-primary">
         <div class="inner text-center">
           <h3>{{$countTransaksiBulan}}</h3>
            
            <?php 
               $bulan = array(
                  '01' => 'Januari',
                  '02' => 'Februari',
                  '03' => 'Maret',
                  '04' => 'April',
                  '05' => 'Mei',
                  '06' => 'Juni',
                  '07' => 'Juli',
                  '08' => 'Agustus',
                  '09' => 'September',
                  '10' => 'Oktober',
                  '11' => 'November',
                  '12' => 'Desember',
            ); ?>
           <p style="text-transform: capitalize;">Transaksi Bulan {{strtolower($bulan[date('m')])}}</p>
         </div>
         <a href="{{url('/admin/transaksi/produk')}}" class="btn-loading small-box-footer">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-primary">
         <div class="inner text-center">
           <h3>{{$countUser}}</h3>

           <p>Users</p>
         </div>
         <a href="{{route('users.index')}}" class="btn-loading small-box-footer">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
     <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-primary">
         <div class="inner text-center">
           <h3>{{$countDepositBulan}}</h3>

           <p style="text-transform: capitalize;">Deposit Bulan {{strtolower($bulan[date('m')])}}</p>
         </div>
         <a href="{{url('/admin/transaksi/deposit')}}" class="btn-loading small-box-footer">Lihat Semua <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
     <!-- ./col -->
   </div>
  <div class="row">
      <div class="col-md-6">
              <div class="form-group">
                <label>By Date:</label>
                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepickerFrom">
                  <div class="input-group-addon">TO</div>
                  <input type="text" class="form-control pull-right" id="datepickerTo">
                  <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="cariRange">Filter</button>
                  </span>
                </div>
              </div>
        </div>
      <div class="col-md-6">
            <!-- Date -->
              <div class="form-group">
                <label>By Mount:</label>
                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="mountDate">
                  <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" id="cariMonth">Filter</button>
                  </span>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
        </div>
    </div>
   <div class="row">
      <div class="col-md-3">
         <div class="box box-green ">
            <div class="box-header with-border box-green">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">Aktivitas</h3>
               <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table class="table" id="aktivitas" style="font-size: 13px;">
                  <thead>
                  <tr>
                     <td>Transaksi</td>
                     <td>:</td>
                     <td>{{$countTransaksiHari}}</td>
                     <td><a href="{{url('/admin/transaksi/produk')}}" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;">Lihat</a></td>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                     <td>Member Baru</td>
                     <td>:</td>
                     <td>{{$countUserHari}}</td>
                     <td><a href="{{route('users.index')}}" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;">Lihat</a></td>
                  </tr>
                  <tr>
                     <td>Permintaan Deposit</td>
                     <td>:</td>
                     <td>{{$countDepositHari}}</td>
                     <td><a href="{{url('/admin/transaksi/deposit')}}" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;">Lihat</a></td>
                  </tr>
                  <tr>
                     <td>Pesan Masuk</td>
                     <td>:</td>
                     <td>{{$countMessageHari}}</td>
                     <td><a href="{{route('messages.index')}}" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;">Lihat</a></td>
                  </tr>
                  </tbody>
               </table>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
      <div class="col-md-3">
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">Total Transaksi</h3>
               <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="ttl_transaksinya">
              <table class="table" style="font-size: 13px;">
                <thead>
                  <tr>
                    <td>Server</td>
                    <td class="text-left">&nbsp;:&nbsp;</td>
                    <td class="text-right"><b>{{number_format($totalTrxServerHari, 0, '.', '.')}}</b></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Laba</td>
                    <td class="text-left">&nbsp;:&nbsp;</td>
                    <td class="text-right"><b>{{number_format($totalKeuntunganHari, 0, '.', '.')}}</b></td>
                  </tr>
                  <tr>
                    <td>Total</td>
                    <td class="text-left">&nbsp;:&nbsp;</td>
                    <td class="text-right"><b>{{number_format($totalTransaksiHari, 0, '.', '.')}}</b></td>
                  </tr>
                </tbody>
              </table>
               <div>
                  <table class="table table-bordered" >
                     <tr style="background-color: #F8F8F8;font-size: 10px;">
                        <th style="text-align: center;">Berhasil</th>
                        <th style="text-align: center;">Pending</th>
                        <th style="text-align: center;">Gagal</th>
                     </tr>
                     <tr align="center" style="font-size: 15px;font-weight: bold;">
                        <td>{{$trxSuccess}}</td>
                        <td>{{$trxProses}}</td>
                        <td>{{$trxGagal}}</td>
                     </tr>
                  </table>
               </div>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
      <div class="col-md-3">
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">Cek Saldo Utama dan Saldo Users</h3>
               <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <center>
                    <p style="font-style: italic;margin-top:10px;">Saldo Server <br><label><u>Rp {{number_format($saldo, 0, '.', '.')}}</u></label></p>
                    <p style="font-style: italic;margin-top:10px;">Total Saldo Semua User <br><label><u>Rp {{number_format($totalUserBalance, 0, '.', '.')}}</u></label></p>
                    <div class="form-group hidden">
                      <label class="radio-inline">
                        <input type="radio" name="ceksaldo" value="saldo_server" id="server_chk">Saldo Server
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="ceksaldo" value="saldo_member" id="member_chk" checked="checked">Saldo Member
                      </label>
                    </div>
                    <div id="selc-user">
                      <div class="form-group">
                          <select class="form-control" id="pilih_member" style="width:100% !important";>
                          </select>
                      </div>
                    </div>
                  </center>
                <div class="text-center">
                    <a href="Javascript:;" id="ceksaldo" class="btn btn-primary btn-sm">Cek Saldo User</a>
                </div>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
      <div class="col-md-3">
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">Deposit</h3>
               <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="deposit">
               <div style="text-align: center;margin-bottom: 10px;">
                  <span style="font-size: 20px;font-weight: bold;">{{$countDepositHari}}</span><br>
               </div>
               <div>
                  <table class="table table-bordered" >
                     <tr style="background-color: #F8F8F8;font-size: 10px;">
                        <th style="text-align: center;">Menunggu</th>
                        <th style="text-align: center;">Validasi</th>
                        <th style="text-align: center;">Berhasil</th>
                        <th style="text-align: center;">Gagal</th>
                     </tr>
                     <tr align="center" style="font-size: 15px;font-weight: bold;">
                        <td>{{$reqMenunggu}}</td>
                        <td>{{$reqValidasi}}</td>
                        <td>{{$reqSuccess}}</td>
                        <td>{{$reqGagal}}</td>
                     </tr>
                  </table>
               </div>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
   </div>
   <div class="row">
      <!-- /.col -->
      <div class="col-md-6">
         <!-- USERS LIST -->
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title">Member Baru</h3>

               <div class="box-tools pull-right">
                  <span class="label label-primary">{{$newUser->count()}} Member Baru</span>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
               <ul class="users-list clearfix">
                  @foreach($newUser as $data)
                  <li>
                     @if($data->image != null)
                     <img src="{{asset('admin-lte/dist/img/avatar/'.$data->image)}}" alt="User Image">
                     @else
                     <img src="{{ asset('admin-lte/dist/img/avatar5.png')}}" alt="User Image">
                     @endif
                     <a class="btn-loading users-list-name" href="{{route('users.show', $data->id)}}">{{$data->name}}</a>
                     <span class="users-list-date">{{date("d M", strtotime($data->created_at))}}</span>
                  </li>
                  @endforeach
               </ul>
            </div>
            <div class="box-footer text-center">
               <a href="{{route('users.index')}}" class="btn-loading uppercase custom__text-green">Lihat Semua Users</a>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <!-- TOP USERS -->
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="text-transform: capitalize;">10 Top User Bulan {{strtolower($bulan[date('m')])}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
               <ul class="users-list clearfix">
                  @foreach($topUsers as $data)
                  <li style="width: 20%">
                     @if($data->image != null)
                     <img src="{{asset('admin-lte/dist/img/avatar/'.$data->image)}}" alt="User Image">
                     @else
                     <img src="{{ asset('admin-lte/dist/img/avatar5.png')}}" alt="User Image">
                     @endif
                     <a class="btn-loading users-list-name" href="{{route('users.show', $data->id)}}">{{$data->name}}</a>
                     <span class="users-list-date">{{$data->transaksis->count()}} Transaksi</span>
                  </li>
                  @endforeach
               </ul>
            </div>
            <div class="box-footer text-center">
               <a href="{{route('users.index')}}" class="btn-loading uppercase custom__text-green">Lihat Semua Users</a>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('js')
<script>
    $("#mountDate").datepicker( {
        format: "MM yyyy",
        viewMode: "months", 
        minViewMode: "months"
    }).datepicker("setDate", "0");
    
    $("#datepickerFrom").datepicker({
        // dateFormat: "dd-mm-yy"
        format: "dd-mm-yyyy"
    }).datepicker("setDate", "0");
    
    $("#datepickerTo").datepicker({
        // dateFormat: "dd-mm-yy"
        format: "dd-mm-yyyy"
    }).datepicker("setDate", "0");
    
    
    $('#cariRange').on('click', btnSearchRange);
    function btnSearchRange(){
        var FromDate = $('#datepickerFrom').val();
        var ToDate = $('#datepickerTo').val();
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });
        $.ajax({
            type: "GET",
            url : "{{ url('/admin/GetDataByRage') }}",
            data: {'_token': '{{csrf_token()}}',FromDate:FromDate,ToDate:ToDate},
            success: function( response ) {
                let data_respon = JSON.parse(response);
                $('#aktivitas').html(data_respon.aktivitas);
                $('#ttl_transaksinya').html(data_respon.trxnya);
                $('#deposit').html(data_respon.deposit);
                
                // $('#chart-produk-kategori-div').html(data_respon.chartprodukkategori);
                // $('#chart-produk-div').html(data_respon.chartproduk);
                // $('#pie3').html(data_respon.chartmember);
                
                $.unblockUI();
            }
        });
    }
    
    $('#cariMonth').on('click', btnSearchMonth);
    function btnSearchMonth(){
        var Mount = $('#mountDate').val();
        var vArray = Mount.split(" ");
        var vRes = vArray.slice(0).join('-'); 
        
        // console.log(vArray[0]);
        // return false;
        $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } });
        $.ajax({
            type: "GET",
            url : "{{ url('/admin/GetDataByMonth') }}",
            data: {'_token': '{{csrf_token()}}',bulan:vRes},
            success: function( response ) {
                // console.log(response);
                let data_respon = JSON.parse(response);
                $('#aktivitas').html(data_respon.aktivitas);
                $('#ttl_transaksinya').html(data_respon.trxnya);
                $('#deposit').html(data_respon.deposit);
                // $('#pie1').html(data_respon.pie1);
                // $('#pie2').html(data_respon.pie2);
                // $('#pie3').html(data_respon.pie3);
                $.unblockUI();
            }
        });
    }
    
    $('#ceksaldo').on('click', function(){

      var jenis = $("input[name='ceksaldo']:checked").val();
      var member = $("#pilih_member").val();
        $('#ceksaldo').attr('disabled', true);
        $('#ceksaldo').text('Loading...');
      $.ajax({
            type: "GET",
            url : "{{ url('/admin/ceksaldo/') }}",
            data: {'_token': '{{csrf_token()}}',jenis:jenis,member:member},
            success: function( msg ) {
            $('#ceksaldo').removeAttr('disabled');
            $('#ceksaldo').text('Cek Saldo');
              // console.log(msg);
              if(msg == 'error'){
                swal("Error!", "Cek Saldo gagal,Api tidak terhubung!", "error");
                return false;
              }
              swal({
                  title: ""+msg+"",
                  // text: ""+data+"",
                  type: "info",
                  showCancelButton: false,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
              });
            }
        });
  });

    $('#pilih_member').select2({
        placeholder: "Pilih Member",
        ajax: {
            url: "{{ url('/admin/get-member') }}",            
            data: function(params){
                 return {
                     q: params.term
                 };
             },
            processResults: function(data){
                $('#pilih_member').empty();
                return {
                    results : data,
                }
            }

        }
    });

    // show or hide
  $(function () {
        $("input[name='ceksaldo']").click(function () {
            if ($("#server_chk").is(":checked")) {
                $('#pilih_member').empty();
                $("#selc-user").hide();

            } else {
                $('#pilih_member').empty();
                $("#selc-user").show();
            }
        });
    });


    $(function() {
        $('#toggle-event').change(function() {
            
            if($(this).prop('checked') == true){
                var value = 'live';
            }else{
                var value = 'maintenance';
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/admin/mode') }}",
                dataType: "json",
                type: "POST",
                data: {
                    'value': value
                },
                success: function (response) {
                    if(response.status == 1){
                        toastr.success("MODE LIVE");
                    }else{
                        toastr.error("MODE MAINTENANCE");
                    }
                    
                },
                error: function (response) {
                    toastr.error("TERJADI KESALAHAN, SILAHKAN REFRESH HALAMAN DAN LAKUKAN LAGI.");
                }
            });
        });
      });
</script>

@endsection