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
                     <div class="form-group{{ $errors->has('bank_id') ? ' has-error' : '' }}">
                        <label>Bank ID : </label>
                        <input type="text" class="form-control" name="bank_id" value="{{ old('bank_id') }}"  placeholder="Masukkan Bank ID">
                         {!! $errors->first('bank_id', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        <label>Logo / Gambar Bank : </label>
                        <input type="file" name="image" accept="image/*">
                         {!! $errors->first('image', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label>Status : </label>
                        <select class="form-control" name="status">
                            <option value="1"
                                @if(old('status') == '1')
                                selected
                                @endif
                                >Aktif</option>
                            <option value="0"
                                @if(old('status') == '0')
                                selected
                                @endif
                                >Tidak Aktif</option>
                        </select>
                         {!! $errors->first('status', '<p class="help-block"><small>:message</small></p>') !!}
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
                  </dl>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection