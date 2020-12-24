@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Setting API & Cekmutasi<small>Sistem</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li class="active">Setting API & Cekmutasi Sistem</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title">Setting API Ke Tripay Sistem</h3> 
                 <br/>
                 <p style="font-size:12px;"><i>Wajib Isi untuk PIN User, Endpoint dan Api key, </i> <a href="https://tripay.co.id" style="font-weight: bold;">Tripay.co.id</a></p>
               
              </div>
               <form role="form" action="{{url('/admin/api-cekmutasi', $settings->id)}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('pin_tripay') ? ' has-error' : '' }}">
                        <label>PIN User <small>(<a href="https://tripay.co.id" style="font-weight: bold;">tripay.co.id</a>)</small> : </label>
                        <div class="input-group">
                           <input type="password" id="pin_tripay" class="form-control" name="pin_tripay" value="{{ $settings->pin_tripay }}"  placeholder="Masukkan PIN User">
                           <div class="input-group-addon"><a href="Javascript:;" class="trigger-show-pin-tripay"><i class="fa fa-eye-slash"></i></a></div>
                        </div>
                        {!! $errors->first('pin_tripay', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('endpoint_tripay') ? ' has-error' : '' }}">
                        <label>Endpoint Tripay <small>(<a href="https://tripay.co.id" style="font-weight: bold;">tripay.co.id</a>)</small> : </label>
                        <div class="input-group">
                           <input type="password" id="endpoint_tripay" class="form-control" name="endpoint_tripay" value="{{ $settings->endpoint_tripay }}"  placeholder="Masukkan URL Endpoint Server">
                           <div class="input-group-addon"><a href="Javascript:;" class="trigger-show-endpoint-tripay"><i class="fa fa-eye-slash"></i></a></div>
                        </div>
                        {!! $errors->first('endpoint_tripay', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('key_tripay') ? ' has-error' : '' }}">
                        <label>API Key Tripay <small>(<a href="https://tripay.co.id" style="font-weight: bold;">tripay.co.id</a>)</small> : </label>
                        <div class="input-group">
                           <input type="password" id="key_tripay" class="form-control" name="key_tripay" value="{{ $settings->key_tripay }}"  placeholder="Masukkan Api Key Server">
                           <div class="input-group-addon"><a href="Javascript:;" class="trigger-show-key-tripay"><i class="fa fa-eye-slash"></i></a></div>
                        </div>
                        {!! $errors->first('key_tripay', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" name="simpan-tripay" class="btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title">Setting API Ke Cekmutasi Sistem</h3>  
                 <br/>
                 <p style="font-size:12px;"><i>Kosongkan semua isian dan simpan jika tidak ingin menggunakan layanan</i> <a href="https://cekmutasi.co.id" style="font-weight: bold;">cekmutasi.co.id</a></p>
               
              </div>
               <form role="form" action="{{url('/admin/api-cekmutasi', $cekmutasi->id)}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('api_url') ? ' has-error' : '' }}">
                        <label>API URL <small>(<a href="https://cekmutasi.co.id" style="font-weight: bold;">cekmutasi.co.id</a>)</small> : </label>
                        <div class="input-group">
                           <input type="password" id="api_url" class="form-control" name="api_url" value="{{ $cekmutasi->api_url }}"  placeholder="Masukkan API URL">
                           <div class="input-group-addon"><a href="Javascript:;" class="trigger-show-api-url"><i class="fa fa-eye-slash"></i></a></div>
                        </div>
                        {!! $errors->first('api_url', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }}">
                        <label>API KEY <small>(<a href="https://cekmutasi.co.id" style="font-weight: bold;">cekmutasi.co.id</a>)</small> : </label>
                        <div class="input-group">
                           <input type="password" id="api_key" class="form-control" name="api_key" value="{{ $cekmutasi->api_key }}"  placeholder="Masukkan API KEY">
                           <div class="input-group-addon"><a href="Javascript:;" class="trigger-show-api-key"><i class="fa fa-eye-slash"></i></a></div>
                        </div>
                        {!! $errors->first('api_key', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('api_signature') ? ' has-error' : '' }}">
                        <label>API SIGNATURE <small>(<a href="https://cekmutasi.co.id" style="font-weight: bold;">cekmutasi.co.id</a>)</small> : </label>
                        <div class="input-group">
                           <input type="password" id="api_signature" class="form-control" name="api_signature" value="{{ $cekmutasi->api_signature }}"  placeholder="Masukkan API SIGNATURE">
                           <div class="input-group-addon"><a href="Javascript:;" class="trigger-show-api-signature"><i class="fa fa-eye-slash"></i></a></div>
                        </div>
                        {!! $errors->first('api_signature', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" name="simpan-cekmutasi" class="btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script>

$('.trigger-show-pin-tripay').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#pin_tripay').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#pin_tripay').attr('type','text');
   }
});
$('.trigger-show-endpoint-tripay').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#endpoint_tripay').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#endpoint_tripay').attr('type','text');
   }
});
$('.trigger-show-key-tripay').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#key_tripay').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#key_tripay').attr('type','text');
   }
});


$('.trigger-show-api-url').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#api_url').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#api_url').attr('type','text');
   }
});
$('.trigger-show-api-key').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#api_key').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#api_key').attr('type','text');
   }
});
$('.trigger-show-api-signature').on('click',function(){
   var icon=$(this).children('.fa');
   if(icon.hasClass('fa-eye')){
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
      $('#api_signature').attr('type','password');
   }else{
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
      $('#api_signature').attr('type','text');
   }
});
</script>
@endsection