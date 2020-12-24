@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-paypal"></i>
        <h3 class="box-title">Rekening PayPal</h3>
    </div>
    
    <div class="box-body">
        <form role="form" class="form-horizontal" action="" method="post">
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Email Utama PayPal : </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                          <input type="email" name="email" id="email" class="form-control" value="{{ $user->paypal_email ?: '' }}" required>
                          <span class="input-group-btn">
                              @if(!empty($user->paypal_email))
                                <button type="button" class="btn btn-success" title="Email terverifikasi"><i class="fa fa-check-circle"></i></button>
                              @else
                              <button type="button" class="btn btn-default" title="Belum dilengkapi"><i class="fa fa-warning"></i></button>
                              @endif
                          </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('verification_code') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Kode Verifikasi : </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                          <input type="number" name="verification_code" id="verification_code" class="form-control" value="" required>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-info" onclick="sendCode();">Request Kode</button>
                          </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group" id="request_id_input" style="display:none">
                    <label class="col-sm-3 control-label">Request ID : </label>
                    <div class="col-sm-9">
                        <input type="text" id="request_id" class="form-control" readonly disabled>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary btn-block">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function() {
    
});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function sendCode()
{
    var email = $("#email").val();
    
    if( !validateEmail(email) ) {
        toastr.error("Masukkan alamat email yang valid!");
        return false;
    }
    
    $.ajax({
        url: "{{ url('/member/rekening-paypal/send-code') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            email: email,
            _token: "{{ csrf_token() }}"
        },
        success: function(s) {
            if( s.success === true ) {
                $("#request_id_input").show("fast");
                $("#request_id").val(s.request_id);
                toastr.success("Kode konfirmasi berhasil dikirim ke " + s.email + ". Silahkan cek kotak masuk atau spam email Anda");
            }
            else {
                toastr.error(s.message);
            }
        },
        error: function(e) {
            toastr.error("Error!");
        }
    });
}

</script>
@endsection