@extends('layouts.member')
@section('content')
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
<section class="content-header hidden-xs">
	<h1>Membership <small>user</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Membership</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Membership</h3>
                </div>
                <div class="box-body" align="left">

                <div class="media">
                      @if(Auth::user()->roles()->first()->id == '1' || Auth::user()->roles()->first()->id == '2')
                        <div class="pull-left">
                            <img class="media-object" src="{{ auth()->user()->image != null ? asset('admin-lte/dist/img/avatar/'.auth()->user()->image) : asset('images/avatar.png') }}" height="100px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{Auth::user()->roles()->first()->display_name}}</h4>
                            <hr style="margin-left: 0;margin-top: 0;margin-bottom: 0;text-align: left;width: 50%;"/>
                    		    <p>
                              <span class="text-muted">All Transaksi : </span><br/>
                              <span class="label label-success">{{$countTransaksiSuccesBulan}} Transaksi</span>
                              <span class="label label-warning">{{$countTransaksiProsesBulan}} Transaksi</span>
                              <span class="label label-danger">{{$countTransaksiGagalBulan}} Transaksi</span>
                            </p>
                            <p>
                                <form id="form-membership">
                                    <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="from_level" value="{{Auth::user()->roles()->first()->id}}">
                                    <input class="form-control" type="hidden" id="id_level" name="to_level" value="3">
                                    <label>Lampirkan SIUP/TDP</label>
                                    <input class="form-control" type="file" id="siup-membership" name="siup_membership">
                                    <button class="btn custom__btn-greenHover btn-xs" id="upgrademembership" type="button">Upgrade Level</button>
                                </form>
                            </p>
                        </div>
                        <div class="well well-sm">
                          Lever User anda saat ini adalah <b>{{Auth::user()->roles()->first()->display_name}}</b>.<br/>
                          Akumulasi Transaksi ({{(date("d-m-Y", strtotime(Auth::user()->created_at)))}} - {{date("d-m-Y")}}) :
                          <ol>
                            <li>{{$countTransaksiSuccesBulan}} Transaksi Success</li>
                            <li>{{$countTransaksiProsesBulan}} Transaksi Procces</li>
                            <li>{{$countTransaksiGagalBulan}} Transaksi Gagal</li>
                          </ol>
                        </div>
                      @endif
                      @if(Auth::user()->roles()->first()->id == '3')
                        <div class="pull-left">
                            <img class="media-object" src="{{ auth()->user()->image != null ? asset('admin-lte/dist/img/avatar/'.auth()->user()->image) : asset('images/avatar.png') }}" height="100px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{Auth::user()->roles()->first()->display_name}}</h4>
                            <hr style="margin-left: 0;margin-top: 0;margin-bottom: 0;text-align: left;width: 60%;"/>
                    		    <p>
                              <span class="text-muted">Transaksi Per Tgl. {{$toDay}} - {{date("d-m-Y", strtotime($endedTimestamp))}}  : </span><br/>
                              <span class="label label-success">{{$countTransaksiSuccesBulan}} Transaksi</span>
                              <span class="label label-warning">{{$countTransaksiProsesBulan}} Transaksi</span>
                              <span class="label label-danger">{{$countTransaksiGagalBulan}} Transaksi</span>
                            </p>
                            <p>
                                <form id="form-membership">
                                    <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="from_level" value="{{Auth::user()->roles()->first()->id}}">
                                    <input class="form-control" type="hidden" id="id_level" name="to_level" value="4">
                                    <label>Lampirkan SIUP/TDP</label>
                                    <input class="form-control" type="file" id="siup-membership" name="siup_membership">
                                    <button class="btn custom__btn-greenHover btn-xs" id="upgrademembership" type="button">Upgrade Level</button>
                                </form>
                            </p>
                        </div>
                        <div class="well well-sm">
                          <center><b>Tgl Reset dan Penentuan Downgrade level membership {{date("d-m-Y", strtotime($endedTimestamp))}}.<br/>({{$selisihhari}} Hari Lagi)</b></center>
                          <hr style="height: 12px;border: 0;box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);"/>
                          Lever User anda saat ini adalah <b>{{Auth::user()->roles()->first()->display_name}}</b>.<br/>
                          Akumulasi Transaksi ({{$toDay}} - {{date("d-m-Y", strtotime($endedTimestamp))}}) :
                          <ol>
                            <li>{{$countTransaksiSuccesBulan}} Transaksi Success</li>
                            <li>{{$countTransaksiProsesBulan}} Transaksi Procces</li>
                            <li>{{$countTransaksiGagalBulan}} Transaksi Gagal</li>
                          </ol>
                          Target untuk level <b>{{Auth::user()->roles()->first()->display_name}}</b> :
                          <ol>
                            <li>Minamal 50 Transaksi Success Sebelum Tgl. {{date("d-m-Y", strtotime($endedTimestamp))}} .</li>
                            <li>Transaksi anda saat ini {{$countTransaksiSuccesBulan}} Transaksi Success .</li>
                            @if($countTransaksiSuccesBulan < '50')
                              <li>Lengkapi Transaksi anda minimal hingga {{50 - $countTransaksiSuccesBulan}} Transaksi success lagi sebelum tanggal reset .</li>
                            @endif
                          </ol>
                          @if($countTransaksiSuccesBulan >= '50')
                            <i class="text-muted">
                              <b><u class="text-success">* STATUS MEMBERSHIP SUDAH MEMENUHI TARGET.</u></b><p>
                              Tingkatkan transaksi anda, hingga minimal 50 transaksi sebelum tgl. {{date("d-m-Y", strtotime($endedTimestamp))}}, untuk mempertahankan level {{Auth::user()->roles()->first()->display_name}} anda. <br/>
                              Tepat pada tgl. {{date("d-m-Y", strtotime($endedTimestamp))}} akan dilakukan reset perhitungan, dan sistem akan mendowngrade otomatis level jika tidak memenuhi syarat dan ketentuan keanggotaan.
                            </i>
                          @else
                            <i class="text-muted">
                              <b><u class="text-danger">* STATUS MEMBERSHIP BELUM MEMENUHI TARGET</u>.</b><p>
                              Tingkatkan transaksi anda, hingga minimal 50 transaksi sebelum tgl. {{date("d-m-Y", strtotime($endedTimestamp))}}, untuk mempertahankan level {{Auth::user()->roles()->first()->display_name}} anda. <br/>
                              Tepat pada tgl. {{date("d-m-Y", strtotime($endedTimestamp))}} akan dilakukan reset perhitungan, dan sistem akan mendowngrade otomatis level jika tidak memenuhi syarat dan ketentuan keanggotaan.
                            </i>
                          @endif
                        </div>
                      @endif
                      @if(Auth::user()->roles()->first()->id == '4')
                        <div class="pull-left">
                            <img class="media-object" src="{{ auth()->user()->image != null ? asset('admin-lte/dist/img/avatar/'.auth()->user()->image) : asset('images/avatar.png') }}" height="100px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{Auth::user()->roles()->first()->display_name}}</h4>
                            <hr style="margin-left: 0;margin-top: 0;margin-bottom: 0;text-align: left;width: 60%;"/>
                    		    <p>
                              <span class="text-muted">Transaksi Per Tgl. {{$toDay}} - {{date("d-m-Y", strtotime($endedTimestamp))}}  : </span><br/>
                              <span class="label label-success">{{$countTransaksiSuccesBulan}} Transaksi</span>
                              <span class="label label-warning">{{$countTransaksiProsesBulan}} Transaksi</span>
                              <span class="label label-danger">{{$countTransaksiGagalBulan}} Transaksi</span>
                            </p>
                            <p>
                                <form id="form-membership">
                                    <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="from_level" value="{{Auth::user()->roles()->first()->id}}">
                                    <input class="form-control" type="hidden" id="id_level" name="to_level" value="4">
                                    <label>Lampirkan SIUP/TDP</label>
                                    <input class="form-control" type="file" id="siup-membership" name="siup_membership">
                                    <button class="btn custom__btn-greenHover btn-xs" id="upgrademembership" type="button">Upgrade Level</button>
                                </form>
                            </p>
                        </div>
                        <div class="well well-sm">
                          <center><b>Tgl Reset dan Penentuan Downgrade level membership {{date("d-m-Y", strtotime($endedTimestamp))}}.<br/>({{$selisihhari}} Hari Lagi)</b></center>
                          <hr style="height: 12px;border: 0;box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);"/>
                          Lever User anda saat ini adalah <b>{{Auth::user()->roles()->first()->display_name}}</b>.<br/>
                          Akumulasi Transaksi ({{$toDay}} - {{date("d-m-Y", strtotime($endedTimestamp))}}) :
                          <ol>
                            <li>{{$countTransaksiSuccesBulan}} Transaksi Success</li>
                            <li>{{$countTransaksiProsesBulan}} Transaksi Procces</li>
                            <li>{{$countTransaksiGagalBulan}} Transaksi Gagal</li>
                          </ol>
                          Target untuk level <b>{{Auth::user()->roles()->first()->display_name}}</b> :
                          <ol>
                            <li>Minamal 150 Transaksi Success Sebelum Tgl. {{date("d-m-Y", strtotime($endedTimestamp))}} .</li>
                            <li>Transaksi anda saat ini {{$countTransaksiSuccesBulan}} Transaksi Success .</li>
                            @if($countTransaksiSuccesBulan < '150')
                              <li>Lengkapi Transaksi anda minimal hingga {{150 - $countTransaksiSuccesBulan}} Transaksi success lagi sebelum tanggal reset .</li>
                            @endif
                          </ol>
                          @if($countTransaksiSuccesBulan >= '150')
                            <i class="text-muted">
                              <b><u class="text-success">* STATUS MEMBERSHIP SUDAH MEMENUHI TARGET.</u></b><p>
                              Tingkatkan transaksi anda, hingga minimal 150 transaksi sebelum tgl. {{date("d-m-Y", strtotime($endedTimestamp))}}, untuk mempertahankan level {{Auth::user()->roles()->first()->display_name}} anda. <br/>
                              Tepat pada tgl. {{date("d-m-Y", strtotime($endedTimestamp))}} akan dilakukan reset perhitungan, dan sistem akan mendowngrade otomatis level jika tidak memenuhi syarat dan ketentuan keanggotaan.
                            </i>
                          @else
                            <i class="text-muted">
                              <b><u class="text-danger">* STATUS MEMBERSHIP BELUM MEMENUHI TARGET</u>.</b><p>
                              Tingkatkan transaksi anda, hingga minimal 150 transaksi sebelum tgl. {{date("d-m-Y", strtotime($endedTimestamp))}}, untuk mempertahankan level {{Auth::user()->roles()->first()->display_name}} anda. <br/>
                              Tepat pada tgl. {{date("d-m-Y", strtotime($endedTimestamp))}} akan dilakukan reset perhitungan, dan sistem akan mendowngrade otomatis level jika tidak memenuhi syarat dan ketentuan keanggotaan.
                            </i>
                          @endif
                        </div>
                      @endif
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Syarat & Ketentuan</h3>
                </div>
                <div class="box-body">
                    <b>Personal:</b>
                    <ol>
                        <li>Dipakai Untuk Pribadi Atau Keluarga.</li>
                        <li>Minimal Deposit Rp. 20.000.</li>
                        <li>Tidak ada minimal transaksi bulanan.</li>
                        <li>Ada beberapa fitur yang dibatasi.</li>
                       @if($setting->max_daily_deposit_personal == 0)
                            <li>Tidak ada batas deposit perhari</li>
                        @else
                            <li>Maximal Deposit {{$setting->max_daily_deposit_personal}} x perhari</li>
                        @endif
                    </ol>
                    <b>Agen:</b>
                    <ol>
                        <li>Dipakai Untuk Bisnis.</li>
                        <li>Minimal Deposit Rp. 250.000.</li>
                        <li>Minimal 50 transaksi per bulan.</li>
                        <li>Banyak fitur yang bisa digunakan.</li>
                        @if($setting->max_daily_deposit_agen == 0)
                            <li>Tidak ada batas deposit perhari</li>
                        @else
                            <li>Maximal Deposit {{$setting->max_daily_deposit_agen}} x perhari</li>
                        @endif
                        
                    </ol>
                    <b>Enterprise:</b>
                    <ol>
                        <li>Dipakai Untuk Bisnis H2H.</li>
                        <li>Minimal Deposit Rp. 500.000.</li>
                        <li>Minimal 150 transaksi per bulan.</li>
                        <li>Banyak fitur yang bisa digunakan.</li>
                        @if($setting->max_daily_deposit_enterprise == 0)
                            <li>Tidak ada batas deposit perhari</li>
                        @else
                            <li>Maximal Deposit {{$setting->max_daily_deposit_enterprise}} x perhari</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
@section('js')
<script>

$.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });

function readFile(input){
    var img;
    console.log(input);
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            img = e.target.result;
        }
        
        return img;
    }
}
$('#upgrademembership').on('click', function(ev){
  // toastr.error("Mohon maaf sedang melakukan penyempurnaan!");
  // return false;
  $('#upgrademembership').html("<i class='fa fa-spinner faa-spin animated fa-fw'></i> Send request upgrade...");
  $('#bupgrademembership').attr('style', 'cursor:not-allowed;pointer-events: none;');
  

  
//   console.log(img);

  $.blockUI({ css: {
       border: 'none',
       padding: '15px',
       backgroundColor: '#000',
       '-webkit-border-radius': '10px',
       '-moz-border-radius': '10px',
       opacity: .5,
       color: '#fff'
   } })

    Pace.track(function(){
        $.ajax({
            url: '{{route('membership.upgrade.level')}}',
            dataType: "json",
            type: "POST",
            data: new FormData($('#form-membership')[0]),
            contentType :false,
            cache:false,
            processData:false,
            success: function (response) {
              $('#upgrademembership').html("Upgrade Level");
              $('#upgrademembership').removeAttr('style');
              $.unblockUI();
                if ((response.success == false)) {
                  $.unblockUI();
                    toastr.error(response.message);
                }else if((response.success == true)){
                  $.unblockUI();
                    toastr.success(response.message);
                    window.location.href = "{{url('/member/membership')}}";
                }else{
                  $.unblockUI();
                    toastr.error("Request error, silahkan ulangi!.");
                }
            },error:function(e){
                $('#upgrademembership').html("Upgrade Level");
                $('#upgrademembership').removeAttr('style');
                $.unblockUI();
                toastr.error(e.responseJSON.message);
            }
        });
  });
});
</script>
@endsection
