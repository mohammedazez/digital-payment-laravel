@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Setting <small>Keamanan</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li class="active">Setting Keamanan</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title">Setting Keamanan</h3>
               </div>
               <form role="form" action="{{ url('/admin/setting/security') }}" method="post">
                @csrf
                  <div class="box-body">
                    <div class="form-group{{ $errors->has('force_verification') ? ' has-error' : '' }}">
                        <label>Wajibkan Verifikasi Akun (Disarankan) : </label>
                        <select name="force_verification" id="force_verification" class="form-control">
                            <option value="0" {{ $settings->force_verification == 0 ? 'selected' : '' }}>TIDAK</option>
                            <option value="1" {{ $settings->force_verification == 1 ? 'selected' : '' }}>YA</option>
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('prevent_multilogin') ? ' has-error' : '' }}">
                        <label>Multi Login (login bersamaan di banyak perangkat) : </label>
                        <select name="prevent_multilogin" id="prevent_multilogin" class="form-control">
                            <option value="0" {{ $settings->prevent_multilogin == 0 ? 'selected' : '' }}>BOLEH</option>
                            <option value="1" {{ $settings->prevent_multilogin == 1 ? 'selected' : '' }}>TIDAK BOLEH</option>
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('max_daily_deposit') ? ' has-error' : '' }}">
                        <label>Batas Request Deposit Harian Personal(0 = unlimited) : </label>
                        <input type="number" id="max_daily_deposit_personal" class="form-control" name="max_daily_deposit_personal" value="{{ $settings->max_daily_deposit_personal }}">
                    </div>
                    <div class="form-group{{ $errors->has('max_daily_deposit') ? ' has-error' : '' }}">
                        <label>Batas Request Deposit Harian Agen(0 = unlimited) : </label>
                        <input type="number" id="max_daily_deposit" class="form-control" name="max_daily_deposit_agen" value="{{ $settings->max_daily_deposit_agen }}">
                    </div>
                    <div class="form-group{{ $errors->has('max_daily_deposit') ? ' has-error' : '' }}">
                        <label>Batas Request Deposit Harian Enterprise(0 = unlimited) : </label>
                        <input type="number" id="max_daily_deposit" class="form-control" name="max_daily_deposit_enterprise" value="{{ $settings->max_daily_deposit_enterprise }}">
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