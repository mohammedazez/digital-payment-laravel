@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
    <h1>Saldo <small>Redeem Voucher</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Saldo</a></li>
        <li class="active">Redeem Voucher</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Redeem Voucher</h3>
                </div>
                <form role="form" action="{{url('/member/redeem-voucher')}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        <p align="center">Masukkan Kode Voucher dan Tekan tombol Redeem untuk redeem voucher, saldo voucher akan masuk ke saldo {{$GeneralSettings->nama_sistem}} anda.</p>
                        <div class="form-group{{ $errors->has('kode_voucher') ? ' has-error' : '' }}">
                            <label>Kode Voucher : </label>
                            <input type="text" name="kode_voucher" class="form-control" placeholder="Masukkan Kode Voucher" autocomplete="off">
                            {!! $errors->first('kode_voucher', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                    </div>
                    <table class="table">
                        <tr>
                            <td style="vertical-align: middle;border-style: none;"><span class="icon-wallet custom__text-green" style="font-size:35px;"></span></td>
                            <td style="border-style: none;" align="right">
                                <div style="font-weight:bold;" class="custom__text-green">Saldo {{$GeneralSettings->nama_sistem}}</div>
                                <div style="font-size:12px;color:grey;">Sisa saldo anda adalah Rp {{number_format(Auth::user()->saldo, 0, '.', '.')}}</div>
                            </td>
                        </tr>
                    </table>
                    <div class="box-footer">
                        <button type="submit" class="submit btn  btn-primary btn-block">&nbsp;&nbsp;Redeem Voucher&nbsp;&nbsp;</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
   $(function () {
      $('#DataTable').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "iDisplayLength": 50,
        "searching": false,
        "lengthChange": false,
        "info": false
      });
   });
   $('.submit').on('click', function(){
       $('.submit').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
       $('.submit').attr('style', 'cursor:not-allowed;pointer-events: none;');
    });
</script>
@endsection