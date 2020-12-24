@extends('layouts.member')

@section('content')
<section class="content-header">
	<h1>Validation <small>Users</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Profile</a></li>
      <li><a href="{{route('bank.index')}}" class="btn-loading">Validation Users</a></li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Validasi</h3>
               </div>
               @if(!$validation)
                   <form id="reset_upload" role="form" action="{{route('validation.user.store')}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                   @csrf
                      <div class="box-body">
                        @if(Session::has('alert-success'))
                            <div class="alert alert-success alert-dismissable">
                               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                               <h4><i class="fa fa-check"></i>Berhasil</h4>
                               <p>{!! Session::get('alert-success') !!}</p>
                            </div>
                          @endif
                         @if(Session::has('alert-error'))
                            <div class="alert alert-danger alert-dismissable">
                               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                               <h4><i class="fa fa-check"></i>Error</h4>
                               <p>{!! Session::get('alert-error') !!}</p>
                            </div>
                          @endif
                         <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label>Nama Anda : </label>
                            <input type="text" class="form-control" name="nama" value="{{ $user->name }}"  placeholder="Masukkan Nama Anda" disabled="">
                            {!! $errors->first('nama', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                         <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <img id="showKK" style="max-width:400px;max-height:400px;float:left;" />
                                </div>
                            </div>
                          </div>
                         
                          <div class="form-group{{ $errors->has('kk') ? ' has-error' : '' }}">
                            <label>Foto KK Hanya Untuk Agen dan Enterprise (opsional): </label>
                            <input type="file" name="kk" id="kk" accept="image/*" style="border: 1px solid #ddd;padding: 6px;width: 100%;">
                             {!! $errors->first('kk', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                        
                          <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <img id="showKTP" style="max-width:400px;max-height:400px;float:left;" />
                                </div>
                            </div>
                          </div>
                          <div class="form-group{{ $errors->has('ktp') ? ' has-error' : '' }}">
                            <label>Foto KTP : </label>
                            <input type="file" name="ktp" id="ktp" accept="image/*" style="border: 1px solid #ddd;padding: 6px;width: 100%;">
                             {!! $errors->first('ktp', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                         <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <img id="showPengguna" style="max-width:400px;max-height:400px;float:left;" />
                                </div>
                            </div>
                          </div>
                         <div class="form-group{{ $errors->has('img_pengguna') ? ' has-error' : '' }}">
                            <label>Foto Pengguna : </label>
                            <input type="file" name="img_pengguna" id="img_pengguna" accept="image/*" style="border: 1px solid #ddd;padding: 6px;width: 100%;">
                             {!! $errors->first('img_pengguna', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                            <div class="col-md-12">
                               <div class="form-group">
                                    <img id="showgambar" style="max-width:400px;max-height:400px;float:left;" />
                                </div>
                            </div>
                         <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label>Foto selfie memegang KTP dan tanda tangan di atas kertas putih dengan Bertuliskan Nomor HP Akun : </label>
                            <input type="file" name="image" id="image" accept="image/*" style="border: 1px solid #ddd;padding: 6px;width: 100%;">
                             {!! $errors->first('image', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                            <div class="col-md-12">
                               <div class="form-group">
                                    <img id="showtabungan" style="max-width:400px;max-height:400px;float:left;" />
                                </div>
                            </div>
                         <div class="form-group{{ $errors->has('tabungan') ? ' has-error' : '' }}">
                            <label>Foto Buku Tabungan (optional) : </label>
                            <input type="file" name="tabungan" id="tabungan" accept="image/*" style="border: 1px solid #ddd;padding: 6px;width: 100%;">
                             {!! $errors->first('tabungan', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                      </div>
    
                      <div class="box-footer">
                         <button type="submit" class="submit btn btn-primary">Submit</button>
                      </div>
                   </form>
                @elseif($validation->status == 0)
                    <center>
                        <h3>Validasi Akun anda sedang dalam proses verifikasi</h3>
                    </center>
                    <br/><br/>
                @else
                    <center>
                        <img src="{{ asset('/img/verified-member.png') }}" style="max-width:150px"/>
                        <h3>Akun Anda sudah diverifikasi</h3>
                    </center>
                    <br/><br/>
                @endif
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
               <div class="box-body" align="left">
                  <p><b>Cara :</b>
                    <br/>1. Silahkan Upload Foto Selfi anda di bidang upload <b>"Foto Selfie"</b>.
                    <br/>2. Silahkan Upload Foto Selfie anda sambil memegang kertas bertuliskan nomor HP akun di bidang upload <b>"Foto Selfie Dengan Memegang Kertas Bertuliskan Nomor HP Akun"</b>.
                    <br/>3. Silahkan Upload Foto Buku Tabungan anda yang memperlihatkan nama dan alamat di bidang upload <b>"Foto Buku Tabungan"</b>.
                    <br/>4. Upload validasi hanya bisa dilakukan sekali maka teliti dulu sebelum upload, jika ingin merubah ulang silahkan hubungi admin.
                  </p>
                  <p><b>Format :</b>
                    <br/>1. Format Foto JPEG, JPG, PNG.
                    <br/>2. MAX SIZE Foto 5MB (5120 kb).
                  </p>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script type="text/javascript">

$("#reset").click(function(){
    $('#showKTP').attr('src', '');
    $('#showgambar').attr('src', '');
    $('#showtabungan').attr('src', '');
});

    function showKTP(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showKTP').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showgambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function showTabungan(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showtabungan').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function showKK(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            
            reader.onload = function(e){
                $('#showKK').attr('src',e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    function showPengguna(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            
            reader.onload = function(e){
                $('#showPengguna').attr('src',e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#ktp").change(function () {
        showKTP(this);
    });

    $("#image").change(function () {
        readURL(this);
    });
    
    $("#tabungan").change(function () {
        showTabungan(this);
    });
    $('#kk').change(function(){
        showKK(this);
    })
    $('#img_pengguna').change(function(){
        showPengguna(this);
    })

</script>

@endsection