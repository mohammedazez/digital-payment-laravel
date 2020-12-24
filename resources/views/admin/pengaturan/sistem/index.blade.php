@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Setting <small>Sistem</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li class="active">Setting Sistem</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title">Setting Sistem</h3>
               </div>
               <form role="form" action="{{url('/admin/setting', $settings->id)}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('nama_sistem') ? ' has-error' : '' }}">
                        <label>Nama Sistem : </label>
                        <input type="text" class="form-control" name="nama_sistem" value="{{ $settings->nama_sistem }}"  placeholder="Masukkan Nama Sistem">
                        {!! $errors->first('nama_sistem', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('motto') ? ' has-error' : '' }}">
                        <label>Motto : </label>
                        <input type="text" class="form-control" name="motto" value="{{ $settings->motto }}"  placeholder="Masukkan Motto Sistem">
                        {!! $errors->first('motto', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label>Deskripsi : </label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Masukkan Deskripsi Sistem">{{$settings->description}}</textarea>
                        {!! $errors->first('description', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('pemilik') ? ' has-error' : '' }}">
                        <label>Nama Pemilik : </label>
                        <input type="text" class="form-control" name="pemilik" value="{{ $settings->pemilik }}"  placeholder="Masukkan Nama Pemilik Sistem">
                        {!! $errors->first('pemilik', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                        <label>Alamat : </label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan Alamat Kantor/Lokasi Usaha">{{ $settings->alamat }}</textarea>
                        {!! $errors->first('alamat', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Email Kontak : </label>
                        <input type="text" class="form-control" name="email" value="{{ $settings->email }}"  placeholder="Masukkan Email">
                        {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('hotline') ? ' has-error' : '' }}">
                        <label>Hotline/No Telepon : </label>
                        <input type="text" class="form-control" name="hotline" value="{{ $settings->hotline }}"  placeholder="Masukkan Hotline/Nomor Handphone kontak">
                        {!! $errors->first('hotline', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                        <label>Website : </label>
                        <input type="text" class="form-control" name="website" value="{{ $settings->website }}"  placeholder="Masukkan Website/Domain Sistem">
                        {!! $errors->first('website', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('facebook_url') ? ' has-error' : '' }}">
                        <label>Facebook URL : </label>
                        <input type="url" class="form-control" name="facebook_url" value="{{ $settings->facebook_url }}"  placeholder="">
                        {!! $errors->first('facebook_url', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('twitter_url') ? ' has-error' : '' }}">
                        <label>Twitter URL : </label>
                        <input type="url" class="form-control" name="twitter_url" value="{{ $settings->twitter_url }}"  placeholder="">
                        {!! $errors->first('twitter_url', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('instagram_url') ? ' has-error' : '' }}">
                        <label>Instagram URL : </label>
                        <input type="url" class="form-control" name="instagram_url" value="{{ $settings->instagram_url }}"  placeholder="">
                        {!! $errors->first('instagram_url', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('youtube_url') ? ' has-error' : '' }}">
                        <label>Youtube URL : </label>
                        <input type="url" class="form-control" name="youtube_url" value="{{ $settings->youtube_url }}"  placeholder="">
                        {!! $errors->first('youtube_url', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" class="submit btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>

</section>
@endsection