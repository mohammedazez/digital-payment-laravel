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
<style>
table.grid {
    width:100%;
    /* border:1px solid #10d6e0; */
    border:none;
      border-spacing: 1px;
    border-collapse: separate;
    /* background-color:#10d6e0; */
    background-color:white;
    padding:0px;
}


table.grid a
{
    display:block;
    text-decoration:none;
}

table.grid tr {
    text-align:center;
}
table.grid td {
    border:1px solid #ECF0F5;
    padding:6px;
}

table.grid td:hover {
    border:1px solid #3c8dbc;
}

.icon__width {
    width: 35px;
    height: auto;
}

.height-info{
  height: 920px;
}

@media screen and (max-width: 780px) {
    .title-beli{
        font-size:11px;
    }
    .height-info{
        height: 500px;
    }
}
</style>
<section class="content-header hidden-xs">
<h1>Home <small>Dashboard</small></h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Dashboard</li>
</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-6">
            @if($countTagihan > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="callout callout-warning">
                        <div class="row">
                            <div class="col-md-12">
                              <!--<h4>Info !</h4>-->
                              <b>Halo sobat... <br/>Anda mempunyai {{$countTagihan}} Tagihan pembayaran yang belom anda selesaikan!</b><br/>
                              @php $no=0; @endphp
                              @foreach($tagihanNonBuy as $tgh)
                              @php $no++; @endphp
                                  @if($no == '4')
                                    <br/>
                                    <br/>
                                    <a href="{{url('/member/tagihan-pembayaran')}}"><b>SELENGKAPNYA >>></b></a>
                                  @else
                                    <br/>
                                        {{$no}}.&nbsp;
                                         ID: {{isset($tgh['id'])?$tgh['id'] : '-'}}&nbsp;
                                        {{isset($tgh['product_name'])?$tgh['product_name'] : '-'}}&nbsp;
                                        {{isset($tgh['no_pelanggan'])?$tgh['no_pelanggan'] : '-'}}&nbsp;
                                        {{isset($tgh['nama'])?$tgh['nama'] : '-'}}&nbsp;
                                        {{isset($tgh['periode'])?$tgh['periode'] : '-'}}&nbsp;
                                        <a href="{{url('/member/tagihan-pembayaran/'.$tgh['id'].'')}}"><b>KLIK .</b></a>
                                  @endif
                               @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
		    @if($GeneralSettings->status == 0 || $GeneralSettings->status_server == 0)
		    <div class="box box-widget" style="margin-bottom: 10px;background-color: #FDFDFD;text-align:center;">
		        <h6 style="padding:10px;margin-top:0px;font-style:italic;">Sistem {{$GeneralSettings->nama_sistem}} sedang melakukan MAINTENANCE, untuk itu kami mohon untuk tidak melakukan transaksi terlebih dahulu. Trimakasih</h6>
		    </div>
		    @endif
		    
            <div class="box box-widget" style="margin-bottom: 10px;background-color: #FDFDFD">
                <div class="box-body">
                    <h4 style="margin-bottom: 0px;margin-top: 0px;" class="pull-left text-primary"><span class="icon-wallet" style="margin-right: 6px;"></span> Rp {{number_format(Auth::user()->saldo, 0, '.', '.')}}</h4>
                    <a href="{{url('/member/deposit')}}" class="btn-loading label label-primary pull-right" style="font-size: 13px;padding-bottom: 5px;padding-top: 5px;"><i class="fa fa-plus-circle" style="margin-right: 3px;"></i> Isi Saldo</a>
                </div>
            </div>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                     <?php $no = 0; ?>
                     @foreach($getimages as $img)
                      <?php $no++ ?>
                        <li data-target="#carousel-example-generic" data-slide-to="{{$no}}" {{ $no == 1?'class="active"':''}}></li>
                    @endforeach
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                 <?php $no=0; ?>
                 @foreach($getimages as $img)
                   <?php $no++ ?>
                    <div class="item {{$no== 1?'active':''}}"><img src="{{ asset($img->img_path)}}"></div>
                 @endforeach
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="grid" cellspacing="0">
                            @php $chunk = array_chunk($kategori_merge,3); @endphp
                            @foreach($chunk as $row)
                            <tr>
                             @if(count($row) == 3)
                                  @foreach($row as $data)
                                      @if($data['jenis'] == 'pembelian')
                                          <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member/beli', $data['slug'])}}'">
                                              <a href="{{url('/member/beli', $data['slug'])}}" class="btn-loading">
                                                  <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                                  <small class="title-beli">{{$data['product_name']}}</small>
                                              </a>
                                          </td>
                                      @elseif($data['jenis'] == 'pembelianmanual')
                                          <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member/pembelian', $data['slug'])}}'">
                                              <a href="{{url('/member/pembelian', $data['slug'])}}" class="btn-loading">
                                                <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                                  <small class="title-beli">{{$data['product_name']}}</small>
                                              </a>
                                          </td>
                                      @elseif($data['jenis'] == 'pembayaran')
                                          <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member/bayar', $data['slug'])}}'">
                                              <a href="{{url('/member/bayar', $data['slug'])}}" class="btn-loading">
                                                <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                                  <small class="title-beli">{{$data['product_name']}}</small>
                                              </a>
                                          </td>
                                      @elseif($data['jenis'] == 'manual')
                                          <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member', $data['slug'])}}'">
                                              <a href="{{url('/member', $data['slug'])}}" class="btn-loading">
                                                <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                                  <small class="title-beli">{{$data['product_name']}}</small>
                                              </a>
                                          </td>
                                      @elseif( $data['jenis'] == 'other' )
                                        <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member', $data['slug'])}}'">
                                              <a href="{{url('/member', $data['slug'])}}" class="btn-loading">
                                                    <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                                  <small class="title-beli">{{$data['product_name']}}</small>
                                              </a>
                                          </td>
                                      @endif
                                  @endforeach
                              @else
                                @foreach($row as $data)
                                  @if($data['jenis'] == 'pembelian')
                                      <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member/beli', $data['slug'])}}'">
                                          <a href="{{url('/member/beli', $data['slug'])}}" class="btn-loading">
                                            <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                              <small class="title-beli">{{$data['product_name']}}</small>
                                          </a>
                                      </td>
                                  @elseif($data['jenis'] == 'pembelianmanual')
                                      <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member/pembelian', $data['slug'])}}'">
                                          <a href="{{url('/member/pembelian', $data['slug'])}}" class="btn-loading">
                                                <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                              <small class="title-beli">{{$data['product_name']}}</small>
                                          </a>
                                      </td>
                                  @elseif($data['jenis'] == 'pembayaran')
                                      <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member/bayar', $data['slug'])}}'">
                                          <a href="{{url('/member/bayar', $data['slug'])}}" class="btn-loading">
                                            <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                              <small class="title-beli">{{$data['product_name']}}</small>
                                          </a>
                                      </td>
                                  @elseif($data['jenis'] == 'manual')
                                      <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member', $data['slug'])}}'">
                                          <a href="{{url('/member', $data['slug'])}}" class="btn-loading">
                                            <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                              <small class="title-beli">{{$data['product_name']}}</small>
                                          </a>
                                      </td>
                                  @elseif( $data['jenis'] == 'other' )
                                    <td style="width:33.3%;height:70px;cursor:pointer;" onclick="location.href='{{url('/member', $data['slug'])}}'">
                                          <a href="{{url('/member', $data['slug'])}}" class="btn-loading">
                                             <i class="fa fa-{{$data['icon']}} fa-2x"></i><br>
                                              <small class="title-beli">{{$data['product_name']}}</small>
                                          </a>
                                      </td>
                                  @endif
                                @endforeach
                              @endif
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 hidden-xs hidden-sm">
            <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label"><span class="bg-blue" style="padding-right: 20px;padding-left: 20px;">Pusat Informasi</span></li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                @if($info->count() > 0)
                @foreach($info as $data)
                <li>
                    @if($data->type == 'INFO')
                    <i class="fa fa-info bg-blue"></i>
                    @elseif($data->type == 'PROMO')
                    <i class="fa fa-tags bg-blue"></i>
                    @elseif($data->type == 'MAINTENANCE')
                    <i class="fa fa-wrench bg-blue"></i>
                    @endif
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{date("d M Y H:m:s", strtotime($data->created_at))}}</span>
                        <h3 class="timeline-header"><a href="#">[{{$data->type}}]</a> {{$data->title}}</h3>
                        <div class="timeline-body">{!! $data->isi_informasi !!}</div>
                    </div>
                </li>
                @endforeach
                @else
                <li>
                    <i class="fa fa-exclamation-circle bg-blue"></i>
                    <div class="timeline-item">
                        <div class="timeline-body" style="padding-top: 5px;padding-bottom: 5px;text-align:center;">
                            <h4 style="font-style:italic;">Informasi belum tersedia</h4>
                        </div>
                    </div>
                </li>
                @endif
                
                <li>
                  <i class="fa fa-clock-o bg-gray"></i>
                </li>
              </ul>
        </div>
    </div>
</section>

<!-- Tab Mobile --> 
<!-- <nav class="box__tab">
    <ul class="nav " role="tablist" id="box__tab">
        <li class="nav-item" href="{{url('/member')}}" onclick="window.location.href=`{{ url('/member/') }}`">
            <a class="nav-item nav-link active" data-toggle="pill" href="#" role="tab" aria-selected="true">
                <i class="icofont icofont-ui-home"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item" href="{{ url('/member/deposit/') }}" onclick="window.location.href=`{{ url('/member/deposit/') }}`">
            <a class="nav-item nav-link" data-toggle="pill" href="{{ url('/member/deposit') }}" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                <i class="icofont icofont-plus-circle"></i> <br>
                <span>Saldo</span>
            </a>
        </li>
        <li class="nav-item" onclick="window.location.href=`{{ url('/member/riwayat-transaksi/') }}`">
            <a class="nav-item nav-link" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                <i class="icofont icofont-shopping-cart"></i>
                <span>Pesanan</span>
            </a>
        </li>
        <li class="nav-item" onclick="window.location.href=`{{ url('/member/tagihan-pembayaran') }}`">
            <a class="nav-item nav-link" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                <i class="icofont icofont-notification"></i>
                <span>Notifikasi</span>
            </a>
        </li>
        <li class="nav-item" target="_blank" onclick="window.open('https://wa.me/628197456456?text=Hallo,%20saya%20ingin%20menanyakan%20layanan%20Agen%20Pembayaran%20Online')">
            <a class="nav-item nav-link" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                <i class="icofont icofont-social-whatsapp"></i>
                <span>Chat CS</span>
            </a>
        </li>
    </ul>
</nav> -->
<!-- Penutup Tab Mobile --> 

@endsection
@section('js')
@if(count($getimages) > 0)
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
<script>
    $(".carousel").swipe({

  swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

    if (direction == 'left') $(this).carousel('next');
    if (direction == 'right') $(this).carousel('prev');

  },
  allowPageScroll:"vertical"

});
</script>
@endif
@endsection