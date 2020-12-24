@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Broadcast <small>SMS Massal</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Broadcast SMS</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
                 <h3 class="box-title">Broadcast SMS</h3>
               </div>
               <form role="form" action="{{url('/admin/broadcast-sms/send')}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('isi') ? ' has-error' : '' }}">
                        <label>ISI SMS Broadcast : </label>
                        <textarea name="isi" class="form-control" rows="5">Hai [name],~Hanya dengan Rp 10.000 kamu bisa jualan Pulsa All Operator, Voucher Game, Token PLN, Dll.</textarea>
                        {!! $errors->first('isi', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group">
                        <small>NB : Broadcast SMS akan terkirim ke seluruh nomor handphone member terdaftar {{$GeneralSettings->nama_sistem}}.</small>
                     </div>
                     
                  </div>
                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" class="submit btn btn-primary">Kirim</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
                    <h3 class="box-title">Tes Broadcast SMS</h3>
               </div><!-- /.box-header -->
               <div class="box-body">
                    <div align="center">
                        <div class="input-group">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor Handphone">
                            <div class="input-group-addon"><a href="Javascript:;" id="send"><i class="icon fa fa-paper-plane custom__text-green"></i></a></div>
                        </div>
                    </div>
                    <div style="margin-top:20px;">
                        <table class="table">
                            <tr>
                                <td width="40%">Status</td>
                                <td>:</td>
                                <td><span id="status"></span></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><span id="note"></span></td>
                            </tr>
                            <tr>
                                <td>Nomor Handphone</td>
                                <td>:</td>
                                <td><span id="tujuan"></span></td>
                            </tr>
                            <tr>
                                <td>Saldo</td>
                                <td>:</td>
                                <td><span id="saldo"></span></td>
                            </tr>
                        </table>
                    </div>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script>
$('#send').on('click', function(e){
    var phone = $('#phone').val();
    $('.icon').removeClass('fa-paper-plane');
    $('.icon').addClass(' fa-refresh faa-spin animated');
    $.ajax({
        url: "{{ url('/admin/broadcast-sms/check') }}",
        type: "post",
        data: {
            '_token': '{{ csrf_token() }}',
            'phone': phone,
        },
        
        success: function(data){
            $('#status').text(data.success == true ? 'SUKSES' : 'GAGAL');
            $('#tujuan').text(phone);
            $('#note').text(data.message);
            $('#saldo').text(data.balance);
            $('.icon').removeClass('fa-refresh faa-spin animated');
            $('.icon').addClass(' fa-paper-plane');
        }
    });
});
</script>
@endsection