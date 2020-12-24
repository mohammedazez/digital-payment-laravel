@extends('layouts.app')
@section('title', 'Harga Produk | '.$GeneralSettings->nama_sistem)
@section('description', 'Harga Produk Termurah & Terlengkap '.$GeneralSettings->nama_sistem.'. '.$GeneralSettings->description)
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
                        <h2><span id="word-rotating">{{$kategoris->product_name}}</span></h2>
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
                <h2 class="title">Harga {{$kategoris->product_name}}</h2>
                <p>Harga Produk Terbaik Kami<br>Update {{date("d-m-Y")}}</p>
            </div>
        </div>
        <!-- Nav tabs -->
        <div class="col-md-12" style="margin-bottom:50px;">
            @foreach($kategoris->pembayaranoperator as $operator)
            <h3 style="font-size: 20px;">{{$operator->product_name}}</h3>
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kode</th>
                        <th class="text-right">Biaya Admin</th>
                        <th class="text-center">Status</th>
                    </tr> 
                </thead>
                <tbody align="left">
                    @if(count($operator->pembayaranproduk) > 0)
                    @foreach($operator->pembayaranproduk as $produk)
                    <tr>
                        <td>{{$produk->product_name}}</td>
                        <td>{{$produk->code}}</td>
                        <td class="text-right">Rp {{number_format($produk->price_markup, 0, '.', '.')}}</td>
                        @if($produk->status == 1)
                        <td class="text-center"><span class="label label-success">TERSEDIA</span></td>
                        @else
                        <td class="text-center"><span class="label label-danger">GANGGUAN</span></td>
                        @endif
                    </tr> 
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3" align="center" style="font-style: italic;">Produk Belum Tersedia</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @endforeach
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