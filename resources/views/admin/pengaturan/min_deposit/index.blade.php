@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>Setting <small>Minimal Deposit</small></h1>
   <ol class="breadcrumb">
      <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="{{route('setting.deposit.index')}}" class="btn-loading">Minimal Deposit</a></li>
      <li class="active">Minimal Deposit</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Set Minimal Deposit</h3>
               </div>
               <form role="form" action="{{route('setting.deposit.update')}}" method="post">
               <input name="_method" type="hidden" value="PATCH">
               {{csrf_field()}}
                  <div class="box-body">
                    <div class="col-md-6">
                         <div class="form-group{{ $errors->has('min_deposit_personal') ? ' has-error' : '' }}">
                            <label>Minimal Deposit Personal : </label>
                            <input type="text" class="form-control" name="min_deposit_personal" id="min_deposit_personal" value="{{number_format($minDeposit[0]->minimal_nominal, 0, '.', '.')}}"  placeholder="Set Minimal Deposit">
                            {!! $errors->first('min_deposit_personal', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                         <div class="form-group{{ $errors->has('min_deposit_admin') ? ' has-error' : '' }}">
                            <label>Minimal Deposit Admin : </label>
                            <input type="text" class="form-control" name="min_deposit_admin" id="min_deposit_admin" value="{{number_format($minDeposit[1]->minimal_nominal, 0, '.', '.')}}"  placeholder="Set Minimal Deposit">
                            {!! $errors->first('min_deposit_admin', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                    </div>     
                    <div class="col-md-6">
                         <div class="form-group{{ $errors->has('min_deposit_agen') ? ' has-error' : '' }}">
                            <label>Minimal Deposit Agen : </label>
                            <input type="text" class="form-control" name="min_deposit_agen" id="min_deposit_agen" value="{{number_format($minDeposit[2]->minimal_nominal, 0, '.', '.')}}"  placeholder="Set Minimal Deposit">
                            {!! $errors->first('min_deposit_agen', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                         <div class="form-group{{ $errors->has('min_deposit_enterprise') ? ' has-error' : '' }}">
                            <label>Minimal Deposit Enterprise : </label>
                            <input type="text" class="form-control" name="min_deposit_enterprise" id="min_deposit_enterprise" value="{{number_format($minDeposit[3]->minimal_nominal, 0, '.', '.')}}"  placeholder="Set Minimal Deposit">
                            {!! $errors->first('min_deposit_enterprise', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
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
            <div class="box box-green">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Set Fee Deposit</h3>
               </div>
               <form  action="{{url('admin/setting-deposit/fee_deposit')}}" method="post">
               {{-- <input name="_method" type="hidden" value="PATCH"> --}}
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('deposit_fee') ? ' has-error' : '' }}">
                        <label>Fee Deposit</label>
                        <input type="text" class="form-control" name="deposit_fee" id="deposit_fee" value="{{number_format($fee_deposit,0,'.','.')}}"  placeholder="Set Fee Deposit">
                        {!! $errors->first('deposit_fee', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>
                  <div class="box-footer">
                     <button type="submit" class="submit btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>
</section>
@endsection

@section('js')
<script type="text/javascript">

$(document).ready(function() {

    function autoMoneyFormat(b){
        var _minus = false;
        if (b<0) _minus = true;
        b = b.toString();
        b=b.replace(".","");
        b=b.replace("-","");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--){
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)){
        c = b.substr(i-1,1) + "." + c;
        } else {
        c = b.substr(i-1,1) + c;
        }
        }
        if (_minus) c = "-" + c ;
        return c;
    }

      function price_to_number(v){
      if(!v){return 0;}
          v=v.split('.').join('');
          v=v.split(',').join('');
      return Number(v.replace(/[^0-9.]/g, ""));
      }
      
      function number_to_price(v){
      if(v==0){return '0,00';}
          v=parseFloat(v);
          // v=v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.split('.').join('*').split(',').join('.').split('*').join(',');
      return v;
      }
      
      function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
      }

    $('#min_deposit_personal').keyup(function(){
        var min_deposit_personal=parseInt(price_to_number($('#min_deposit_personal').val()));
        var autoMoney = autoMoneyFormat(min_deposit_personal);
        $('#min_deposit_personal').val(autoMoney);
    });
    
    $('#min_deposit_admin').keyup(function(){
        var min_deposit_admin=parseInt(price_to_number($('#min_deposit_admin').val()));
        var autoMoney = autoMoneyFormat(min_deposit_admin);
        $('#min_deposit_admin').val(autoMoney);
    });
    
     $('#min_deposit_agen').keyup(function(){
        var min_deposit_agen=parseInt(price_to_number($('#min_deposit_agen').val()));
        var autoMoney = autoMoneyFormat(min_deposit_agen);
        $('#min_deposit_agen').val(autoMoney);
    });
    
     $('#min_deposit_enterprise').keyup(function(){
        var min_deposit_enterprise=parseInt(price_to_number($('#min_deposit_enterprise').val()));
        var autoMoney = autoMoneyFormat(min_deposit_enterprise);
        $('#min_deposit_enterprise').val(autoMoney);
    });
     $('#deposit_fee').keyup(function(){
        var min_deposit_enterprise=parseInt(price_to_number($('#deposit_fee').val()));
        var autoMoney = autoMoneyFormat(min_deposit_enterprise);
        $('#deposit_fee').val(autoMoney);
    });
});

</script>
@endsection