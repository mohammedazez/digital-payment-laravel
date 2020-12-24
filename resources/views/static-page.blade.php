@extends('layouts.app')
@section('title', $page->title.' | '.$GeneralSettings->nama_sistem)
@section('description', 'Terms of Service Agreement. '.$GeneralSettings->description)
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
               <h2><span id="word-rotating">{{ $page->title }}</span></h2>
               <p style="margin-top: 10px;margin-bottom: 80px;">Pemutakhiran terakhir {{ $page->updated_at->format('d-m-Y H:i:s') }}</p>
              </div>
            </div> <!--/ animate-block -->
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</section>
<!-- End Slideshow Section -->
    
<section id="feature" class="padding-2x">
    <div class="container">
        <div class="col-md-12" style="border: 1px solid #E6E6E6;border-radius: 10px;padding: 15px; margin: 10px auto;">
            <p>
                @php
                    $content = html_entity_decode($page->content, ENT_QUOTES);
                    $content = str_replace('[site_name]', $GeneralSettings->nama_sistem, $content);
                    $content = str_replace('[site_url]', url('/'), $content);
                    $content = str_replace('[site_motto]', $GeneralSettings->motto, $content);
                @endphp
                {!! $content  !!}
            </p>
        </div>
    </div>
</section>
<!-- Start Feature Section -->
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
