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
                     <div class="form-group{{ $errors->has('skin') ? ' has-error' : '' }}">
                        <label>Skin/Tema : </label>
                        <input type="text" class="form-control" name="skin" value="{{ $settings->skin }}"  placeholder="Masukkan Api Key Server">
                        {!! $errors->first('skin', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" class="submit btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-solid">
          <div class="box-body no-padding">
            <table id="layout-skins-list" class="table table-striped bring-up nth-2-center">
              <thead>
                <tr>
                  <th>Skin/Tema</th>
                  <th>Preview</th>
                  <th>Skin/Tema</th>
                  <th>Preview</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><code>skin-blue</code></td>
                  <td><a href="#" data-skin="skin-blue" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>
                  <td><code>skin-blue-light</code></td>
                  <td><a href="#" data-skin="skin-blue-light" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>
                </tr>
                <tr>
                  <td><code>skin-yellow</code></td>
                  <td><a href="#" data-skin="skin-yellow" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                  <td><code>skin-yellow-light</code></td>
                  <td><a href="#" data-skin="skin-yellow-light" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a></td>
                </tr>
                <tr>
                  <td><code>skin-green</code></td>
                  <td><a href="#" data-skin="skin-green" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a></td>
                  <td><code>skin-green-light</code></td>
                  <td><a href="#" data-skin="skin-green-light" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a></td>
                </tr>
                <tr>
                  <td><code>skin-purple</code></td>
                  <td><a href="#" data-skin="skin-purple" class="btn bg-purple btn-xs"><i class="fa fa-eye"></i></a></td>
                  <td><code>skin-purple-light</code></td>
                  <td><a href="#" data-skin="skin-purple-light" class="btn bg-purple btn-xs"><i class="fa fa-eye"></i></a></td>
                </tr>
                <tr>
                  <td><code>skin-red</code></td>
                  <td><a href="#" data-skin="skin-red" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i></a></td>
                  <td><code>skin-red-light</code></td>
                  <td><a href="#" data-skin="skin-red-light" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i></a></td>
                </tr>
                <tr>
                  <td><code>skin-black</code></td>
                  <td><a href="#" data-skin="skin-black" class="btn bg-black btn-xs"><i class="fa fa-eye"></i></a></td>
                  <td><code>skin-black-light</code></td>
                  <td><a href="#" data-skin="skin-black-light" class="btn bg-black btn-xs"><i class="fa fa-eye"></i></a></td>
                </tr>
              </tbody>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection