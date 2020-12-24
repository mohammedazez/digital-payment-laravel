@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-user"></i>
        <h3 class="box-title">Ubah Biodata</h3>
    </div>
    <div class="box-body">
        <form role="form" class="form-horizontal" action="{{url('/member/biodata')}}" method="post">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Nama : </label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" placeholder="Masukkan Nama Lengkap">
                        {!! $errors->first('name', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Alamat Email : </label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" placeholder="Masukkan Alamat Email">
                        {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Nomor Handphone : </label>
                    <div class="col-sm-9">
                        <input type="number" id="number" min="0" name="phone" class="form-control" value="{{Auth::user()->phone}}" placeholder="Masukkan Nomor Handphone" disabled>
                        {!! $errors->first('phone', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Kota Sekarang : </label>
                    <div class="col-sm-9">
                        <input type="text" name="city" class="form-control" value="{{Auth::user()->city}}" placeholder="Masukkan Kota Sekarang">
                        {!! $errors->first('city', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div> 
                {{-- <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">API Key : </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                           <input type="password" id="api_key" class="form-control" name="api_key" value="{{ Auth::user()->api_key }}"  placeholder="Generate API Key" readonly>
                           <div class="input-group-addon">
                              <a href="Javascript:;" class="trigger-show-pwd-desktop"><i id="icon" class="fa fa-eye-slash"></i></a>
                           </div>
                           <div class="input-group-addon">
                              <a href="Javascript:;" id="generate" title="Generate API Key"><i class="fa fa-refresh"></i></a>
                           </div>
                        </div>
                        {!! $errors->first('api_key', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div> --}}
                <div class="form-group{{ $errors->has('buyer') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">SMS Buyer <i class="fa fa-question-circle" style="margin-left:5px;"></i> : </label>
                    <div class="col-sm-9">
                        <textarea onKeyUp="countChar(this)" maxlength="140" class="form-control" rows="3" name="buyer" placeholder="Isi SMS Buyer">{{ Auth::user()->sms_buyer }}</textarea>
                        <small>Sisa Karakter : <span id="charNum">140</span>, Panjang : <span id="charLen">0</span></small>
                        {!! $errors->first('buyer', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="submit btn  btn-primary btn-block">&nbsp;&nbsp;Update&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="box box-solid box-penjelasan">
    <div class="box-header with-border">
        <i class="fa fa-text-width"></i>
        <h3 class="box-title">Tentang SMS Buyer</h3>
        <div class="box-tools pull-right box-minus" style="display:none;">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <dl>
            <dt>Apa ini?</dt>
            <dd>Ini adalah sms yang akan dikirim ke pembeli Anda, ketika pengisian sukses.</dd>
            <dd>Jika tidak Anda isi, maka sms buyer ini tidak berjalan.</dd>

            <dt>Panjang</dt>
            <dd>Panjang karakter maksimal 140 karakter</dd>           

            <dt>Isi SMS Buyer Standar</dt>
            <dd>Nomor Anda telah di Top-Up oleh {{$GeneralSettings->nama_sistem}}. Sedia pulsa All Operator, Voucher Game, PLN, Dll.</dd>

            <dt>Ketentuan</dt>
            <dd>
                <ol>
                   <li>Biaya Rp {{ number_format($sms_setting['sms_buyer_cost'], 0) }}/SMS langsung diambil dari saldo anda.</li>
                   <li>Karena encoding dari URL maka 2 simbol berikut ini akan hilang saat anda mengirim SMS yaitu simbol + dan \ ada 2 simbol lagi, yaitu # dan &, jika 2 simbol ini ada maka karakter apapun yang ditulis sesudahnya akan hilang. Oleh karena itu, hindari penggunaan 4 simbol tersebut agar pesan anda bisa sampai dengan baik.</li>
                   <li>Dilarang promosi selain untuk kepentingan bisnis pulsa {{$GeneralSettings->nama_sistem}} .</li>
                   <li>Dilarang menggunakan kata-kata kasar, tidak sopan, dan SARA .</li>  
                   <li>Kosongkan isi sms buyer untuk mematikan fitur ini.</li>
                </ol>
            </dd>
        </dl>
    </div>
</div>
@endsection
@section('js')
<script>

   // Select your input element.
   var number = document.getElementById('number');

   // Listen for input event on numInput.
   number.onkeydown = function(e) {
       if(!((e.keyCode > 95 && e.keyCode < 106)
         || (e.keyCode > 47 && e.keyCode < 58) 
         || e.keyCode == 8)) {
           return false;
       }
   }
$('.trigger-show-pwd-desktop').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#api_key').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#api_key').attr('type','text');
   }
});

$('#generate').on('click', function(e){
   $('.fa-refresh').addClass(' faa-spin animated');
   //ajax
   $.get('/member/apikey/generate', function(data){
      var icon=$(this).children('.fa');
      $('#icon').removeClass('fa-eye-slash').addClass('fa-eye');
      $('#api_key').attr('type','text');
      $('.fa-refresh').removeClass(' faa-spin animated');
      $('#api_key').val(data);
   });
});
function countChar(val){
    var len = val.value.length;
    if (len > 140) {
        val.value = val.value.substring(0, 140);
    }else {
        $('#charNum').text(140 - len);
        $('#charLen').text(len);
    }
};
</script>
@endsection