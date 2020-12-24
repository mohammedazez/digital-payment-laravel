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
            <div class="box box-primary">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Set Minimal Deposit</h3>
               </div>
               <form role="form" action="{{route('setting.deposit.update')}}" method="post">
               <input name="_method" type="hidden" value="PATCH">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('min_deposit') ? ' has-error' : '' }}">
                        <label>Minimal Deposit : </label>
                        <input type="text" class="form-control" name="min_deposit" id="min_deposit" value="{{number_format($minDeposit[0]->minimal_nominal, 0, '.', '.')}}"  placeholder="Set Minimal Deposit">
                        {!! $errors->first('min_deposit', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
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

    $('#min_deposit').keyup(function(){
        var min_deposit=parseInt(price_to_number($('#min_deposit').val()));
        var autoMoney = autoMoneyFormat(min_deposit);
        $('#min_deposit').val(autoMoney);
    });
});

</script>
@endsection