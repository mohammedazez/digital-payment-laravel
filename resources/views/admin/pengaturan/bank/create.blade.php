@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Produk <small>Kategori</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="{{route('bank.index')}}" class="btn-loading">Data Bank</a></li>
      <li class="active">Tambah Bank</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-primary">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah Bank</h3>
               </div>
               <form role="form" action="{{route('bank.store')}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('nama_bank') ? ' has-error' : '' }}">
                        <label>Nama Bank : </label>
                        <input type="text" class="form-control" name="nama_bank" value="{{ old('nama_bank') }}"  placeholder="Masukkan Nama Bank">
                        {!! $errors->first('nama_bank', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('atas_nama') ? ' has-error' : '' }}">
                        <label>Nama Pemilik : </label>
                        <input type="text" class="form-control" name="atas_nama" value="{{ old('atas_nama') }}"  placeholder="Masukkan Nama Pemilik Rekening">
                         {!! $errors->first('atas_nama', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('no_rek') ? ' has-error' : '' }}">
                        <label>Nomor Rekening : </label>
                        <input type="text" class="form-control" name="no_rek" value="{{ old('no_rek') }}"  placeholder="Masukkan Nomor Rekening Rekening">
                         {!! $errors->first('no_rek', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <!--<div class="form-group{{ $errors->has('bank_id') ? ' has-error' : '' }}">-->
                     <!--   <label>Bank ID : </label>-->
                     <!--   <input type="text" class="form-control" name="bank_id" value="{{ old('bank_id') }}"  placeholder="Masukkan Bank ID">-->
                     <!--    {!! $errors->first('bank_id', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                      <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        <label>Logo / Gambar Bank : </label>
                        <input type="file" name="image" accept="image/*">
                         {!! $errors->first('image', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                      <div class="form-group{{ $errors->has('code_bank_integrasi') ? ' has-error' : '' }}">
                        <label>Kode Bank</label>
                        <input type="text" class="form-control" placeholder="Masukkan Kode bank" name="code_bank_integrasi" >
                         {!! $errors->first('code_bank_integrasi', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('nama_provider') ? ' has-error' : '' }}" id="provider">
                        <label>Provider : </label>
                        <select name="provider"  class="form-control">
                           @foreach($provider as $item)
                           <option value="{{$item->id}}">{{$item->name}}</option>
                           @endforeach
                        </select>
                        <!--<button type="button" id="btn-tambah" onclick="tambah()" class=" btn btn-primary">Tambah provider +</button>-->
                     </div>
                     <div class="form-group{{ $errors->has('nama_provider') ? ' has-error' : '' }}" id="provider">
                        <label>Bank Kategori : </label>
                        <select name="bank_kategori_id"  class="form-control">
                           @foreach($bank_kategori as $item)
                           <option value="{{$item->id}}">{{$item->paymethod}}</option>
                           @endforeach
                        </select>
                        <!--<button type="button" id="btn-tambah" onclick="tambah()" class=" btn btn-primary">Tambah provider +</button>-->
                     </div>
                     <!-- <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} none" id="logo">-->
                     <!--   <label>Logo / Gambar Provider : </label>-->
                     <!--   <input type="file" name="logo" accept="image/*">-->
                     <!--    {!! $errors->first('logo', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{$errors->has('tambah_provider') ? 'has-error' : ''}} none" id="tambah_provider">-->
                     <!--   <label for="tambah_provider">Provider : </label>-->
                     <!--   <input type="text" class="form-control" name="tambah_provider"  placeholder="Tambah Provider">-->
                     <!--   {!! $errors->first('tambah_provider', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{ $errors->has('merchant_code') ? ' has-error' : '' }} none" id="merchant_code">-->
                     <!--   <label>Merchant Code : </label>-->
                     <!--   <input type="text" class="form-control" name="merchant_code" value="{{ old('merchant_code') }}"  placeholder="Masukkan Merchant Code">-->
                     <!--    {!! $errors->first('merchant_code', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }} none" id="api_key">-->
                     <!--   <label>Api Key : </label>-->
                     <!--   <input type="text" class="form-control" name="api_key" value="{{ old('api_key') }}"  placeholder="Masukkan Api Key">-->
                     <!--    {!! $errors->first('api_key', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{ $errors->has('api_signature') ? ' has-error' : '' }} none" id="api_signature">-->
                     <!--   <label>Api Signature : </label>-->
                     <!--   <input type="text" class="form-control" name="api_signature" value="{{ old('Api Signature') }}"  placeholder="Masukkan Api Signature">-->
                     <!--    {!! $errors->first('api_signature', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{ $errors->has('private_key') ? ' has-error' : '' }} none" id="private_key">-->
                     <!--   <label>Private Key : </label>-->
                     <!--   <input type="text" class="form-control" name="private_key" value="{{ old('private_key') }}"  placeholder="Masukkan Private Key">-->
                     <!--    {!! $errors->first('private_key', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{ $errors->has('ipn_secret') ? ' has-error' : '' }} none" id="ipn_secret">-->
                     <!--   <label>IPN Secret : </label>-->
                     <!--   <input type="text" class="form-control" name="ipn_secret" value="{{ old('ipn_secret') }}"  placeholder="Masukkan IPN Secret">-->
                     <!--    {!! $errors->first('ipn_secret', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                     <!--<div class="form-group{{ $errors->has('public_key') ? ' has-error' : '' }} none" id="public_key">-->
                     <!--   <label>Public Key : </label>-->
                     <!--   <input type="text" class="form-control" name="public_key" value="{{ old('public_key') }}"  placeholder="Masukkan Public Key">-->
                     <!--    {!! $errors->first('public_key', '<p class="help-block"><small>:message</small></p>') !!}-->
                     <!--</div>-->
                    
                    
                     
                     <button type="button" id="btn-batal" onclick="batal()" class=" btn btn-primary none">Batal Tambah</button>
                  </div>
                
                  <div class="box-footer">
                     
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" class="submit btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
               <div class="box-header with-border">
                    <i class="fa fa-text-width"></i>
                    <h3 class="box-title">Penjelasan Form</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
               </div><!-- /.box-header -->
               <div class="box-body">
                  <dl>
                     <dt>Nama Bank</dt>
                     <dd style="font-size: 12px;">Isi dengan Nama Bank (contoh : BRI, BNI, BCA, Dll)</dd>
                     <dt>Nama Pemilik</dt>
                     <dd style="font-size: 12px;">Isi dengan Nama Pemilik Rekening yang tercantum dalam buku rekening.</dd>
                     <dt>Nomor Rekening</dt>
                     <dd style="font-size: 12px;">Isi dengan Nomor Rekening Bank.</dd>
                     <dt>Logo / Gambar Bank</dt>
                     <dd style="font-size: 12px;">Isi dengan Logo / Gambar dari Bank</dd>
                     <dt>Note!!:</dt>
                     <dt>Ketika Menambahkan provider pastikan untuk menambahkan logo juga</dt>
                     <dd>Untuk Kolom Inputan seperti Api Key, Api Signature, Private Key, IPN Secret, Public Key optional isi sesuai dengan kebutuhan integrasi dari provider</dd>
                  </dl>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script>
   function tambah(){
      $('#provider').addClass('none');
      $('#tambah_provider').removeClass('none');
      $('#logo_provider').addClass('none');
      $('#btn-tambah').addClass('none');
      $('#btn-batal').removeClass('none');
      $('#logo').removeClass('none');
      $('#api_key').removeClass('none');
      $('#api_signature').removeClass('none');
      $('#private_key').removeClass('none');
      $('#public_key').removeClass('none');
      $('#ipn_secret').removeClass('none');
      $('#merchant_code').removeClass('none');
      
   }
   function batal(){
      $('#provider').removeClass('none');
      $('#tambah_provider').addClass('none');
      $('#logo_provider').removeClass('none');
      $('#btn-tambah').removeClass('none');
      $('#btn-batal').addClass('none');
      $('#logo').addClass('none');
      $('#api_key').addClass('none');
      $('#api_signature').addClass('none');
      $('#private_key').addClass('none');
      $('#public_key').addClass('none');
      $('#ipn_secret').addClass('none');
      $('#merchant_code').addClass('none');
   }
</script>