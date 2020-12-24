@extends('layouts.member')
<style type="text/css">
 
#share-buttons img {
width: 35px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
}
 
</style>
@section('content')
<section class="content-header hidden-xs">
	<h1>Bonus <small>Referral</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Referral</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Referral</h3>
                </div>
                <div class="box-body" align="center">
                    <p>Setiap ada yang bergabung & bertransaksi di {{setting()->nama_sistem}} melalui link atau URL Referral Sobat dibawah ini, maka Sobat mendapatkan bonus <b>Rp 25</b> tiap transaksi. Dan lebih hebat lagi bonus transaksi otomatis ditambahkan pada saldo Sobat TANPA SYARAT APAPUN tanpa minimal deposit ataupun kejar poin.</p>
                    <p>Sebagai simulasi, Sobat mengajak 100 teman bergabung & bertransaksi di {{setting()->nama_sistem}} baik untuk dipakai sendiri maupun dijual kembali dan setiap teman bertransaksi sebanyak 10x dalam sehari yang artinya dalam sehari ada 1000 transaksi dan tinggal dikali saja 30 untuk mencari jumlah transaksi dalam sebulan.
Jadi 30.000 (jumlah transaksi sebulan) x 25 (bonus tiap transaksi) = Rp 750.000,00 WOW sungguh luar biasa bukan, ini hanya simulasi kecil dan kami yakin Sobat {{setting()->nama_sistem}} bisa lebih hebat dari itu.
Terima kasih banyak.</p>
                  @if($user_validation)
                    @if($user_validation->status == 1)
                    <div class"col-md-6">
                        <!--<div class="container text-center" style="border: 1px solid #a1a1a1;padding: 15px;width: 25%;">-->
                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG($coderef, 'QRCODE')}}" alt="barcode" />
                            <br/>
                        <!--</div>-->
                    </div>
                    <div class"col-md-6">
                        <!-- I got these buttons from simplesharebuttons.com -->
                        <p><b>SHARE:</b></p>
                        <div id="share-buttons">
                            <!-- Facebook -->
                            <a href="http://www.facebook.com/sharer.php?u={{$coderef}}&amp;text=Agen%20pulsa%20murah&amp;hashtags=semangap" target="_blank">
                                <!--<img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />-->
                                <img src="https://image.flaticon.com/icons/png/128/124/124010.png" alt="Facebook" />
                            </a>
                            
                            <!-- Google+ -->
                            <a href="https://plus.google.com/share?url={{$coderef}}&amp;text=Agen%20pulsa%20murah&amp;hashtags=semangap" target="_blank">
                                <!--<img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />-->
                                <img src="https://image.flaticon.com/icons/png/128/124/124013.png" alt="Google" />
                            </a>
                            
                            <!-- LinkedIn -->
                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{$coderef}}" target="_blank">
                                <!--<img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />-->
                                <img src="https://image.flaticon.com/icons/png/128/124/124011.png" alt="LinkedIn" />
                            </a>
                            
                            <!-- Twitter -->
                            <a href="https://twitter.com/share?url={{$coderef}}&amp;text=Agen%20pulsa%20murah&amp;hashtags=semangap" target="_blank">
                                <!--<img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />-->
                                <img src="https://image.flaticon.com/icons/png/128/124/124021.png" alt="Twitter" />
                            </a>
                            
                            <!-- Telegram -->
                            <a href="https://telegram.me/share/url?url={{$coderef}}&amp;text=Agen%20pulsa%20murah&amp;hashtags=semangap" target="_blank">
                                <!--<img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />-->
                                <img src="https://image.flaticon.com/icons/png/128/124/124019.png" alt="Telegram" />
                            </a>
    
                            <!-- Whatsapp -->
                            <a href="whatsapp://send?text=*Agen%20pulsa%20murah%20hanya%20di%20:*{{$coderef}}" data-action="share/whatsapp/share" target="_blank">
                                <img src="https://image.flaticon.com/icons/png/128/124/124034.png" alt="WhatsApp" />
                            </a>
                            
                            <!-- Line -->
                            <a href="https://lineit.line.me/share/ui?url={{$coderef}}&amp;text=Agen%20pulsa%20murah&amp;hashtags=semangap" target="_blank">
                                <img src="https://image.flaticon.com/icons/png/128/124/124027.png" alt="Line" />
                            </a>
                        </div>
                    </div>
                    <br/>
                  
                            <div class="form-group">
                                <label>Link Referral</label>
                                <div class="input-group">
                                    <input class="form-control input-lg" id="ref" type="text" value="{{url('/')}}/register?ref={{Auth::user()->username}}" readonly style="text-align:center;">
                                    <div class="input-group-addon"><a href="Javascript:;" class="copy-text" data-clipboard-target="#ref"><i class="fa fa-clone custom__text-green"></i></a></div>
                                </div>
                            </div>
                        @endif
                    @else
                    <div class="alert alert-danger" role="alert">
                        Untuk bisa menggunakan fitur referral silahkan validasi akun anda <b><a href="{{url('/member/validasi-users')}}">disini</a></b>
                    </div>
                    @endif
                    <!--<div class="form-group">-->
                    <!--    <label>Kode Referral</label>-->
                    <!--    <div class="input-group">-->
                    <!--        <input class="form-control input-lg" id="kode_ref" type="text" value="{{ sprintf("%04d", Auth::user()->id) }}" readonly style="text-align:center;">-->
                    <!--        <div class="input-group-addon"><a href="Javascript:;" class="copy-text-kode" data-clipboard-target="#kode_ref"><i class="fa fa-clone custom__text-green"></i></a></div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Syarat & Ketentuan</h3>
                </div>
                <div class="box-body">
                    <ol>
                        <li>Referral merupakan program untuk mengajak orang bergabung di {{$GeneralSettings->nama_sistem}}.</li>
                        <li>Setiap orang yang diajak dan melakukan transaksi maka Sobat mendapatkan bonus Rp 25 tiap transaksi.</li>
                        <li>Bonus langsung masuk ke saldo Sobat tanpa kejar poin atau minimal trannsaksi.</li>
                        <li>Jumlah bonus harian tidak dibatasi jadi silahkan ajak teman  sebanyak-banyaknya.</li>
                        <li>Syarat & Ketentuan lainnya mengenai program referral akan di atur lebih jelas dalam Terms of Service {{$GeneralSettings->nama_sistem}}.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Referral Anda - {{$referrals->count()}} Data</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover" id="DataTable">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Level User</th>
                                <th>Kota</th>
                                <th>Status</th>
                                <th>Trx bulan ini</th>
                                <th>Trx total</th>
                                <th>Tgl Daftar</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row hidden-lg hidden-md">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Bonus Referral</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($referrals->count() > 0)
                      @foreach($referrals as $data)
                      <tr>
                         <td>
                            <a href="#!" class="btn-loading" style="color: #464646">
                               <div><i class="fa fa-calendar"></i> <small>{{date("d M Y", strtotime($data->created_at))}}</small></div>
                               <div style="font-size: 14px;font-weight: bold;">{{$data->name}}</div>
                               <div>{{$data->city}}</div>
                            </a>
                         </td>
                         <td align="right">
                            <a href="#!" class="btn-loading" style="color: #464646">
                               <div><i class="fa fa-clock-o"></i> <small>{{date("H:m:s", strtotime($data->created_at))}}</small></div>
                               <div>{{number_format($data->transaksis()->where('status', 1)->whereMonth('created_at', '=' ,date('m'))->whereYear('created_at', '=' ,date('Y'))->count(), 0, '.', '.')}}</div>
                            </a>
                         </td>
                      </tr>
                      @endforeach
                  @else
                  <tr>
                      <td colspan="2" style="text-align:center;font-style:italic;">Data belum tersedia</td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            
            <div class="box-footer" align="center" style="padding-top:13px;">
               
           </div>
         </div><!-- /.box -->
     </div>
   </div>
</section>
@endsection
@section('js')
<script>

$(function(){
  new Clipboard('.copy-text');
  $('.copy-text').on('click', function(){
      toastr.info("URL berhasil di salin");
  });
  
});
$(function(){
  new Clipboard('.copy-text-kode');
  $('.copy-text-kode').on('click', function(){
      toastr.info("Kode berhasil di salin");
  });
  
});

$(document).ready(function() {
    var table = $('#DataTable').DataTable({
        // deferRender: true,
        processing: true,
        serverSide: false,
        autoWidth: false,
        info: false,
        ajax:{
            url : "{{ route('get.referral.datatables') }}",
        },
        // order: [[ 8, "desc" ]],
        columns:[
                  {data: null, width: "50px", sClass: "text-center", orderable: false},
                  {data: 'name', defaulContent: '-' },
                  {data: 'level_user', defaulContent: '-' },
                  {data: 'city', defaulContent: '-' , sClass: "text-right"},
                  {data: 'status', defaulContent: '-' },
                  {data: 'trx_bulan_ini', defaulContent: '-' },
                  {data: 'count_trx', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                ]
     });
     table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
        } );
     }).draw();
});
</script>
@endsection