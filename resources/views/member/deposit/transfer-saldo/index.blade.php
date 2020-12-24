@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Saldo <small>Transfer Saldo</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Deposit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Transfer Saldo</h3>
                </div>
                <form role="form" action="{{url('/member/transfer-saldo/kirim')}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        <p align="center">Transfer Saldo ke sesama member {{ $GeneralSettings->nama_sistem }}<br>Masukkan nomor handphone tujuan transfer.</p>
                        <div class="form-group{{ $errors->has('no_tujuan') ? ' has-error' : '' }}">
                            <label>Nomor Handphone : </label>
                            <div class="input-group">
                                <input type="number" name="no_tujuan" id="number" class="form-control" value="{{old('no_tujuan')}}" placeholder="Masukkan Nomor Handphone Tujuan">
                                <span class="input-group-btn">
                                    <a id="cek_nomor" class="btn custom__btn-green btn-flat"><small>Cek Nomor</small></a>
                                </span>
                            </div>
                            {!! $errors->first('no_tujuan', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('nominal') ? ' has-error' : '' }}">
                            <label>Nominal Transfer : </label>
                            <div class="input-group">
                                <div class="input-group-addon">Rp. </div>
                                <input autocomplete="nope" type="text" name="nominal" id="nominal" class="form-control" value="{{old('nominal')}}" placeholder="Masukkan Nominal, Minimal 20000">
                            </div>
                            {!! $errors->first('nominal', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label>Kata Sandi : </label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi Anda">
                            {!! $errors->first('password', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <table class="table">
                            <tr>
                                <td style="vertical-align: middle;border-style: none;"><span class="icon-wallet custom__text-green" style="font-size:35px;"></span></td>
                                <td style="border-style: none;" align="right">
                                    <div style="font-weight:bold;" class="custom__text-green">Saldo {{$GeneralSettings->nama_sistem}}</div>
                                    <div style="font-size:12px;color:grey;">Sisa saldo anda adalah Rp {{number_format(Auth::user()->saldo, 0, '.', '.')}}</div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="submit btn btn-primary btn-block">&nbsp;&nbsp;Lanjutkan&nbsp;&nbsp;</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Syarat & Ketentuan</h3>
                </div>
                <div class="box-body">
                    <dt>Pendahuluan</dt>
                    <dd>Fitur Transfer Saldo adalah fitur yang digunakan untuk mengirim/berbagi saldo dengan member/referral anda yang berfungsi untuk membantu member/referral anda yang tidak dapat melakukan deposit saldo melalui transfer bank, anda dapat menggunakan fitur ini untuk menambahkan saldo Member/Referral anda.</dd>
                    <dt>Syarat & Ketentuan</dt>
                    <dd>
                        <ul>
                            <li>Anda tidak dapat melakukan transfer saldo ke akun anda sendiri.</li>
                            <li>Anda harus memiliki saldo minimal Rp 50.000 untuk melakukan transfer saldo.</li>
                            <li>Minimal Saldo yang anda transfer adalah Rp 20.000.</li>
                            <li>Lakukan pengecekan nomor tujuan transfer terlebih dahulu untuk memeriksa tujuan transfer anda apakah sudah benar atau belum.</li>
                            <li>Demi keamanan dalam fitur ini, anda di wajibkan untuk memasukkan kata sandi akun anda agar transfer saldo di pastikan dilakukan oleh anda.</li>
                            <li>Kami tidak bertanggung jawab jika anda salah dalam transfer saldo ke member/referral anda.</li>
                        </ul>
                    </dd>
                    <dt>Penutup</dt>
                    <dd>Sebelum menggunakan fitur ini di sarankan untuk membaca dan memahami benar syarat dan ketentuan dari fitur ini agar tidak terjadi kesalah pahaman. Syarat & Ketentuan diatas dapat berubah sewaktu - waktu tanpa pemberitahuan sebelumnya.</dd>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check text-success"></i> Data Berhasil Ditemukan</h4>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <h3 id="name"></h3>
                    <span id="email"></span>
                </div>
                <div class="modal-footer" style="text-align:center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
         </div>
    </div>
</section>
@endsection
@section('js')
<script>
   $(function () {
      $('#DataTable').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "iDisplayLength": 50,
        "searching": false,
        "lengthChange": false,
        "info": false
      });
   });
   // Select your input element.
   var number = document.getElementById('nominal');

   // Listen for input event on numInput.
   number.onkeydown = function(e) {
       if(!((e.keyCode > 95 && e.keyCode < 106)
         || (e.keyCode > 47 && e.keyCode < 58) 
         || e.keyCode == 8)) {
           return false;
       }
   }
   
$('#cek_nomor').on('click', function(){
  $('#cek_nomor').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
  $('#cek_nomor').attr('style', 'cursor:not-allowed;pointer-events: none;');
  var no_tujuan = $('input[name="no_tujuan"]').val();
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ url('/member/transfer-saldo/cek-nomor') }}",
        dataType: "json",
        type: "POST",
        data: {
            'no_tujuan': no_tujuan
        },
        success: function (response) {
            $('#cek_nomor').html("Cek Nomor");
            $('#cek_nomor').removeAttr('style');
            if ((response.errors)) {
                toastr.error("Nomor Handphone Tujuan tidak boleh kosong.");
            }else{
                if(response.name != null){
                    $('#name').text(response.name);
                    $('#email').text(response.email);
                    $('#myModal').modal({
                        show: true,
                        keyboard: false,
                        backdrop: 'static',
                      
                    })
                }else{
                    toastr.error("Nomor Handphone Tujuan tidak ditemukan, periksa kembali nomor handphone tujuan anda.");
                }
            }
        }
    });
});

   $(document).ready(function() {
    function autoMoneyFormat(b){
        var _minus = false;
        if (b<0) _minus = true;
        b = b.toString();
        b=b.replace(".","");
        b=b.replace("-","");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--){
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)){
        c = b.substr(i-1,1) + "." + c;
        } else {
        c = b.substr(i-1,1) + c;
        }
        }
        if (_minus) c = "-" + c ;
        return c;
    }

      function price_to_number(v){
      if(!v){return 0;}
          v=v.split('.').join('');
          v=v.split(',').join('');
      return Number(v.replace(/[^0-9.]/g, ""));
      }
      
      function number_to_price(v){
      if(v==0){return '0,00';}
          v=parseFloat(v);
          // v=v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.split('.').join('*').split(',').join('.').split('*').join(',');
      return v;
      }
      
      function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
      }

      $('#nominal').keyup(function(){
        var nominal=parseInt(price_to_number($('#nominal').val()));
        var autoMoney = autoMoneyFormat(nominal);
        $('#nominal').val(autoMoney);
    });
  });
</script>
@endsection