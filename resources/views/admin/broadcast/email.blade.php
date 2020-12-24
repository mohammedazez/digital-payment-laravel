@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Broadcast <small>Email Massal</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Broadcast Email</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
                 <h3 class="box-title">Broadcast Email</h3>
               </div>
               <form role="form" action="{{url('/admin/broadcast-email/send')}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                      
                      <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label>Subject Email : </label>
                        <input type="text" name="subject" class="form-control">
                        {!! $errors->first('subject', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     
                     <div class="form-group{{ $errors->has('isi') ? ' has-error' : '' }}">
                        <label>Isi Broadcast : <small>(Mendukung tag HTML)</small></label>
                        <textarea name="isi" class="form-control" rows="5">Hai [name], ~Hanya dengan Rp 10.000 kamu bisa jualan Pulsa All Operator, Voucher Game, Token PLN, Dll</textarea>
                        {!! $errors->first('isi', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     
                     <div class="form-group">
                        <small>NB : Broadcast Email akan terkirim ke seluruh email member terdaftar {{$GeneralSettings->nama_sistem}}. Pastikan kuota email Anda mencukupi</small>
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
                    <h3 class="box-title">Tes Broadcast Email</h3>
               </div><!-- /.box-header -->
               <div class="box-body">
                    <div align="center">
                        <div class="input-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email tujuan">
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
                                <td>Email</td>
                                <td>:</td>
                                <td><span id="tujuan"></span></td>
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
    var email = $('#email').val();
    $('.icon').removeClass('fa-paper-plane');
    $('.icon').addClass(' fa-refresh faa-spin animated');
    $.ajax({
        url: "{{ url('/admin/broadcast-email/test') }}",
        type: "post",
        data: {
            '_token': '{{ csrf_token() }}',
            'email': email,
        },
        
        success: function(data){
            $('#status').text(data.success == true ? 'SUKSES' : 'GAGAL');
            $('#tujuan').text(email);
            $('#note').text(data.message);
            $('.icon').removeClass('fa-refresh faa-spin animated');
            $('.icon').addClass(' fa-paper-plane');
        }
    });
});
</script>
@endsection