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
            <h4 style="font-size: 20px;">AXIS</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'AXIS')
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


            <h4 style="font-size: 20px;">BOLT</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'BOLT')
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


            <h4 style="font-size: 20px;">CERIA</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'CERIA')
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


            <h4 style="font-size: 20px;">INDOSAT</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'INDOSAT')
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


            <h4 style="font-size: 20px;">INDOSAT SMS</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'SMS')
                          @if ($produk->message[$i]->operator == 'INDOSAT SMS')
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

            <h4 style="font-size: 20px;">INDOSAT TRANSFER PULSA</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'TRANSFER')
                          @if ($produk->message[$i]->operator == 'INDOSAT TRANSFER PULSA')
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

            <h4 style="font-size: 20px;">SMARTFREN</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'SMARTFREN')
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


            <h4 style="font-size: 20px;">TELKOMSEL</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'TELKOMSEL')
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

            <h4 style="font-size: 20px;">TELKOMSEL SMS</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'SMS')
                          @if ($produk->message[$i]->operator == 'TELKOMSEL SMS')
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

            <h4 style="font-size: 20px;">TELKOMSEL TRANSFER PULSA</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'TRANSFER')
                          @if ($produk->message[$i]->operator == 'TELKOMSEL TRANSFER PULSA')
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


            <h4 style="font-size: 20px;">TRI</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'TRI')
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


            <h4 style="font-size: 20px;">XL</h4>
            @if($jml > 0)
            <table class="table table-striped table-bordered" style="font-size: 15px;margin-bottom: 50px;">
                 <thead>
                    <tr class="text-primary">
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
                        @if ($produk->message[$i]->provider_sub == 'REGULER')
                          @if ($produk->message[$i]->operator == 'XL')
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
   //    $(function () {
   //    $('#table-operator').DataTable({
   //      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
   //      "iDisplayLength": 50,
   //      "searching": false,
   //      "lengthChange": false,
   //      "info": false
   //    });
   // });
</script>

@endsection