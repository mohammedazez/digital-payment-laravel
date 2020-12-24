@extends('layouts.app')
@section('title', 'Harga Produk | '.$GeneralSettings->nama_sistem)
@section('description', 'Harga Produk Termurah & Terlengkap '.$GeneralSettings->nama_sistem.'. '.$GeneralSettings->description)
@section('keywords', 'Distributor, Distributor Pulsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa, Cara Transaksi, Jalur Transaksi, API, H2H', 'Website')
@section('img', asset('assets/images/background/img-home.png'))

@section('content')
<!-- Start Slideshow Section -->
<section id="slideshow">
    <div class="container">
        <div class="row">
            <div class="no-slider" style="margin-top: 100px;">
                <div class="animate-block" style="text-align: center;">
                    <div class="col-md-6 col-md-offset-3">
                        <h2><span id="word-rotating">Pulsa All Operator, Paket Internet, Voucher Game, Token PLN, Pembayaran PPOB</span></h2>
                        <p style="margin-top: 10px;margin-bottom: 80px;">Produk Terlengkap & Termurah Kami</p>
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
        <div class="col-md-12" style="margin-bottom: 30px;">
            <div class="section-heading text-center" style="margin-bottom: 30px;">
                <h2 class="title">Harga Token Listrik</h2>
                <p>Harga Produk Terbaik Kami<br>Update {{date("d-m-Y")}}</p>
            </div>
        </div>
        <!-- Nav tabs -->
        <div class="col-md-12" style="margin-bottom:50px;">
            @if($jml > 0)
            <h3 style="font-size: 20px;">VOUCHER PLN PRABAYAR</h3>
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                <thead>
                    <tr>
                        <th>Operator</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr> 
                </thead>
                <tbody align="left">
                    @for($i=0; $i<$jml; $i++)
                    <tr>
                         <td>{{$produk->message[$i]->operator}}</td>
                         <td>{{$produk->message[$i]->description}}</td>
                         <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                         @if($produk->message[$i]->status == 'normal')
                         <td><p class="text-success">TERSEDIA</p></td>
                         @else
                         <td><p class="text-danger">GANGGUAN</p></td>
                         @endif
                    </tr> 
                    @endfor
                </tbody>
            </table>
            @else
            <tr>
                <td colspan="3" align="center" style="font-style: italic;">Produk Belum Tersedia</td>
            </tr>
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