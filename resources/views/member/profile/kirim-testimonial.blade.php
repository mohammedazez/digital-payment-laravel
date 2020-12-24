@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-user"></i>
        <h3 class="box-title">Kirim Testimonial</h3>
    </div>
    <div class="box-body">
        <form role="form" class="form-horizontal" action="{{url('/member/testimonial')}}" method="post">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Rate/Penilaian : </label>
                    <div class="col-sm-9">
                        <select name="rate" class="form-control">
                            <option value="">-- Pilih Penilaian/Bintang --</option>
                            <?php
                                for($i=1;$i<=5;$i++){
                            ?>
                            <option value="{{$i}}">{{$i}} (Bintang)</option>
                            <?php } ?>
                        </select>
                        {!! $errors->first('rate', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Review/Isi Testimonial : </label>
                    <div class="col-sm-9">
                        <textarea name="review" rows="4" class="form-control" placeholder="Masukkan pengalaman bertransaksi anda..."></textarea>
                        {!! $errors->first('review', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="submit btn  btn-primary btn-block">&nbsp;&nbsp;Kirim&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection