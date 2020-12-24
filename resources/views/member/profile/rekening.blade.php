@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-university"></i>
        <h3 class="box-title">Alamat Bank</h3>
    </div>
    
    
    
    <div class="box-body">
        @if($sesi == 'CREATE')
        <form role="form" class="form-horizontal" action="{{url('/member/tambah-rekening-bank')}}" method="post">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group{{ $errors->has('nama_pemilik_bank') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Nama Pemilik Bank : </label>
                    <div class="col-sm-9">
                        <input type="text" name="nama_pemilik_bank" class="form-control" placeholder="Masukkan Nama Pemilik Bank">
                        {!! $errors->first('nama_pemilik_bank', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                 <div class="form-group{{ $errors->has('jenis_rek') ? ' has-error' : '' }}">
                      <label class="col-sm-3 control-label">Jenis Bank : </label>
                        <div class="col-sm-9">
                          <select class="form-control" id="jenis_rek" name="jenis_rek" style="width:100% !important";>
                          </select>
                         </div>
                    {!! $errors->first('jenis_rek', '<p class="help-block"><small>:message</small></p>') !!}
                  </div>
                      
                <div class="form-group{{ $errors->has('rek') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Nomor Rekening : </label>
                    <div class="col-sm-9">
                        <input type="number" name="rek" class="form-control" placeholder="Masukkan Nomor Rekening">
                        {!! $errors->first('rek', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="submit btn btn-primary btn-block">&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>
                    </div>
                </div>
            </div>
        </form>
        @endif
        @if($sesi == 'VIEW')
                <table class="table" style="font-size:14px;">
                     <tr>
                        <td>Nama Pemilik</td>
                        <td>:</td>
                        <td>{{$cek->nama_pemilik_bank}}</td>
                     </tr>
                     <tr>
                        <td>Jenis Bank</td>
                        <td>:</td>
                        <td>{{$cek->name}} / Kode Bank : {{$cek->code}}</td>
                     </tr>
                     <tr>
                        <td>Nomor Rekening</td>
                        <td>:</td>
                        <td>{{$cek->no_rekening}}</td>
                     </tr>
                  </table>
        @endif
    </div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function() {
    
    $('#jenis_rek').select2({
        placeholder: "Pilih Jenis Bank",
        ajax: {
            url: "{{ route('get.bank.code') }}",            
            data: function(params){
                 return {
                     q: params.term
                 };
             },
            processResults: function(data){
                $('#pilih_member').empty();
                return {
                    results : data,
                }
            }

        }
    });
    
   // Select your input element.
   var number = document.getElementById('number');

   // Listen for input event on numInput.
   number.onkeydown = function(e) {
       if(!((e.keyCode > 95 && e.keyCode < 106)
         || (e.keyCode > 47 && e.keyCode < 58) 
         || e.keyCode == 8)) {
           return false;
       }
   }
   
});
</script>
@endsection