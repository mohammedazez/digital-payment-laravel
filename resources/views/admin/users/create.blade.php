@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Data <small>Users</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('users.index')}}" class="btn-loading"> Users</a></li>
    	<li class="active">Tambah User</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('users.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah User</h3>
               </div>
               <form role="form" action="{{route('users.store')}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>Nama Lengkap : </label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap">
                        {!! $errors->first('name', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label>Nomor Handphone :</label>
                        <input type="text" name="phone" class="form-control" placeholder="Masukkan Nomor Handphone">
                        {!! $errors->first('phone', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Alamat Email :</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email Aktif">
                        {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        <label>Kota Sekarang :</label>
                        <input type="text" name="city" class="form-control" placeholder="Masukkan Kota Sekarang">
                        {!! $errors->first('city', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>Kata Sandi</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi ">
                        {!! $errors->first('password', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('saldo') ? ' has-error' : '' }}">
                        <label>Saldo</label>
                        <div class="input-group">
                            <div class="input-group-addon">Rp. </div>
                            <input type="text" name="saldo" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="Contoh 100.000" value="0" >
                        </div>
                        {!! $errors->first('saldo', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label>Hak Akses</label>
                        <select name="role" class="form-control">
                            <option value="" disabled>-- Pilih Hak Akses --</option>
                            @foreach($roles as $data)
                            <option value="{{$data->name}}">{{$data->display_name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('role', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>
                  <div class="box-footer">
                     <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
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
                     <dt>Nama Lengkap</dt>
                     <dd style="font-size: 12px;">Isi dengan Nama Lengkap User (bukan nama samaran)</dd>
                     <dt>Nomor Handphone</dt>
                     <dd style="font-size: 12px;">Isi dengan Nomor Handphone Aktif</dd>
                     <dt>Alamat Email</dt>
                     <dd style="font-size: 12px;">Isi dengan Alamat Email Aktif (tidak boleh ada email yang sama dalam sistem)</dd>
                     <dt>Kata Sandi</dt>
                     <dd style="font-size: 12px;">Isi dengan Kata Sandi minimal 6 digit gabungan karakter, angka dan simbol</dd>
                     <dt>Saldo</dt>
                     <dd style="font-size: 12px;">Isi dengan Jumlah Saldo yang diminta, saldo untuk member baru tanpa permintaan adalah Rp 0,-</dd>
                     <dt>Hak Akses</dt>
                     <dd style="font-size: 12px;">Pilih Hak Akses untuk sistem</dd>
                  </dl>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection