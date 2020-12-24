@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-unlock"></i>
        <h3 class="box-title">Ubah Kata Sandi</h3>
    </div>
    <div class="box-body">
        <form role="form" class="form-horizontal" action="{{url('/member/ubah-password')}}" method="post">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Kata Sandi Lama : </label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi Lama">
                        {!! $errors->first('password', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Kata Sandi Baru : </label>
                    <div class="col-sm-9">
                        <input type="password" name="new_password" class="form-control" placeholder="Masukkan Kata Sandi Baru">
                        {!! $errors->first('new_password', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Ulangi Kata Sandi Baru : </label>
                    <div class="col-sm-9">
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Masukkan Kata Sandi Baru Lagi">
                        {!! $errors->first('new_password_confirmation', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="submit btn btn-primary btn-block">&nbsp;&nbsp;Update&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection