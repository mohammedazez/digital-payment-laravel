@extends('layouts.app')
@section('title', 'FAQ | '.$GeneralSettings->nama_sistem.' - '.$GeneralSettings->motto)
@section('description', 'FAQ kumpulan pertanyaan yang sering di tanyakan pada '.$GeneralSettings->nama_sistem.'. '.$GeneralSettings->description)
@section('keywords', 'Distributor, Distributor Pulsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa, Cara Transaksi, Jalur Transaksi, API, H2H', 'Website')
@section('img', asset('assets/images/banner_1.png'))

@section('content')
<!-- Start Slideshow Section -->
<section id="slideshow">
   <div class="container">
      <div class="row">
         <div class="no-slider" style="margin-top: 100px;">
            <div class="animate-block" style="text-align: center;">
            <div class="col-md-6 col-md-offset-3">
               <h1><span id="word-rotating">FAQ</span></h1>
               <p style="margin-top: 10px;margin-bottom: 80px;">Hal yang sering ditanyakan</p>
              </div>
            </div> <!--/ animate-block -->
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</section>
<!-- End Slideshow Section -->

<!-- Start FAQ Section -->
<section id="faq" class="grey-bg padding-2x">
   <div class="container">
      <div class="row">
         @if($faqs->count() > 0)
         @foreach(array_chunk($faqs->all(), 3) as $col)
         <div class="col-sm-6">
            <!-- Start FAQ Block -->
            <div id="accordion" class="faq-block">
            @foreach($col as $data)
            
            
               <div class="panel accordion-panel">
                  <h4 class="faq-heading">
                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{str_slug($data->pertanyaan, '-')}}" aria-expanded="false">Q : {{$data->pertanyaan}}</a>
                  </h4>
                  <div id="{{str_slug($data->pertanyaan, '-')}}" class="accordion-body collapse">
                     <p>{{$data->jawaban}}</p>
                  </div>
               </div>
            
            @endforeach
            </div>
            <!-- End FAQ Block -->
         </div>
         @endforeach
         @else
         <div align="center">
            <i class="fa fa-frown-o fa-5x"></i>
            <h3>Belum ada FAQ</h3>
            <small>Jadilah yang pertama memberikan pertanyaan seputar sistem kami</small>
         </div>
         @endif
      </div>
   </div>
</section>
<!-- End FAQ Section -->

{{-- <section id="twitter-feed" class="grey-bg padding-1x">
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="section-heading text-center">
               <h2 class="title">{{$GeneralSettings->motto}}</h2>
            </div>
         </div>
      </div>
   </div>
</section> --}}
@endsection