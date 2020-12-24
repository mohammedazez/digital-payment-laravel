@extends('layouts.app')
@section('title', '403 Forbidden | '.$GeneralSettings->nama_sistem.' - '.$GeneralSettings->motto)
@section('description', 'Perkenalan singkat mengenai kami '.$GeneralSettings->nama_sistem.'. '.$GeneralSettings->description)
@section('keywords', 'Distributor, Distributor Puslsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa, Cara Transaksi, Jalur Transaksi, API, H2H', 'Website')
@section('img', asset('assets/images/background/img-home.png'))

@section('content')
<!-- Start Slideshow Section -->
<section id="slideshow">
   <div class="container">
      <div class="row">
         <div class="no-slider" style="margin-top: 100px;">
            <div class="animate-block" style="text-align: center;">
            <div class="col-md-6 col-md-offset-3">
               <h2><span id="word-rotating">403 Forbidden</span></h2>
               <p style="margin-top: 10px;margin-bottom: 80px;">Halaman tidak dapat diakses.</p>
              </div>
            </div> <!--/ animate-block -->
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</section>
<!-- End Slideshow Section -->

<!-- Start Feature Section -->
<section id="feature" class="padding-2x">
   <div class="container">
      <div class="row">
            <div align="center">
                <span style="font-size:150px;">403</span><br>
                <h2 style="font-weght:bold;">Halaman Tidak Dapat Diakses</h2>
                <p style="margin-bottom:10px;">Tautan yang anda ikuti tidak dapat anda akses.</p>
                <a href="{{url('/')}}" class="btn btn-primary"><i class="fa fa-home" style="margin-right:5px;"></i>Kembali Ke Halaman Home</a>
            </div>
        
      </div>
   </div>
</section>
<!-- End Feature Section -->
<section id="twitter-feed" class="grey-bg padding-1x">
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="section-heading text-center">
               <h2 class="title" style="font-style: italic;">"{{$GeneralSettings->motto}}"</h2>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection