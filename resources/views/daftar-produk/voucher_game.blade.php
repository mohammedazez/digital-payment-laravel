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


            @if($jml > 0)
            <h4 style="font-size: 20px;">Xbox Live Gift Card</h4>
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Xbox Live Gift Card')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Game facebook - Boyaa Poker</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Game facebook - Boyaa Poker')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif


            <h4 style="font-size: 20px;">BSF</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'BSF')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Cabal Online</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Cabal Online')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">e-PINS</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'e-PINS')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Digicash</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Digicash')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">Faveo</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Faveo')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">FBCARD</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'FBCARD')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">Fastblack</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Fastblack')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">ASIASOFT</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'ASIASOFT')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">DASA GAME</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'DASA GAME')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">GOLONLINE</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'GOLONLINE')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">GOGAME</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'GOGAME')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">IAH Games</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'IAH Games')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">INGAME</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'INGAME')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">GOOGLE PLAY</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'GOOGLE PLAY')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">MatchMove</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'MatchMove')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Gemscool</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Gemscool')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">OrangeGame</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'OrangeGame')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Playon</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Playon')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">Qash</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Qash')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">GARENA</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'GARENA')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">RappelzOnline</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'RappelzOnline')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">ROSE ONLINE</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'ROSE ONLINE')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">TERACORD</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'TERACORD')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Gamewave</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Gamewave')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">Gameweb</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Gameweb')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Playstation Store Prepaid Card</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Playstation Store Prepaid Card')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">iTunes Gift Card</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'iTunes Gift Card')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Game facebook - Joombi</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Game facebook - Joombi')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">Koram</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Koram')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">kiwi card</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'kiwi card')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
            <h4 style="font-size: 20px;">LYTO</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'LYTO')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif



            <h4 style="font-size: 20px;">Mainkan.com</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Mainkan.com')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Mobius</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Mobius')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">MOGCAZ</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'MOGCAZ')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Megaxus</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Megaxus')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">MOGPLAY</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'MOGPLAY')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">MOLPoints</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'MOLPoints')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Metin 2</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Metin 2')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">MyCard</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'MyCard')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">ORANGE TV</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'ORANGE TV')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Playcircle</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Playcircle')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Playpoint</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Playpoint')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Game facebook - Pool Live Tour</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Game facebook - Pool Live Tour')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Game facebook - Pico World</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Game facebook - Pico World')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Game facebook - Joombi</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Game facebook - Joombi')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Game facebook - Boyaa Poker</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Game facebook - Boyaa Poker')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Playnexia</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Playnexia')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Softnyx</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Softnyx')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Spin</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Spin')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Serenity</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Serenity')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">STEAM</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'STEAM')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Travian</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Travian')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   
   

            <h4 style="font-size: 20px;">PLAYSPAN</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'PLAYSPAN')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">VTC Online</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'VTC Online')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Viwawa</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Viwawa')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Winner Card</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Winner Card')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">Wavegame</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'Wavegame')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif

   

            <h4 style="font-size: 20px;">ZYNGA</h4>
            @if($jml > 0)
            
                 <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr>
                      <th>Operator</th>
                      <th>Produk</th>
                      <th>Jenis</th>
                      <th>Harga</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no=1; ?>
                      @for($i=0; $i<$jml; $i++)
                        @if ($produk->message[$i]->provider_sub == 'ZYNGA')
                          <tr>
                             <td>{{$produk->message[$i]->operator}}</td>
                             <td>{{$produk->message[$i]->description}}</td>
                             <td>{{$produk->message[$i]->provider_sub}}</td>
                             <td>Rp {{number_format($produk->message[$i]->price, 0, '.', '.')}}</td>
                             @if($produk->message[$i]->status == 'normal')
                             <td><p class="text-success">TERSEDIA</p></td>
                             @else
                             <td><p class="text-danger">GANGGUAN</p></td>
                             @endif
                          </tr>
                          @endif
                      @endfor
                    </tbody>
                 </table>
            @else
            <div style="text-align:center;">
                <i class="fa fa-frown-o fa-5x"></i>
                <h4 style="font-weight:bold;padding-bottom:50px;font-style:italic;">Operator & Produk dari Kategori ini belum tersedia</h4>
            </div>
            @endif
    </div>

</section>
@endsection
@section('js')
<script>
      // $(function () {
   //    $('#table-operator').DataTable({
   //      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
   //      "iDisplayLength": 50,
   //      "searching": true,
   //      "lengthChange": false,
   //      "info": false
   //    });
   // });
</script>

@endsection