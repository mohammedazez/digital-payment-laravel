@extends('layouts.admin')

@section('content')
<section class="content-header">
<h1>Pengaturan <small>Data Bank</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="Javascript:;">Pengaturan</a></li>
 	<li class="active">Data Bank</li>
</ol>
</section>
<section class="content"> 
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Bank</h3>
               <a href="{{route('bank.create')}}" class="btn-loading btn btn-blue pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Data Bank" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($provider as $item)
                  <div class="panel panel-default">
                      <div id="collapseOne{{$item->id}}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne{{$item->id}}">
                        <div class="panel-body">
                          <div class="api-section">
                            <div class="row">
                             @if($item->name=="CoinPayment")
                              <form action="{{url('admin/bank/edit_data')}}" method="post">
                                {{csrf_field()}}
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      Mechant ID
                                    </div>
                                    <div class="card-tipe-subtitle">
                                        <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                        <input type="text" class="form-copy-text" name="merchant_code" value="{{$item->merchant_code}}" id="merchant_code{{$item->id}}">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      IPN Secret
                                    </div>
                                    <div class="card-tipe-subtitle">
                                      <input type="text" class="form-copy-text" name="ipn_secret" value="{{$item->ipn_secret}}" id="ipn_secret{{$item->id}}">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                    Public Key
                                    </div>
                                    <div class="card-tipe-subtitle">
                                      <input type="text" class="form-copy-text" name="public_key" value="{{$item->public_key}}" id="public_key{{$item->id}}">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      Private Key
                                    </div>
                                    <div class="card-tipe-subtitle">
                                      <input type="text" class="form-copy-text" name="private_key" value="{{$item->private_key}}" id="private_key{{$item->id}}">
                                      <button class="btn btn-blue btn-sm" type="submit">Save</button>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                              @elseif($item->name == "PerfectMoney")
                              <form action="{{url('admin/bank/edit_data')}}" method="post">
                                {{csrf_field()}}
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      Phrase Hash
                                    </div>
                                    <div class="card-tipe-subtitle">
                                      <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                      <input type="text" class="form-copy-text" name="api_key" value="{{$item->api_key}}" id="phrase{{$item->id}}">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      Password
                                    </div>
                                    <div class="card-tipe-subtitle input-group" id="password{{$item->id}}">
                                      <input type="password" class="form-control form-copy-text" name="private_key" value="{{$item->private_key}}" id="private_key{{$item->id}}">
                                      <span class="input-group-btn">
                                        <button class="btn btn-password" onclick="showPassword('password{{$item->id}}')" type="button"><i class="fa fa-eye"></i></button>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      Member ID 
                                    </div>
                                    <div class="card-tipe-subtitle">
                                    {{-- <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                      {{csrf_field()}}
                                      <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}"> --}}
                                      <input type="text" class="form-copy-text" name="merchant_code" value="{{$item->merchant_code}}" id="merchant_code{{$item->id}}">
                                      {{-- <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('member_id{{$item->id}}')"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""></span> --}}
                                      {{-- <button class="btn btn-blue btn-sm" type="submit">Save</button>
                                    </form> --}}
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-8 mr">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                      Payee Account
                                    </div>
                                    <div class="card-tipe-subtitle">
                                      <input type="text" class="form-copy-text" name="ipn_secret" value="{{$item->ipn_secret}}" id="ipn_secret{{$item->id}}">
                                      <button class="btn btn-blue btn-sm" type="submit">Save</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                              @elseif($item->name =="Paypal")
                              <div class="col-md-4 col-sm-8 mt-4">
                                <div class="d-flex">
                                  <img src="{{url('img/icon/email.png')}}" class="img-fluid" alt="" height="40px">
                                  <div class="api">
                                    <div class="card-tipe-title">
                                    Email Paypal
                                    </div>
                                    <div class="card-tipe-subtitle">
                                      <form action="{{url('admin/bank/edit_data')}}" method="post">
                                      {{csrf_field()}}
                                      <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                      <input type="text" class="form-copy-text" name="api_key" value="{{$item->api_key}}" id="private_key{{$item->id}}">
                                      <button class="btn btn-blue btn-sm" type="submit">Save</button>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <a href="#ModalPaypal" class="btn-loading btn btn-blue pull-right" data-toggle="modal" data-toggle="tooltip" data-placement="left" title="Tambah Akun Paypal" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
                              @else 
                                @if($item->api_key != "")
                                <div class="col-md-4 col-sm-8 mt-4">
                                  <div class="d-flex">
                                    <img src="{{url('img/icon/api-key-icon.png')}}" class="img-fluid" alt="">
                                    <div class="api">
                                      <div class="card-tipe-title">
                                        Api Key
                                      </div>
                                      <div class="card-tipe-subtitle">
                                        <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                          {{csrf_field()}}
                                          <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                          <input type="text" class="form-copy-text" name="api_key" onblur="submit();" value="{{$item->api_key}}" id="api_key{{$item->id}}">
                                          <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('api_key{{$item->id}}');"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""></span>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                @if($item->api_signature != "")
                                <div class="col-md-4 col-sm-8 mt-4">
                                  <div class="d-flex">
                                    <img src="{{url('img/icon/api-signature-icon.png')}}" class="img-fluid" alt="">
                                    <div class="api">
                                      <div class="card-tipe-title">
                                        Api Signature
                                      </div>
                                      <div class="card-tipe-subtitle">
                                        <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                          {{csrf_field()}}
                                          <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                          <input type="text" class="form-copy-text" onblur="submit();" name="api_signature" value="{{$item->api_signature}}" id="api_signature{{$item->id}}">
                                          <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('api_signature{{$item->id}}');"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""><span>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                @if($item->private_key != "")
                                <div class="col-md-4 col-sm-8 mt-4">
                                  <div class="d-flex">
                                    <img src="{{url('img/icon/api-signature-icon.png')}}" class="img-fluid" alt="">
                                    <div class="api">
                                      <div class="card-tipe-title">
                                        Private Key
                                      </div>
                                      <div class="card-tipe-subtitle">
                                        <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                          {{csrf_field()}}
                                          <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                          <input type="text" class="form-copy-text" name="private_key" onblur="submit();" value="{{$item->private_key}}" id="api_signature{{$item->id}}">
                                          <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('api_signature{{$item->id}}');"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""><span>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                @if($item->merchant_code != "")
                                <div class="col-md-4 col-sm-8 mt-4">
                                  <div class="d-flex">
                                    <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                    <div class="api">
                                      <div class="card-tipe-title">
                                        Mechant Code
                                      </div>
                                      <div class="card-tipe-subtitle">
                                        <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                          {{csrf_field()}}
                                          <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                          <input type="text" class="form-copy-text" name="merchant_code" onblur="submit();" value="{{$item->merchant_code}}" id="mechant_code{{$item->id}}">
                                          <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('merchant_code{{$item->id}}')"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""></span>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                @if($item->ipn_secret != "")
                                <div class="col-md-4 col-sm-8 mt-4">
                                  <div class="d-flex">
                                    <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                    <div class="api">
                                      <div class="card-tipe-title">
                                        IPN Secret
                                      </div>
                                      <div class="card-tipe-subtitle">
                                      <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                        <input type="text" class="form-copy-text" onblur="submit();" name="ipn_secret" value="{{$item->ipn_secret}}" id="ipn_secret{{$item->id}}">
                                        <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('ipn_secret{{$item->id}}')"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""></span>
                                      </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                @if($item->public_key != "")
                                <div class="col-md-4 col-sm-8 mt-4">
                                  <div class="d-flex">
                                    <img src="{{url('img/icon/private-key-icon.png')}}" class="img-fluid" alt="">
                                    <div class="api">
                                      <div class="card-tipe-title">
                                      Public Key
                                      </div>
                                      <div class="card-tipe-subtitle">
                                      <form action="{{url('admin/bank/edit_data_provider')}}" method="POST">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id_provider" id="id_provider{{$item->id}}" value="{{$item->id}}">
                                        <input type="text" class="form-copy-text" onblur="submit();" name="public_key" value="{{$item->public_key}}" id="public_key{{$item->id}}">
                                        <span data-toggle="tooltip" title="Copied" onclick="copyToClipboard('public_key{{$item->id}}')"><img class="copy-icon" src="{{url('img/icon/Icon feather-copy.png')}}" alt=""></span>
                                      </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                              @endif
                            </div>
                            <div class="banks-section">
                              <div class="row">
                              @foreach($item->bank as $data)
                                <div class="col-md-4 col-sm-8 ">
                                  <div class="d-flex">
                                    <img src="{{url('img/banks/'.$data->image)}}" height="30px" class="img-fluid" alt="">
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-8 ">
                                  <div class="d-flex">
                                    <form action="{{url('admin/bank/edit_data_bank')}}" method="POST">
                                      {{csrf_field()}}
                                      <div class="card-tipe-title" >
                                          <input type="text" class="form-copy-text" name="atas_nama" value="{{$data->atas_nama}}" id="atas_nama{{$data->id}}" >
                                      </div>
                                      <div class="card-tipe-subtitle" >
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <input type="text" class="form-copy-text"  name="no_rek" value="{{$data->no_rek}}" id="no_rek{{$data->id}}">
                                        @if($item->name == 'CekMutasi')
                                        <button class="btn btn-blue btn-sm" type="submit">Save</button>
                                        @endif
                                      </div>
                                      </form>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-8 ">
                                <div class="btn btn-bank">
                                  <form method="POST" action="{{ route('bank.destroy', $data->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                   
                                    @if($item->name =="Paypal")
                                    <a href="#ModalPaypal2" class="btn btn-edit" data-toggle="modal" data-toggle="tooltip" data-placement="left" title="Tambah Akun Paypal" onclick="editakun('{{$data->id}}','{{$data->atas_nama}}','{{$data->no_rek}}','{{$data->code}}')"><img src="{{url('img/icon/Icon material-edit.png')}}" alt=""></a>
                                    @else 
                                    <a href="{{route('bank.edit', $data->id)}}" class="btn btn-edit"><img src="{{url('img/icon/Icon material-edit.png')}}" alt=""></a>
                                    @endif
                                    <input type="checkbox" class="check-status"  id="status{{$data->id}}" value="{{$data->status}}" onchange="status('{{$data->id}}','{{$item->id}}')" {{$data->status == '1' ? 'checked' : ""}}  data-plugin="switchery" data-color="#1bb99a" data-size="small"/>
                                    {{-- <button class="btn btn-delete" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><img src="{{url('img/icon/Icon material-delete.png')}}" alt=""></button> --}}
                                  </form>
                                  </div>
                                  
                                </div>
                                @endforeach
                               
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                @endforeach
              </div>
            </div>
        </div>  
      </div>
   </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="ModalPaypal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Akun Paypal</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('admin/bank/akunPaypal')}}" method="post">
          {{csrf_field()}}
        <div class="form-group{{ $errors->has('atas_nama') ? ' has-error' : '' }}">
          <label>Nama Pemilik : </label>
          <input type="text" class="form-control" name="atas_nama" value="{{ old('atas_nama') }}"  placeholder="Masukkan Nama Pemilik Rekening">
           {!! $errors->first('atas_nama', '<p class="help-block"><small>:message</small></p>') !!}
       </div>
       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label>Email Paypal : </label>
          <input type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Masukkan Nomor Rekening Rekening">
           {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
       </div>
       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label>Code: </label>
        <input type="text" class="form-control" name="code" value="{{ old('code') }}"  placeholder="Masukkan Nomor Rekening Rekening">
         {!! $errors->first('code', '<p class="help-block"><small>:message</small></p>') !!}
     </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalPaypal2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Akun Paypal</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('admin/bank/editakunPaypal')}}" method="post">
          {{csrf_field()}}
        <div class="form-group{{ $errors->has('atas_nama') ? ' has-error' : '' }}">
          <label>Nama Pemilik : </label>
          <input type="hidden" name="id" id="id_paypal">
          <input type="text" class="form-control" id="atas_nama" name="atas_nama" value="{{ old('atas_nama') }}"  placeholder="Masukkan Nama Pemilik Rekening">
           {!! $errors->first('atas_nama', '<p class="help-block"><small>:message</small></p>') !!}
       </div>
       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label>Email Paypal : </label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"  placeholder="Masukkan Email Paypal">
           {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
       </div>
       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label>Code: </label>
        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}"  placeholder="Masukkan Code Untuk itegrasi">
         {!! $errors->first('code', '<p class="help-block"><small>:message</small></p>') !!}
     </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('js')
<script>
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });
  $(function () {
      $('#DataTable').DataTable();
   });
   $(document).on('show','.accordion',function(e){
      $(e.target).prev('')
   })
   $()
  
  function copyToClipboard(text) {
  $("#"+text).tooltip("show");

    var input = document.createElement("input");
    if($("#"+text).val().search("-") > 0){
      /* Ketika Ada - */
      var data_text =  $("#"+text).val().split(" - ");

      for(i=0;i<data_text.length;i++){
        input.value += $("#"+text).val().split(" - ")[i];
      }
    }else{
      if($("#"+text).val().search(" ") > 0){
      if($("#"+text).val().search("Rp") >= 0){
          /* Ketika Ada Rp nya */
          input.value = $("#"+text).val().split(" ")[1];
      }else{
        /* Ketika Ada Sepsai Banyak */
        var data_text =$("#"+text).val().split(" ");
        for(i=0;i<data_text.length;i++){
          input.value += $("#"+text).val().split(" ")[i];
        }
      }
      }else{
        /* Ketika Tidak Ada Sepasi */
        input.value = $("#"+text).val();
      }
    }

    input.style.position = "absolute";
    input.style.left = "-1000px";
    input.style.top = "-1000px";
    input.id = "input-copy";

    $("body").append(input);
    input.focus();
    input.select();

    document.execCommand('copy');

    $("#input-copy").remove();
    setTimeout(function(){
      $("#"+text).tooltip("hide");
    },2000);
  }
  
  function status(obj,id_provider){
    var provider = $('#id_provider'+id_provider).val();
    var api_key = $('#api_key'+provider).val();
    var private_key = $('#private_key'+provider).val();
    var merchant_code = $('#merchant_code'+provider).val();
    var ipn_secret = $('#ipn_secret'+provider).val();
    var phrase = $('#phrase'+provider).val();
    var api_signature = $('#api_signature'+provider).val();
    var public_key = $('#public_key'+provider).val(); 
    console.log(provider);
    console.log(api_key);
    
    var status = $('#status'+obj).val();

    var result = "";

   if($('#status'+obj).val()=='1'){
       status = '0'
   }

   if($('#status'+obj).val()=='0'){
        
        if(provider == 1){
            if(api_key == "" && private_key == "" && merchant_code == ""){
                $('#status'+obj).prop("checked",false);
                toastr.error('Harap Masukkan Api Key, Private Key , dan Merchant code');
                return false;
            }
        }
        if(provider == 2){
            if(api_key =="" && api_signature == ""){
                  $('#status'+obj).prop("checked",false);
                 toastr.error('Harap Masukkan Api Key, dan Api signature ');
                 return false;
            }
        }
        if(provider == 3){
            if(merchant_code == "" && ipn_secret == "" && public_key == "" && private_key == ""){
                  $('#status'+obj).prop("checked",false);
                toastr.error('Harap Masukkan Member Id, IPN SECRET, Public key, dan Private Key ');
                return false;
            }
        }
        if(provider == 4 ){
            if(phrase =="" && private_key =="" && ipn_secret == "" && merchant_code == ""){
                  $('#status'+obj).prop("checked",false);
                toastr.error('Harap Masukkan Phrase Hash, Payee Account , Password ,dan Member ID');
                return false;
            }
        }
        if(provider == 5){
            if(private_key == ""){
                  $('#status'+obj).prop("checked",false);
                toastr.error('Harap Masukkan Email Paypal');
                return false;
            }
        }
        
        status = '1';
   }
  
    $.ajax({
        type: 'put',
        url: 'bank/status/'+obj,
        data:{
            id : obj,
            status:status,
        },
        success:function(data){
            $('#status'+obj).val(data.status);
            if(data.status == '0'){
              status = 'Dimatikan';
            }
            if(data.status == '1'){
              status = 'Aktif';
            }
            toastr.success('status berhasil diupdate', data.nama_bank+' status '+status);
        },error : function(response){
          toastr.error(response.responseText, 'Terjadi Kesalahan');
        }
    });
}

function editakun(id,atas_nama,no_rek,code){
  $('#id_paypal').val(id);
  $('#atas_nama').val(atas_nama);
  $('#email').val(no_rek);
  $('#code').val(code);
}

function showPassword(id){
    let passwordField = $('#' + id+" > input");
    let passwordFieldType = passwordField.attr('type');

    if(passwordField.val() != '')
    {
      if(passwordFieldType == 'password')
      {
        passwordField.attr('type', 'text');
        $(".btn-password > i").removeClass('fa-eye').addClass('fa-eye-slash');
      } else{
        passwordField.attr('type', 'password');
        $('.btn-password > i').removeClass('fa-eye-slash').addClass('fa-eye');
      }
    }
  }
</script>
@endsection