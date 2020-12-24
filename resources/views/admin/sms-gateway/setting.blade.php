@extends('layouts.admin')

@section('content')
<section class="content-header">
   <h1>SMS Gateway <small>Pengaturan</small></h1>
</section>
<section class="content">
  <div class="row">
     <div class="col-md-6">
        <div class="box box-green">
           <div class="box-header">
             <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Ubah Pengaturan</h3>
           </div>
           <form role="form" action="" method="post" accept-charset="UTF-8">
           {{ csrf_field() }}
              <div class="box-body">
                  
                  <div class="form-group{{ $errors->has('enable') ? ' has-error' : '' }}">
                    <label>Status : </label>
                    <select class="form-control" name="enable">
                        <option value="1"
                            @if($setting['enable'] == '1')
                            selected
                            @endif
                            >Aktif</option>
                        <option value="0"
                            @if($setting['enable'] == '0')
                            selected
                            @endif
                            >Tidak Aktif</option>
                    </select>
                     {!! $errors->first('enable', '<p class="help-block"><small>:message</small></p>') !!}
                 </div>
                  
                 <div class="form-group{{ $errors->has('zenziva_userkey') ? ' has-error' : '' }}">
                    <label>Zenziva UserKey : </label>
                    <input type="text" class="form-control" name="zenziva_userkey" value="{{ old('zenziva_userkey') ?: $setting['zenziva_userkey'] }}">
                    {!! $errors->first('zenziva_userkey', '<p class="help-block"><small>:message</small></p>') !!}
                 </div>
                 
                 <div class="form-group{{ $errors->has('zenziva_passkey') ? ' has-error' : '' }}">
                    <label>Zenziva PassKey : </label>
                    <input type="text" class="form-control" name="zenziva_passkey" value="{{ old('zenziva_passkey') ?: $setting['zenziva_passkey'] }}">
                    {!! $errors->first('zenziva_passkey', '<p class="help-block"><small>:message</small></p>') !!}
                 </div>
                 
                 <div class="form-group{{ $errors->has('enable_sms_buyer') ? ' has-error' : '' }}">
                    <label>Aktifkan SMS Buyer : </label>
                    <select class="form-control" name="enable_sms_buyer">
                        <option value="1"
                            @if($setting['enable_sms_buyer'] == '1')
                            selected
                            @endif
                            >Aktif</option>
                        <option value="0"
                            @if($setting['enable_sms_buyer'] == '0')
                            selected
                            @endif
                            >Tidak Aktif</option>
                    </select>
                     {!! $errors->first('enable_sms_buyer', '<p class="help-block"><small>:message</small></p>') !!}
                 </div>
                 
                 <div class="form-group{{ $errors->has('sms_buyer_cost') ? ' has-error' : '' }}">
                    <label>Biaya SMS Buyer (per SMS) : </label>
                    <input type="number" class="form-control" name="sms_buyer_cost" value="{{ old('sms_buyer_cost') ?: $setting['sms_buyer_cost'] }}">
                    {!! $errors->first('sms_buyer_cost', '<p class="help-block"><small>:message</small></p>') !!}
                 </div>
                 
                 <div class="form-group{{ $errors->has('log_db') ? ' has-error' : '' }}">
                    <label>Simpan Log ke Database : </label>
                    <select class="form-control" name="log_db">
                        <option value="1"
                            @if($setting['log_db'] == '1')
                            selected
                            @endif
                            >YA</option>
                        <option value="0"
                            @if($setting['log_db'] == '0')
                            selected
                            @endif
                            >TIDAK</option>
                    </select>
                     {!! $errors->first('log_db', '<p class="help-block"><small>:message</small></p>') !!}
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
              <ol>
                  <li><b>User Key & Pass Key</b> lihat di <a target="_blank" href="https://reguler.zenziva.net/apps/api.php" class="custom__text-green">https://reguler.zenziva.net/apps/api.php</a></li>
              </ol>
           </div><!-- /.box-body -->
        </div><!-- /.box -->
     </div>
  </div>
</section>
@endsection