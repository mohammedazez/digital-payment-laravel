@extends('layouts.app')
@section('title', 'Deposit Saldo | '.$GeneralSettings->nama_sistem)
@section('description', 'Cara Deposit Saldo di '.$GeneralSettings->nama_sistem.'. '.$GeneralSettings->description)
@section('keywords', 'Distributor, Distributor Puslsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa, Cara Transaksi, Jalur Transaksi, API, H2H', 'Website')
@section('img', asset('assets/images/banner_1.png'))

@section('content')
<!-- Start Slideshow Section -->
<section id="slideshow">
   <div class="container">
      <div class="row">
         <div class="no-slider" style="margin-top: 100px;">
            <div class="animate-block" style="text-align: center;">
            <div class="col-md-6 col-md-offset-3">
               <h2><span id="word-rotating">Deposit Saldo</span></h2>
               <p style="margin-top: 10px;margin-bottom: 80px;">Cara Deposit Saldo Agen Pulsa Murah.</p>
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
         <div class="col-md-offset-1 col-md-10" style="margin-bottom: 30px;">
            <div class="section-heading text-center" style="margin-bottom: 30px;">
               <h2 class="title">Cara Deposit Saldo</h2>
               <p>Setelah Mendaftar menjadi agen pulsa kami, langkah selanjutnya adalah deposit pulsa / menambah saldo agar dapat digunakan untuk transaksi semua produk terlengkap dari {{$GeneralSettings->nama_sistem}}.</p>
            </div>
         </div>
         
         <div class="col-sm-12 col-md-12" style="margin-bottom:50px;">
            <center><h3 style="font-size:20px;font-weight:bold;">Cara Deposit Saldo Member/Agen via Bank Transfer</h3></center>
         </div>
         
         <div class="col-sm-4 col-md-4">
            <!-- Start User Friendly Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span aria-hidden="true" class="fa fa-pencil-square-o fa-3x custom__text-green"></span>
               </div>
               <h3>Request Deposit</h3>
               <p>Langkah pertama, lakukan request deposit pada halaman member dengan memilih menu DEPOSIT SALDO lalu memilih bank serta nominal deposit yang diinginkan dan sistem akan menampilkan detail deposit anda, berupa Nominal Transfer & Bank tujuan.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start User Friendly Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span aria-hidden="true" class="fa fa-paper-plane fa-3x custom__text-green"></span>
               </div>
               <h3>Transfer Pembayaran</h3>
               <p>Langkah kedua, anda akan di minta untuk melakukan transfer sejumlah nominal transfer yang tertera pada detail deposit, nominal transfer memiliki 3 angka unik di belakang sehingga disarankan untuk transfer pembayaran sesuai nominal transfer yang tertera.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start User Friendly Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span aria-hidden="true" class="fa fa-check-square-o fa-3x custom__text-green"></span>
               </div>
               <h3>Konfirmasi Pembayaran</h3>
               <p>Langkah terakhir, konfirmasi pembayaran anda dengan cara menghubungi CS kami untuk segera diproses, Saldo anda akan bertambah setelah kami memverifikasi pembayaran anda. Disarankan untuk melakukan Deposit Saldo pada jam kerja {{$GeneralSettings->nama_sistem}}.</p>
            </div>
            <!-- End Block -->
         </div>
      </div>
   </div>
</section>
<!-- End Feature Section -->

<section id="feature" class="grey-bg padding-2x">
    <div class="container">
        <div class="row">
         <div class="col-md-12" style="margin-bottom: 30px;">
            <div class="section-heading text-center" style="margin-bottom: 30px;">
               <h2 class="title">Rekening Resmi</h2>
               <p>{{$GeneralSettings->nama_sistem}} memiliki rekening resmi untuk bertransaksi.</p>
            </div>
         </div>
         @foreach($banks as $data)
         <div class="col-sm-6 col-md-6">
            <!-- Start User Friendly Block -->
            <div class="box-content text-center">
                <img src="{{asset('/img/banks/'.$data->image)}}" height="50px">
                <h3>{{$data->nama_bank}}</h3>
                <p>
                    Atas Nama : {{$data->atas_nama}}<br>
                    No. REkening : {{$data->no_rek}}<br>
                </p>
            </div>
            <!-- End Block -->
         </div>
         @endforeach
         <div class="col-md-offset-1 col-sm-10 col-md-10" style="margin-top:20px;text-align:center">
             <h3>Jadwal Offline Bank</h3>
             <p>Deposit pulsa murah dapat dilakukan selama 24 jam selama bank tidak maintenance. Namun layanan internet banking dari Bank BCA, BNI, Mandiri, BRI, dan Muamalat pada jam-jam tertentu pasti Offline / Maintenance setiap harinya. Tidak ada jadwal yang resmi dari bank kapan akan melakukan maintenance, Namun rata-rata Bank Offline antara jam 21:00 - 00:00 WIB. Sehingga transfer deposit yang dilakukan pada saat bank offline akan diproses setelah bank kembali normal.</p>
         </div>
      </div>
    </div>
</section>

<!-- Start Screenshot Section -->
  <!--<section id="screenshots" class="padding-2x">-->
  <!--  <div class="container">-->
  <!--  <div class="row">-->
  <!--    <div class="col-md-6 col-md-offset-3">-->
  <!--        <div class="section-heading text-center">-->
  <!--      <h2 class="title">App {{$GeneralSettings->nama_sistem}}</h2>-->
  <!--    <p>{{$GeneralSettings->nama_sistem}} menerapkan fitur WebApps pada sistemnya sehingga website {{$GeneralSettings->nama_sistem}} dapat di jadikan seperti sejenis aplikasi android di smartphone anda.</p>-->
  <!--        </div>-->
  <!--      </div>-->
  <!--  </div>-->
  <!--  <div class="row">-->
  <!--    <div id="slide-screen" class="owl-carousel">-->
  <!--    <div><img class="img-rounded" src="{{ asset('assets/images/slider/1.png')}}" alt="screenshot1"></div>-->
  <!--    <div><img class="img-rounded" src="{{ asset('assets/images/slider/2.png')}}" alt="screenshot2"></div>-->
  <!--    <div><img class="img-rounded" src="{{ asset('assets/images/slider/3.png')}}" alt="screenshot3"></div>-->
  <!--    <div><img class="img-rounded" src="{{ asset('assets/images/slider/4.png')}}" alt="screenshot4"></div>-->
  <!--    <div><img class="img-rounded" src="{{ asset('assets/images/slider/5.png')}}" alt="screenshot5"></div>-->
  <!--    <div><img class="img-rounded" src="{{ asset('assets/images/slider/6.png')}}" alt="screenshot6"></div>-->
  <!--  </div>-->
  <!--  </div>-->
  <!--</div>-->
  <!--</section>-->
  <!-- End Screenshot Section -->  

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