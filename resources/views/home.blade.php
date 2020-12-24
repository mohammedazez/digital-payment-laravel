@extends('layouts.app')
@section('title', $GeneralSettings->nama_sistem. ' | '.$GeneralSettings->motto)
@section('description', $GeneralSettings->description)
@section('keywords', 'Distributor, Distributor Pulsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa')
@section('img', asset('assets/images/slider/slider_ke2.png'))
@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('/assets/TabStylesInspiration/css/normalize.css')}}" />
    <!--<link rel="stylesheet" type="text/css" href="{{asset('/assets/TabStylesInspiration/css/demo.css')}}" />-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/TabStylesInspiration/css/tabs.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/TabStylesInspiration/css/tabstyles.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        
    <style>
        .fonticon::before {
            z-index: 10;
            display: inline-block;
            margin: 0 0.4em 0 0;
            vertical-align: middle;
            text-transform: none;
            font-weight: normal;
            font-variant: normal;
            font-size: 1.3em;
            font-family: 'stroke7pixeden';
            line-height: 1;
            speak: none;
            -webkit-backface-visibility: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .element {
            position: relative;
        }

        /*replace the content value with the
        corresponding value from the list below*/

        .element:before {
            z-index: 10;
            display: inline-block;
            margin: 0 0.4em 0 0;
            vertical-align: middle;
            text-transform: none;
            font-weight: normal;
            font-variant: normal;
            font-size: 1.3em;
            font-family: FontAwesome;
            line-height: 1;
            speak: none;
            -webkit-backface-visibility: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .fa-mobile{
            content: "\f10b";
        }

        .fa-internet-explorer{
            content: "\f26b";
        }

        .fa-gamepad{
            content: "\f11b";
        }

        .fa-bolt{
            content: "\f0e7";
        }

        .fa-motorcycle{
            content: "\f21c";
        }

        .fa-building{
            content: "\f1ad";
        }

        @media screen and (max-width: 58em) {
            .tabs nav a.element span {
                display: none;
            }
            .tabs nav a:before {
                margin-right: 0;
            }
        }

        .no-slider {
            margin-top: 110px;
        }

        .form-control {
            font-weight: 600;
        }

        a.element:hover {
            text-decoration: none !important;
        }
        
        .img-produk {
            padding: 8px
        }
        
        .tabs-style-flip .content-wrap {
            background: #f3f4f5 !important;
            color: #132937;
        }
        
        .partner-logo {
            height: 100%;
            max-height: 40px;
            margin: 0px 15px;
            cursor: pointer;
        }

        @media screen and (max-width: 780px) {
          .table{
              font-size:12px;
          }
      }

    </style>
@endsection
@section('content')
<!-- Start Slideshow Section -->
<section id="slideshow">
   <div class="container">
      <div class="row">
         <div class="no-slider">
            <div class="col-md-12 col-sm-12" style="text-align:center">

               <div class="animate-block">
                
                  <h1 style="margin-top: 10;margin-bottom:10">Raih Keuntungan dari <span id="word-rotating">Pulsa Elektrik, Paket Internet, Voucher Game, Token PLN, PPOB</span></h1>
                  <p style="margin-top: 0;">{{$GeneralSettings->description}}</p>
               </div> <!--/ animate-block -->
                <section style="margin-top: 50px;">
                    <div class="tabs tabs-style-flip">
                        <nav>
                            <ul>
                                @foreach($pembeliankategori as $data)
                                <li class="{{($data['id'] == 1)?'tab-current':''}}"><a href="#section-flip-{{$data['id']}}" class="element fa-{{$data['icon']}} custom__text-green"><span>&nbsp;{{ str_limit($data['product_name'], 15) }}</span></a></li>
                                @endforeach
                                <li class=""><a href="#section-flip-10000" class="element fa-building"><span>&nbsp;TAGIHAN</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                                @foreach($pembeliankategori as $data)
                                    <section id="section-flip-{{$data['id']}}" class="{{($data['id'] == 1)?'content-current':''}}">
                                        @if( $data['type'] == 'PLN' )
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No. Meter/ID. Pelanggan : </label>
                                                        <input type="number" id="no_meter_pln" name="no_meter_pln" value="" class="form-control" placeholder="No. Meter atau ID Pelanggan adalah nomor yang tertera pada kartu pelanggan" autocomplete="off" autofocus required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Produk : </label>
                                                                <select name="product_{{strtolower(str_replace(' ', '', $data['product_name']))}}" class="form-control" id="product_{{strtolower(str_replace(' ', '', $data['product_name']))}}">
                                                                    @if(count($produkPLN) > 0)
                                                                        <option value="">Pilih Produk ...</option>
                                                                            @foreach($produkPLN as $dataPLN)
                                                                                <option value="{{$dataPLN['product_id']}}" {{ $dataPLN['status'] == 0 ? 'disabled' : '' }}>{{$dataPLN['product_name']}} (Rp {{number_format($dataPLN['price'], 0, '.', '.')}})</option>
                                                                            @endforeach
                                                                    @else
                                                                        <option value="" selected disabled style="font-style: italic;">Produk tidak tersedia</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Nomor Handphone : </label>
                                                                <input type="number" id="target_{{strtolower(str_replace(' ', '', $data['product_name']))}}" name="no_hp" value="" class="form-control" placeholder="Masukkan Nomor Handphone Pembeli" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if((Auth::check()))
                                                    <div class="form-group">
                                                        <label>Pin : </label>
                                                        <input type="number" id="pin_{{strtolower(str_replace(' ', '', $data['product_name']))}}" name="pin" class="form-control pin_{{strtolower(str_replace(' ', '', $data['product_name']))}}" placeholder="Masukkan PIN anda" autocomplete="off" autofocus>
                                                    </div>
                                                    @endif
                                                    <div class="form-group">
                                                        @if((Auth::check()))
                                                            <button type="submit" name="submit" class="submit btn btn-sm btn-primary" id="btn_{{strtolower(str_replace(' ', '', $data['product_name']))}}">BELI SEKARANG</button>
                                                        @else
                                                            <a href="{{url('/login')}}" class="submit btn btn-sm btn-primary">BELI SEKARANG</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    {{strtoupper($data['product_name'])}}
                                                    <br>*Pastikan Input No. Meter/ID. Pelanggan dengan benar<br/>
                                                    <div><div id="allert_boostrapt_{{strtolower(str_replace(' ', '', $data['product_name']))}}"></div></div>
                                                    <div id="inquiry_data"></div>
                                                    <div class="col-md-12 logo-produk">
                                                        <center>
                                                          <img class="img-produk" width="80px" src="{{ url('/img/logo-produk/pln-20000.png') }}">
                                                          <img class="img-produk" width="80px" src="{{ url('/img/logo-produk/pln-50000.png') }}">
                                                          <img class="img-produk" width="80px" src="{{ url('/img/logo-produk/pln-100000.png') }}">
                                                          <img class="img-produk" width="80px" src="{{ url('/img/logo-produk/pln-200000.png') }}">
                                                          <img class="img-produk" width="80px" src="{{ url('/img/logo-produk/pln-500000.png') }}">
                                                          <img class="img-produk" width="80px" src="{{ url('/img/logo-produk/pln-1000000.png') }}">
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nomor Pengisian : </label>
                                                        <input type="number" id="target_{{strtolower(str_replace(' ', '', $data['product_name']))}}" name="target" value="" class="form-control" autocomplete="off" placeholder="Masukkan Nomor Handphone / Rekening Pengisian" autocomplete="off" autofocus>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Provider/Operator : </label>
                                                                <select name="provider_{{strtolower(str_replace(' ', '', $data['product_name']))}}" id="provider_{{strtolower(str_replace(' ', '', $data['product_name']))}}" class="form-control">
                                                                    @if(count($pembeliankategori) > 0)
                                                                        <option value="">Pilih Operator ...</option>
                                                                            @foreach($pembeliankategori as $kategori)
                                                                                @if($kategori->id == $data['id'])
                                                                                    @foreach($kategori->pembelianoperator->sortBy('product_name') as $dt)
                                                                                        <option value="{{$dt->id}}">{{$dt->product_name}}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endforeach
                                                                    @else
                                                                        <option value="" selected disabled style="font-style: italic;">Produk tidak tersedia</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Produk : </label>
                                                                <select name="product_{{strtolower(str_replace(' ', '', $data['product_name']))}}" id="product_{{strtolower(str_replace(' ', '', $data['product_name']))}}" class="form-control">
                                                                    <option value="">Pilih Produk ...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if((Auth::check()))
                                                    <div class="form-group">
                                                        <label>Pin : </label>
                                                        <input type="number" id="pin_{{strtolower(str_replace(' ', '', $data['product_name']))}}" name="pin" class="form-control" placeholder="Masukkan PIN anda" autocomplete="off" autofocus>
                                                    </div>
                                                    @endif
                                                    <div class="form-group">
                                                        @if((Auth::check()))
                                                            <button type="submit" name="submit" class="submit btn btn-sm btn-primary" id="btn_{{strtolower(str_replace(' ', '', $data['product_name']))}}">BELI SEKARANG</button>
                                                        @else
                                                            <a href="{{url('/login')}}" class="submit btn btn-sm btn-primary">BELI SEKARANG</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    {{strtoupper($data['product_name'])}}
                                                    <br>*Pastikan Input No.Pengisian dengan benar<br/>
                                                    <div class="help-block"><small><div id="allert_boostrapt_{{strtolower(str_replace(' ', '', $data['product_name']))}}"></div></small></div>
                                                    <div class="col-md-12 logo-produk">
                                                        <center>
                                                    @if( preg_match('/pulsa/i', $data['product_name']) )
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/axis.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/smartfren.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/telkomsel.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/tri.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/indosat.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/xl.png">
                                                    @elseif( preg_match('/data/i', $data['product_name']) )
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/axis.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/smartfren.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/telkomsel.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/tri.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/indosat.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/xl.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/bolt.png">
                                                    @elseif( preg_match('/voucher game/i', $data['product_name']) )
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/asiasoft.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/garena.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/gemscool.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/steam.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/digicash.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/matchmove.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/iahgames.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/zynga.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/spin.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/google-play.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/itunes.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/wavegame.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/megaxus.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/lyto.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/cabal.png">
                                                    @elseif( preg_match('/ojek/i', $data['product_name']) )
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/gojek.png">
                                                        <img class="img-produk" src="{{ url('/') }}/img/logo-produk/grab.png">
                                                    @endif
                                                    </center>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </section>
                                @endforeach

                                <!-- TAGIHAN -->
                                <section id="section-flip-10000" class="">
                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Jenis Tagihan : </label>
                                              <select name="provider_tagihan" class="form-control" id="provider_tagihan">
                                                <option value="">Pilih Jenis Tagihan</option>
                                                @foreach($tagihan_providers as $data)
                                                  <option value="{{$data->id}}">{{$data->product_name}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Provider : </label>
                                              <select name="product_tagihan" class="form-control" id="product_tagihan">
                                                <option value="">Pilih Provider</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ID Pelanggan : </label>
                                                    <input type="text" id="id_pelanggan_tagihan" name="id_pelanggan" value="" class="form-control" placeholder="ID Pelanggan/No. Kontrak" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>No. HP Pembeli : </label>
                                                    <input type="number" id="target_tagihan" name="no_hp" value="" class="form-control" placeholder="Masukkan Nomor Handphone Pembeli" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        @if((Auth::check()))
                                        <div class="form-group">
                                            <label>Pin : </label>
                                            <input type="number" id="pin_tagihan" name="pin" class="form-control" placeholder="Masukkan PIN anda" autocomplete="off" autofocus>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <button {!! Auth::check() ? 'id="cek_tagihan"' : 'onclick="javascript:window.open(\''.route('login').'\', \'_self\');"' !!} class="submit btn btn-sm btn-primary">CEK TAGIHAN</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        TAGIHAN PASCABAYAR
                                        <br>*Pastikan Input ID. Pelanggan dengan benar<br/>
                                        <div><div id="allert_boostrapt_tagihan"></div></div>
                                        <div id="inquiry_data"></div>
                                        <div class="col-md-12 logo-produk">
                                            <center>
                                              <img class="img-produk" src="https://tripay.co.id/img/logo-produk/telkom.png">
                                              <img class="img-produk" src="https://tripay.co.id/img/logo-produk/pdam.png">
                                              <img class="img-produk" width="90px" src="https://tripay.co.id/img/logo-produk/Logo_PLN.png">
                                              <img class="img-produk" src="https://tripay.co.id/img/logo-produk/bpjs.png">
                                              <img class="img-produk" width="90px" src="{{ url('/img/logo-produk/speedy.jpg') }}">
                                              <img class="img-produk" width="120px" src="{{ url('/img/logo-produk/womfinance.jpg') }}">
                                              <img class="img-produk" src="https://tripay.co.id/img/logo-produk/pgn.png">
                                              <img class="img-produk" width="120px" src="{{ url('/img/logo-produk/megaautofinance.jpg') }}">
                                            </center>
                                        </div>
                                    </div>
                                  </div>
                                </section>
                                
                               

                        </div><!-- /content -->
                    </div><!-- /tabs -->
                </section>
                    <div><p></p></div>
                </div>
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
         <div class="col-md-10 col-md-offset-1">
            <div class="section-heading text-center">
               <h2 class="title">Mengapa memilih Agen Pembayaran Online?</h2>
               <p>Kami merupakan salah satu server pulsa elektrik termurah yang ada di Indonesia, Sebagai distributor pulsa peran kami adalah mempermudah bisnis pulsa menjadi lebih sederhana dengan sistem Multichip, yang artinya anda tidak perlu lagi banyak chip dan ponsel untuk tiap-tiap operator, karena kami telah menyediakan berbagai sistem pengisian pulsa seperti Website, WebApps, Aplikasi Messanger dan API untuk melakukan pengisian pulsa All Operator, Pembayaran PLN Prabayar, Voucher Game Online dll</p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-4 col-md-4">
            <!-- Start User Friendly Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span aria-hidden="true" class="icon-profile-male fa-3x custom__text-green"></span>
               </div>
               <h3>Pendaftaran Gratis Dan Mudah</h3>
               <p>Tanpa biaya pendaftaran 100% Gratis, setelah mendaftar akun anda langsung aktif dan dapat melakukan deposit.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start Supper Fast Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span class="icon-speedometer fa-3x custom__text-green"></span>
               </div>
               <h3>Transaksi Otomatis 24 Jam</h3>
               <p>Tengah malam kamu masih bisa melakukan transaksi Pulsa, Paket Internet, Paket SMS, Token PLN, dan Voucher Game.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start Analytics Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span class="icon-browser fa-3x custom__text-green"></span>
               </div>
               <h3>Jalur Trasanksi Online</h3>
               <p>Kami menyediakan beberapa jalur transaksi online, dijamin tanpa biaya sms, yaitu transaksi via Website dan WebApps.</p>
            </div>
            <!-- End Block -->
         </div>
      </div>
      <div class="row">
         <div class="col-sm-4 col-md-4">
            <!-- Start Photo Gallery Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span class=" icon-basket fa-3x custom__text-green"></span>
               </div>
               <h3>Produk Pulsa Paling Lengkap</h3>
               <p>Tersedia Produk yang lengkap seperti Pulsa All Oprator, Paket Data, Voucher Game, Token PLN, Pembayaran PPOB, Dll</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start Manage Event Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span class="icon-linegraph fa-3x custom__text-green"></span>
               </div>
               <h3>Harga Terbaik dan Terpercaya</h3>
               <p>Kami terus melakukan inovasi dan penambahan fitur, sehingga transaksi semakin lancar dengan harga paling murah.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start Manage Event Block -->
            <div class="box-content text-center">
               <div class="block-icon">
                  <span class="icon-mobile fa-3x custom__text-green"></span>
               </div>
               <h3>Deteksi Otomatis</h3>
               <p>Mendeteksi nomor secara otomatis & menawarkan harga terbaik tanpa perlu membuang banyak waktu.</p>
            </div>
            <!-- End Block -->
         </div>
      </div>
      <div class="row">
          <div class="col-sm-4 col-md-4">
            <!-- Start Support Block -->
            <div class="box-content no-border-last text-center">
               <div class="block-icon">
                  <span class="icon-pricetags fa-3x custom__text-green"></span>
               </div>
               <h3>Metode Pembayaran</h3>
               <p>Banyak pilihan jalur pembayaran mulai dari bank, indomaret/alfamart, gopay/ovo, paypal, cryptocurency & terus bertambah.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start Support Block -->
            <div class="box-content no-border-last text-center">
               <div class="block-icon">
                  <span class="icon-recycle fa-3x custom__text-green"></span>
               </div>
               <h3>Refund Transaksi</h3>
               <p>Pengembalian Saldo jika transaksi yang dilakukan mendapatkan status sukses tetapi pulsa/produk belum masuk kepada pembeli.</p>
            </div>
            <!-- End Block -->
         </div>
         <div class="col-sm-4 col-md-4">
            <!-- Start Support Block -->
            <div class="box-content no-border-last text-center">
               <div class="block-icon custom__text-green">
                  <span class="icon-chat fa-3x custom__text-green"></span>
               </div>
               <h3>Bantuan CS 24/7</h3>
               <p>Kami menyediakan beberapa tempat bertanya atau komplain mulai dari live chat, telegram, whatsapp, facebook dan telpon.</p>
            </div>
            <!-- End Block -->
         </div>
      </div>
   </div>
</section>
<!-- End Feature Section -->

<!-- Start Client Reviews -->
<section id="testimonial" class="padding-2x">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-md-offset-3">
            <div class="section-heading text-center">
               <h2 class="title">Testimonial</h2>
               <p>Apa kata mereka mengenai {{$GeneralSettings->nama_sistem}}?</p>
            </div>
         </div>
      </div>
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
         <div align="center" style="margin-top:20px;">
            <a href="{{url('/testimonial')}}" class="btn  btn-primary btn-lg" style="width:200px;">Lihat Semua</a>
         </div>
      </div>
   </div>
</section>
<!-- End Clients Feedback -->

<section id="twitter-feed" class="grey-bg padding-1x">
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="section-heading text-center">
               <h2 class="title" style="">Dukungan Metode Pembayaran</h2>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Start Client Reviews -->
<section id="partners" class="padding-2x">
   <div class="container">
      <div class="row">
         <div align="center" style="margin-top:0px;">
         <img class="partner-logo" src="{{ asset('/img/icon/banks/bri.png') }}" style="max-height:120px;height:100%" />
         <img class="partner-logo" src="{{ asset('/img/icon/banks/bni.png') }}" style="max-height:120px;height:100%" />
         <img class="partner-logo" src="{{ asset('/img/icon/banks/bca.png') }}" style="max-height:120px;height:100%" />
         <img class="partner-logo" src="{{ asset('/img/icon/banks/mandiri.png') }}" style="max-height:120px;height:100%" />
         </div>
      </div>
   </div>
</section>
<!-- End Clients Feedback -->

<!-- Start FAQ Section -->
<section id="faq" class="grey-bg padding-2x">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-md-offset-3">
            <div class="section-heading text-center">
               <h2 class="title">Bantuan (FAQ)</h2>
               <p>Hal yang sering ditanyakan</p>
            </div>
         </div>
      </div>
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
         <div align="center" style="margin-top:50px;">
            <a href="{{url('/faq')}}" class="btn  btn-primary btn-lg" style="width:200px;">Lihat Semua</a>
         </div>
      </div>
   </div>
</section>
<!-- End FAQ Section -->


<!-- Start Contact Section  -->
<section id="contactus">
   <div class="container">
      <div class="row">
         <div class="col-sm-6 col-md-6">
            <!-- Start Contact Form -->
            <div class="enquiry-box padding-2x">
               <p style="font-size: 14px;">Jika ada pertanyaan, Pengaduan, Kritik dan Saran silahkan kirimkan pesan Anda di sini.</p style="font-size: 15px;">
               <form id="contact-form" role="form" novalidate="true">
                    {{ $captcha->form_field(null, 'contact_captcha_id') }}
                  <div class="controls">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <input id="contact_first_name" class="form-control" placeholder="Masukkan Nama Depan *" required="required" data-error="Nama Depan tidak boleh kosong." type="text">
                              <div class="help-block with-errors" style="font-size: 11px;"></div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <input id="contact_last_name" class="form-control" placeholder="Masukkan Nama Belakang *" required="required" data-error="Nama Depan tidak boleh kosong." type="text">
                              <div class="help-block with-errors" style="font-size: 11px;"></div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <input id="contact_email" class="form-control" placeholder="Masukkan Alamat Email *" required="required" data-error="Alamat Email tidak boleh kosong." type="email">
                              <div class="help-block with-errors" style="font-size: 11px;"></div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <input id="contact_phone" class="form-control" placeholder="Masukkan Nomor Handphone *" required="required" data-error="Nomor Handphone tidak boleh kosong." type="text">
                              <div class="help-block with-errors" style="font-size: 11px;"></div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <textarea id="contact_message" class="form-control" placeholder="Masukkan Isi Pesan Anda *" rows="4" required="required" data-error="Pesan tidak boleh kosong."></textarea>
                              <div class="help-block with-errors" style="font-size: 11px;"></div>
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="form-group">
                              <input id="contact_captcha" class="form-control" placeholder="Masukkan kode Captcha disamping" required="required" data-error="Captcha tidak boleh kosong." type="text">
                              <div class="help-block with-errors" style="font-size: 11px;"></div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              {{ $captcha->html_image(['style' => 'max-height: 32px']) }}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <input class="btn  btn-primary btn-send" onclick="sendMessage()" value="Kirim Pesan" name="submit" type="button">
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-sm-6 col-md-6">
            <div class="contact-info padding-2x">
               <div class="medium">
                  <div class="medium-left">
                     <i class="icon-map fa-3x" aria-hidden="true"></i>
                  </div>
                  <div class="medium-body">
                     <h4 class="medium-heading">Alamat</h4>
                     <p>{{$GeneralSettings->alamat}}</p>
                  </div>
               </div>
               <div class="medium">
                  <div class="medium-left">
                     <i class="icon-envelope fa-3x" aria-hidden="true"></i>
                  </div>
                  <div class="medium-body">
                     <h4 class="medium-heading">Email Kami</h4>
                     <p><a href="mailto:{{$GeneralSettings->email}}">{{$GeneralSettings->email}}</a></p>
                  </div>
               </div>
               <div class="medium">
                  <div class="medium-left">
                     <i class="icon-lifesaver fa-3x" aria-hidden="true"></i>
                  </div>
                  <div class="medium-body">
                     <h4 class="medium-heading">Hotline Kami</h4>
                     <p>{{$GeneralSettings->hotline}}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- End Contact Section  -->

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

<div aria-labelledby="tagihanLabel" class="modal fade" id="tagihanModal" role="dialog" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
        <h4 class="text-center modal-title">Detail Tagihan</h4>
      </div>
      <div class="modal-body" id="modal_body">
        <div class="box-body" style="color: #6E6C6C">
          <form action="{{ url('/member/process/bayartagihan') }}" id="boxresult" method="post" name="boxresult"></form>
        </div>
      </div>
      <div class="modal-footer" id="modal_footer"></div>
    </div>
  </div>
</div>

@endsection

@section('js')
    <script src="{{asset('/assets/TabStylesInspiration/js/modernizr.custom.js')}}"></script>
    <script src="{{asset('/assets/TabStylesInspiration/js/cbpFWTabs.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script>

        function sendMessage()
        {
            var name = $('#contact_first_name').val() + ' ' + $('#contact_last_name').val();
            var email = $('#contact_email').val();
            var phone = $('#contact_phone').val();
            var message = $('#contact_message').val();
            var captcha = $('#contact_captcha').val();
            var captcha_id = $('#contact_captcha_id').val();

            if( name.length < 2 ) {
                alert("Mohon masukkan nama Anda");
                return false;
            }

            if( !email.length ) {
                alert("Mohon masukkan email Anda");
                return false;
            }

            if( !phone.length ) {
                alert("Mohon masukkan nomor HP Anda");
                return false;
            }

            if( !message.length ) {
                alert("Mohon masukkan isi pesan Anda");
                return false;
            }

            $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                  color: '#fff'
            } });

            $.ajax({
                url: "{{ url('/messages') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    captcha_id: captcha_id,
                    name: name,
                    email: email,
                    phone: phone,
                    message: message,
                    captcha: captcha
                },
                success: function(s) {
                    $.unblockUI();
                    if( s.success === true ) {
                        toastr.success("Berhasil Mengirim Pesan. Terimakasi telah munghubungi kami, pesan berupa pengaduan, kritik dan saran akan kami tanggapi melalui email atau nomor handphone anda.");
                    } else {
                        toastr.error(s.message);
                    }
                },
                error: function(e) {
                    $.unblockUI();
                    toastr.error("Connection error");
                }
            })
        }

        (function() {

            [].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
                new CBPFWTabs( el );
            });

        })();

    toastr.options = {
       "positionClass": "toast-bottom-right",
    }
     @if(Session::has('alert-success'))
         toastr.success("{{ Session::get('alert-success') }}");
     @endif

     @if(Session::has('alert-info'))
         toastr.info("{{ Session::get('alert-info') }}");
     @endif

     @if(Session::has('alert-warning'))
         toastr.warning("{{ Session::get('alert-warning') }}");
     @endif

     @if(Session::has('alert-error'))
         toastr.error("{{ Session::get('alert-error') }}");
     @endif
    </script>

    <script>

    function rupiah(nStr) {
           nStr += '';
           x = nStr.split('.');
           x1 = x[0];
           x2 = x.length > 1 ? '.' + x[1] : '';
           var rgx = /(\d+)(\d{3})/;
           while (rgx.test(x1))
           {
              x1 = x1.replace(rgx, '$1' + '.' + '$2');
           }
           return "Rp " + x1 + x2;
    }

    Array.prototype.inArray = function (value)
    {
       var i;
       for (i=0; i < this.length; i++)
       {
       if (this[i] == value)
       {
       return true;
       }
       }
       return false;
    };

    var kategori = <?php echo json_encode($pembeliankategori) ?>;

    kategori.forEach(function(value) {

        var IDparam  = (value.product_name.toLowerCase()).replace(/\s+/g, '');
        var provider = "provider_"+IDparam;
        var target   = "target_"+IDparam;
        var butonpay = "btn_"+IDparam;

        // FOR GET PROVIDER
        $("#"+provider).on('change', function() {
            getProduct(IDparam, $("#"+provider).val());

        });

        // FOR GET TARGET
        var exception =["REGULER","INTERNET","TRANSFER","SMS"];
        if(exception.inArray(value.type)){
          $("#target_"+IDparam+"").on("input propertychange paste", function() {
             var parent = value.id;
             if ( $("#"+target).val().length > 3){
                 var prefix = $("#"+target).val().substring(0, 4);
                 getPulsa(prefix, IDparam, parent);
             }
             if ( $("#"+target).val().length == 0){
                 getOperator(IDparam, parent);
             }
          });
        }

        // FOR BUTTON PAY
        $("#"+butonpay).on('click', function() {
            var id_operator = $("#"+provider).val();
            //console.log(id_operator);
            var type        = value.type;
            beli(IDparam, type, id_operator);
        });

    });
    
    function getPulsa($prefix, $cat, $parent) {
            $('#product_'+$cat).append('<option value="" selected="selected">Loading...</option>');
            $('#provider_'+$cat).append('<option value="" selected="selected">Loading...</option>');
            $.ajax({
                url: "{{ url('/process/prefixproduct') }}",
                dataType: "json",
                type: "GET",
                data: {
                    'prefix': $prefix,
                    'parent': $parent
                },
                success: function (response) {
                   
                    $('#product_'+$cat).empty();
                    $('#provider_'+$cat).empty();
                    
                    if( response.produk.length > 0 ) {
                        $.each(response.produk, function(index, produkObj){
                            harga = parseInt(produkObj.price);
                            if (produkObj.status == 0) {
                                $('#product_'+$cat).append('<option value="'+produkObj.product_id+'" style="color: #C8C8C8;" disabled>'+produkObj.product_name+' ('+rupiah(harga)+')</option>');
                            }else{
                                $('#product_'+$cat).append('<option value="'+produkObj.product_id+'">'+produkObj.product_name+' ('+rupiah(harga)+')</option>');
                            }
                        });
                    } else {
                        $('#product_'+$cat).append('<option style="color: #C8C8C8;">-- Produk tidak tersedia --</option>');
                    }
                    
                    if( response.operator.length > 0 ) {
                        $.each(response.operator, function(index, operatorObj){
                            if (operatorObj.status == 0) {
                                $('#provider_'+$cat).append('<option value="'+operatorObj.id+'" style="color: #C8C8C8;" disabled>'+operatorObj.product_name+'</option>');
                            }else{
                                $('#provider_'+$cat).append('<option value="'+operatorObj.id+'">'+operatorObj.product_name+'</option>');
                            }
                        });
                    } else {
                        $('#provider_'+$cat).append('<option style="color: #C8C8C8;">-- Provider tidak tersedia --</option>');
                    }
                },
                error: function (response) {
                    toastr.error("Data tidak ditemukan, periksa kembali nomor handphone tujuan anda");
                        $('#provider_'+$cat).empty();
                        $('#provider_'+$cat).append('<option value="" selected="selected">Pilih Operator ...</option>');
                        $('#product_'+$cat).empty();
                        $('#product_'+$cat).append('<option value="" selected="selected">Pilih Produk ...</option>');
                }

            });
        }
        
    function getOperator($cat, $parent){
            $('#product_'+$cat).append('<option value="" selected="selected">Loading...</option>');
            $('#provider_'+$cat).append('<option value="" selected="selected">Loading...</option>');
            $.ajax({
                url: "{{ url('/process/getoperator') }}",
                dataType: "json",
                type: "GET",
                data: {
                    'category': $parent
                },
                success: function (response) {
                    console.log(response)
                    if(response.length != 0){
                        $('#provider_'+$cat).empty();
                        $('#provider_'+$cat).append('<option value="" selected="selected">Pilih Operator ...</option>');
                        $('#product_'+$cat).empty();
                        $('#product_'+$cat).append('<option value="" selected="selected">Pilih Produk ...</option>');
                        $.each(response, function(index, operatorObj){
                                if (operatorObj.status == 0) {
                                    $('#provider_'+$cat).append('<option value="'+operatorObj.id+'" style="color: #C8C8C8;" disabled>'+operatorObj.product_name+'</option>');
                                }else{
                                    $('#provider_'+$cat).append('<option value="'+operatorObj.id+'">'+operatorObj.product_name+'</option>');
                                }
                        });
                    }
                },
                error: function (response) {
                    toastr.error("Data tidak ditemukan, periksa kembali nomor handphone tujuan anda");
                    $('#provider_'+$cat).empty();
                    $('#provider_'+$cat).append('<option value="" selected="selected">Pilih Operator ...</option>');
                    $('#product_'+$cat).empty();
                    $('#product_'+$cat).append('<option value="" selected="selected">Pilih Produk ...</option>');

                }

            });
        }
    
    function getProduct($product, $operator) {
            $('#product_'+$product).empty();
            $('#product_'+$product).append('<option value="" selected="selected">Loading...</option>');
        $.ajax({
                url: "{{ url('/process/findproduct') }}",
                dataType: "json",
                type: "GET",
                data: {
                    'pembelianoperator_id': $operator
                },
                success: function (response) {
                    //console.log(response);
                    $('#product_'+$product).empty();
                    $.each(response, function(index, produkObj){
                            harga = parseInt(produkObj.price);
                            if (produkObj.status == 0) {
                                $('#product_'+$product).append('<option value="'+produkObj.product_id+'" style="color: #C8C8C8;" disabled>'+produkObj.product_name+' ('+rupiah(harga)+')</option>');
                            }else{
                                $('#product_'+$product).append('<option value="'+produkObj.product_id+'">'+produkObj.product_name+'</option>');
                            }
                        });
                },
                error: function (response) {
                    toastr.error("TERJADI KESALAHAN, SILAHKAN REFRESH HALAMAN DAN LAKUKAN LAGI.");
                    $('#product_'+$product).empty();
                    $('#product_'+$product).append('<option value="" selected="selected">Pilih Produk ...</option>');
                }

            });
    }
    
    function beli($category, $type, id_operator){
        $.blockUI({ css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
              color: '#fff'
        }});
        
        var target   = $('#target_'+$category).val();
        var pin      = $('#pin_'+$category).val();
        var provider = $('#provider_'+$category).val();
        var product  = $('#product_'+$category).val();
        
        if($type == "PLN"){
            var no_meter_pln = $('#no_meter_pln').val();
            if( no_meter_pln == '' ){
                $.unblockUI();
                toastr.error("MOHON MAAF, BIDANG ISIAN ID PELANGGAN TIDAK BOLEH KOSONG.");
                return false;
            }
        }else{
            var provider = $('#provider_'+$category).val();
            if( provider == '' ){
                $.unblockUI();
                toastr.error("MOHON MAAF, BIDANG ISIAN PROVIDER TIDAK BOLEH KOSONG.");
                return false;
            }
        }

        if( target == ''){
            $.unblockUI();
            toastr.error("MOHON MAAF, BIDANG NO PENGISIAN TIDAK BOLEH KOSONG.");
            return false;
        }

        
        if( pin == ''){
            $.unblockUI();
            toastr.error("MOHON MAAF, BIDANG PIN TIDAK BOLEH KOSONG.");
            return false;
        }

        if(product == '' ){
            $.unblockUI();
            toastr.error("MOHON MAAF, BIDANG ISIAN PRODUK TIDAK BOLEH KOSONG.");
            return false;
        }

        $.ajax({
            url: "{{ url('/member/process/orderproduct/home') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                'submit': $('input[name=submit]').val(),
                'target': target,
                'no_meter_pln' : no_meter_pln,
                'pin': pin,
                'produk':product,
                'pembelianoperator_id': id_operator,
                'type': $type
            },
            success: function(response){
                //console.log(response);
                if (response.success === false) {
                    $.unblockUI();
                    toastr.error(response.message);
                    return false;
                }

                $.unblockUI();
                toastr.success(response.message);
                
                $('#target_'+$category).val('')
                $('#pin_'+$category).val('')
                getOperator($category, id_operator);
                window.location.reload();
                
            },
            error: function(response){
                $.unblockUI();
                // console.log(response.responseText);
                if(response.success == 0){
                    toastr.error(response.message)
                    return false;
                }
            }
        })
    }
    
    $('#provider_tagihan').on('change', function(e){
           var pembayaranoperator_id = $('#provider_tagihan').val();
           $('#product_tagihan').empty();
           $('#product_tagihan').append('<option value="" selected="selected">Loading...</option>');

            $.ajax({
                url: "{{ url('/process/findproduct/pembayaran') }}",
                dataType: "json",
                type: "GET",
                data: {
                    'pembayaranoperator_id': pembayaranoperator_id,
                    //'pembayarankategori_id': value.id
                },
                success: function (response) {
                    //console.log(response);
                    $('#product_tagihan').empty();
                    if(response.length != 0){
                        $.each(response, function(index, produkObj){
                            harga = parseInt(produkObj.price_markup);
                            if (produkObj.status == 0) {
                                $('#product_tagihan').append('<option value="'+produkObj.product_name+'" style="color: #C8C8C8;" disabled>'+produkObj.product_name+' ('+rupiah(harga)+')</option>');
                            }else{
                                $('#product_tagihan').append('<option value="'+produkObj.code+'">'+produkObj.product_name+' <b>(Biaya Admin '+rupiah(harga)+')</b></option>');
                            }
                        });

                    }else{
                        toastr.error("Sistem SanPay sedang melakukan MAINTENANCE, untuk itu kami mohon untuk tidak melakukan transaksi terlebih dahulu. Trimakasih");
                    }

                },
                error: function (response) {
                    $('#product_tagihan').empty();
                    $('#product_tagihan').append('<option value="" selected="selected">-- Pilih Produk --</option>');
                    toastr.error("TERJADI KESALAHAN, SILAHKAN REFRESH HALAMAN DAN LAKUKAN LAGI.");
                }

            });
        });
        
    $('#cek_tagihan').on('click', btnCekTagihan);
    function btnCekTagihan(){
        $.blockUI({ css: {
              border: 'none',
              padding: '15px',
              backgroundColor: '#000',
              '-webkit-border-radius': '10px',
              '-moz-border-radius': '10px',
              opacity: .5,
              color: '#fff'
        } });
        
        var pembayaranoperator_id = $('#provider_tagihan').val();
        var produk_pembayaran = $('#product_tagihan').val();
        var nomor_rekening = $('#id_pelanggan_tagihan').val();
        var target = $('#target_tagihan').val();
        var pin = $('#pin_tagihan').val();

        if( produk_pembayaran == '' || nomor_rekening == '' || target == '' || pin == '' ){
            $.unblockUI();
            toastr.error("MOHON MAAF, BIDANG ISIAN OPERATOR TIDAK BOLEH KOSONG.");
            //return false;
        }

        $.ajax({
            url: "{{ url('/member/process/cektagihan/home') }}",
            method: "POST",
            data: {
                _token:"{{ csrf_token() }}",
                'submit':$('input[name=submit]').val(),
                'produk': produk_pembayaran,
                'nomor_rekening': nomor_rekening,
                'target': target,
                'pin': pin
            },

            success: function(response){
                if (response.success == false) {
                    $.unblockUI();
                    toastr.error(response.message);
                    return;
                }else{
                    var order_id = response.id;
                    var tagihan_id = response.tagihan_id;
                    var tanggal = response.created_at;
                    var phone = response.phone;
                    var nama = response.nama;
                    var bulan = response.periode;
                    var produk_ppob = response.product_name;
                    var no_pelanggan = response.no_pelanggan;
                    var jml_tagihan = parseInt(response.jumlah_tagihan);
                    var jml_bayar = parseInt(response.jumlah_bayar);
                    var admin = parseInt(response.admin);
                    var token = response.token;
                    $.unblockUI();
                    $('#boxresult').empty();
                    $('#boxresult').append('<input type="hidden" name="_token" value="'+token+'">');
                    $('#boxresult').append('<input type="hidden" name="order_id" value="'+order_id+'">');
                    $('#boxresult').append('<input type="hidden" name="tagihan_id" value="'+tagihan_id+'">');
                    $('#boxresult').append('<input type="hidden" name="jumlah_tagihan" value="'+jml_tagihan+'">');
                    $('#boxresult').append('<input type="hidden" name="admin" value="'+admin+'">');
                    $('#boxresult').append('<input type="hidden" name="harga" value="'+jml_bayar+'">');
                    $('#boxresult').append('<input type="hidden" name="bulan" value="'+bulan+'">');
                    $('#boxresult').append('<input type="hidden" name="produk_ppob" value="'+produk_ppob+'">');
                    $('#boxresult').append('<input type="hidden" name="target_phone" value="'+phone+'">');
                    $('#boxresult').append('<div id="box-body" style="color:black">');
                    $('#box-body').append('<div style="margin-top:5px"><span class="pull-left" style="font-size:14px">Order ID</span><span class="pull-right" style="font-size:14px">Tanggal</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div><span class="pull-left custom__text-green" style="font-size:18px;font-weight:bold;">'+order_id+'</span><span class="pull-right" style="font-size:14px">'+tanggal+'</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div style="margin-top:5px"><span class="pull-left" style="font-size:14px">Nomor Handphone</span><span class="pull-right" style="font-size:14px">Jumlah Tagihan</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div><span class="pull-left custom__text-green" style="font-size:18px;font-weight:bold;">'+phone+'</span><span class="pull-right custom__text-green" style="font-size:18px;font-weight:bold;">'+rupiah(jml_tagihan)+'</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div style="margin-top:5px"><span class="pull-left" style="font-size:14px">Nomor / ID Pelanggan</span><span class="pull-right" style="font-size:14px">Admin</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div><span class="pull-left custom__text-green" style="font-size:18px;font-weight:bold;">'+no_pelanggan+'</span><span class="pull-right custom__text-green" style="font-size:18px;font-weight:bold;">'+rupiah(admin)+'</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div style="margin-top:5px"><span class="pull-left" style="font-size:14px">Nama Pelanggan</span><span class="pull-right" style="font-size:14px">Jumlah Bayar</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div><span class="pull-left custom__text-green" style="font-size:18px;font-weight:bold;">'+nama+'</span><span class="pull-right custom__text-green" style="font-size:18px;font-weight:bold;">'+rupiah(jml_bayar)+'</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div style="margin-top:5px"><span class="pull-left" style="font-size:14px">Status</span></div><div class="clearfix"></div>');
                    $('#box-body').append('<div><span class="pull-left text-default" style="font-size:18px;font-weight:bold;">MENUNGGU</span></div><div class="clearfix"></div>');
                    $('#modal_footer').append('<button type="button" id="bayar" onclick="document.getElementById(\'boxresult\').submit()" class="btn btn-default btn-block btn-lg">Bayar Tagihan</button>');
                    $('#tagihanModal').modal('show');
                    
                }
            },
            error: function(response){
                $.unblockUI();
                // console.log(response.responseText);
                if(response.success == 0){
                    showalert(response.message, 'danger');
                    toastr.error(response.message);
                    return false;
                }
            }
        })
    }
    
    $('#beli_paypal').on('click', function() {
        var hour = '{{ date("H:i:s") }}';
        var email = $('#address_paypal').val();
        var nominal = $('#paypal_nominal').val();
        var pin = $('#pin_saldopaypal').val();
        var validEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        if( !validEmail.test(email) || parseInt(nominal) < {{ intval($ppsetting['min_amount']) }} || !pin.length ) {
            toastr.error("MOHON MAAF, MOHON ISI KOLOM YANG TERSEDIA DENGAN BENAR");
            return false;
        } else if( hour >= "{{ $ppsetting['end_hour'] }}" || hour < "{{ $ppsetting['start_hour'] }}" ) {
            toastr.error("MOHON MAAF, PEMBELIAN SALDO PAYPAL HANYA DAPAT DILAKUKAN PUKUL {{ $ppsetting['start_hour'] }} - {{ $ppsetting['end_hour'] }} WIB");
            return false;
        }
        
        $.blockUI({ css: {
              border: 'none',
              padding: '15px',
              backgroundColor: '#000',
              '-webkit-border-radius': '10px',
              '-moz-border-radius': '10px',
              opacity: .5,
              color: '#fff'
        }});
        
        $.ajax({
            url: "{{ url('/member/buy-paypal') }}",
            type: "POST",
            dataType: "JSON",
            data: {
                _token: "{{ csrf_token() }}",
                address_paypal: email,
                nominal: nominal,
                pin: pin
            },
            success: function(s) {
                $.unblockUI();
                if( s.success === true ) {
                    toastr.success(s.message);
                } else {
                    toastr.error(s.message);
                }
            },
            error: function(e) {
                $.unblockUI();
                toastr.error("Connection error");
            }
        })
    });
    
    function formatNumber(numb){
        o = numb.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        return o.toString();
    }

    function convertToRupiah(angka)
    {
    	var rupiah = '';
    	var angkarev = angka.toString().split('').reverse().join('');
    	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    	return rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function price_to_number(v){
      if(!v){return 0;}
          v=v.split('.').join('');
          v=v.split(',').join('');
      return Number(v.replace(/[^0-9.]/g, ""));
    }


    $('#paypal_nominal').keyup(function(){
        var toNumber=parseInt(price_to_number($('#paypal_nominal').val()));
        $('#paypal_nominal').val(toNumber);
    });

    function definitelyNaN (val) {
        return isNaN(val && val !== true ? Number(val) : parseFloat(val));
    }

    $('#paypal_nominal').on('input propertychange paste', function () {
        var nominal = $('#paypal_nominal').val();
        var rateDB = <?php echo json_encode($rate);?>;
        var rateDBLast = <?php echo json_encode($rateLast->rate);?>;
        
        var rate = parseInt(rateDBLast);
        rateDB.forEach(function(data) {
            if(parseInt(nominal) >= parseInt(data.usd_from) && parseInt(nominal) <= parseInt(data.usd_to)) {
                rate = data.rate;
            }
        });

        $('#pp_ratekurs1').html(convertToRupiah(parseInt(rate)));
        $('#pp_ratekurs2').html(convertToRupiah(parseInt(rate)));
        $('#pp_ratekurs3').html(convertToRupiah(parseInt(rate)));

        var convDollar = numeral(nominal).format('0,0.00');
        var ttl_withrate =  parseInt(rate) * parseInt(nominal);
        var checkNaN = definitelyNaN(ttl_withrate);
        
        if(checkNaN == true) {
            ttl_withrate = 0;
        };

        $('#pp_transaction').html(convDollar);
        $('#pp_total').html(convertToRupiah(ttl_withrate));
        if (ttl_withrate >= 250000)
        {
            var fee = 0;
            var fee = $('#pp_fee').html(fee);
            $('#pp_grand_total').html(convertToRupiah(ttl_withrate));
        }
        else
        {
            var fee = 0;
            var fee = $('#pp_fee').html(fee);
            $('#pp_grand_total').html(convertToRupiah(ttl_withrate));
        }
    });
    
    </script>
@endsection