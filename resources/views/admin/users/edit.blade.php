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
               <form role="form" action="{{route('users.update', $users->id)}}" method="post">
               <input name="_method" type="hidden" value="PATCH">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group hidden">
                        <label>ID : </label>
                        <input type="text" name="id" class="form-control" value="{{$users->id ?? old('id')}}">
                     </div>
                     <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>Nama Lengkap : </label>
                        <input type="text" name="name" class="form-control" value="{{$users->name ?? old('name')}}" placeholder="Masukkan Nama Lengkap">
                        {!! $errors->first('name', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label>Nomor Handphone :</label>
                        <input type="text" name="phone" class="form-control" value="{{$users->phone ?? old('phone')}}"  placeholder="Masukkan Nomor Handphone">
                        {!! $errors->first('phone', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Alamat Email :</label>
                        <input type="email" name="email" class="form-control" value="{{$users->email ?? old('email')}}" placeholder="Masukkan Email Aktif" readonly>
                        {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                        <label>Kota Sekarang :</label>
                        <input type="text" name="city" class="form-control" value="{{$users->city ?? old('city')}}" placeholder="Masukkan Kota Sekarang">
                        {!! $errors->first('city', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     
                     <label>PIN :</label>
                    <div class="input-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                      <input type="text" name="pin" class="form-control" value="{{$users->pin ?? old('pin')}}" placeholder="Generate Pin" disabled>
                      <span class="input-group-btn">
                        <button class="btn btn-warning" id="generate-pin" type="button"><i class="fa fa-refresh"></i></button>
                      </span>
                      {!! $errors->first('pin', '<p class="help-block"><small>:message</small></p>') !!}
                    </div><!-- /input-group -->
                    <br>

                     <div class="form-group{{ $errors->has('saldo') ? ' has-error' : '' }}">
                        <label>Saldo</label>
                        <div class="input-group">
                            <div class="input-group-addon">Rp. </div>
                            <input type="text" name="saldo" class="form-control" value="{{number_format($users->saldo, 0, '.', '.')}}" readonly>
                        </div>
                        {!! $errors->first('saldo', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                        <label>Password Baru (Hanya isi untuk mengubah password lama)</label>
                        <input type="text" name="new_password" class="form-control" value="" placeholder="">
                        {!! $errors->first('new_password', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label>Hak Akses</label>
                        <select name="role" class="form-control">
                            <option value="" disabled>-- Pilih Hak Akses --</option>
                            @foreach($roles as $data)
                            <option value="{{$data->name}}" {{ ($users->roles->first()->id == $data->id ? "selected":"") }}>{{$data->display_name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('role', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="" disabled>-- Pilih Hak Akses --</option>
                            <option value="1" {{ ($users->status == 1 ? "selected":"") }}>Aktif</option>
                            <option value="0" {{ ($users->status == 0 ? "selected":"") }}>Tidak Aktif</option>
                        </select>
                        {!! $errors->first('status', '<p class="help-block"><small>:message</small></p>') !!}
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
                     <dt>Saldo</dt>
                     <dd style="font-size: 12px;">Isi dengan Jumlah Saldo yang diminta, saldo untuk member baru tanpa permintaan adalah Rp 0,-</dd>
                     <dt>Hak Akses</dt>
                     <dd style="font-size: 12px;">Pilih Hak Akses untuk sistem</dd>
                     <dt>Status</dt>
                     <dd style="font-size: 12px;">Status User saat ini, apakah aktif atau tidak aktif</dd>
                  </dl>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script type="text/javascript">
$('#generate-pin').on('click', generatePin);

function generatePin()
{
    var id=$('input[name=id]').val(); 
    $('input[name=pin]').val('Generate PIN...');
    document.getElementById("generate-pin").disabled = true;
    $('.fa-refresh').removeClass('fa-refresh').addClass('fa-refresh fa-spin');
    $.ajax({
        url: "{{route('get.usersedit.generate.pin')}}",
        type: 'POST',
        data: {_token:"{{ csrf_token() }}",id:id},
        success: function(response){
            $('input[name=pin]').val(response);
            $('.fa-spin').removeClass('fa-spin');
            document.getElementById("generate-pin").disabled = false;
        }
    });
}

</script>
@endsection