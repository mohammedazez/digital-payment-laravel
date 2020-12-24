@extends('layouts.app')
@section('title', 'Testimonial | '.$GeneralSettings->nama_sistem)
@section('description', 'Testimonial Agen, Mitra & Pembeli tetang '.$GeneralSettings->nama_sistem.'. '.$GeneralSettings->description)
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
               <h1><span id="word-rotating">Testimonial</span></h1>
               <p style="margin-top: 10px;margin-bottom: 80px;font-size: 15px;">Pendapat mereka yang sudah mencoba bertransaksi di {{$GeneralSettings->nama_sistem}}</p>
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
         @if($testimonials->count() > 0)
         <ul class="review-timeline">
            <?php $no=1; ?>
            @foreach($testimonials as $data)
            @if($no%2==1)
            <li>
            @else
            <li class="review-timeline-inverted">
            @endif
               <div class="review-timeline-thumb">
                  @if($data->user->image != null)
                  <img class="img-circle img-responsive" src="{{asset('admin-lte/dist/img/avatar/'.$data->user->image)}}" alt="client-1">
                  @else
                  <img class="img-circle img-responsive" src="{{asset('admin-lte/dist/img/avatar5.png')}}" alt="client-1">
                  @endif
               </div>
               <div class="review-timeline-panel">
                  <div class="review-timeline-body">
                     <p style="font-style: italic;">"{{$data->review}}"</p>
                     <ul class="reviewer">
                        <li><h4 style="text-transform: capitalize;">{{$data->user->name}} / {{$data->user->city}}</h4></li>
                        <li>
                           <div class="stars"> Rated : 
                                <?php
                                    for($i=1;$i<=$data->rate;$i++){
                                ?>
                                        <i class="fa fa-star"></i>
                                <?php
                                    }
                                ?>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </li>
            <?php $no++ ?> 
            @endforeach

            <li class="clearfix" style="float: none;"></li>
         </ul>
         @else
         <div align="center">
            <i class="fa fa-frown-o fa-5x"></i>
            <h3>Belum ada testimoni</h3>
            <small>Jadilah yang pertama memberikan testimoni pada kami</small>
         </div>
         @endif
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