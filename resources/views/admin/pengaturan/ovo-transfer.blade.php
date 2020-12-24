@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Setting <small>OVO Transfer</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="#" class="btn-loading">OVO Transfer</a></li>
      <li class="active">OVO Transfer</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
               </div>
               <form action="" method="POST">
               {{ csrf_field() }}
                  <div class="box-body">
                    <div class="col-md-12">
                         <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                            <label>Status : </label>
                            <select class="form-control" name="active" id="active">
                                <option value="0" {{ $setting->active == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="1" {{ $setting->active == 1 ? 'selected' : '' }}>Aktif</option>
                            </select>
                            {!! $errors->first('active', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                    </div>
                    
                    <div class="col-md-12">
                         <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label>No. HP : </label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $setting->phone }}">
                            {!! $errors->first('phone', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                    </div>
                    
                    <div class="col-md-12">
                         <div class="form-group{{ $errors->has('min_amount') ? ' has-error' : '' }}">
                            <label>Minimum Transfer : </label>
                            <input type="text" class="form-control" name="min_amount" id="min_amount" value="{{ number_format($setting->min_amount, 0, '', '.') }}">
                            {!! $errors->first('min_amount', '<p class="help-block"><small>:message</small></p>') !!}
                         </div>
                    </div>
                    
                    <div class="col-md-12">
                         <div class="form-group{{ $errors->has('max_amount') ? ' has-error' : '' }}">
                            <label>Maksimum Transfer : </label>
                            <input type="text" class="form-control" name="max_amount" id="max_amount" value="{{ number_format($setting->max_amount, 0, '', '.') }}">
                            {!! $errors->first('max_amount', '<p class="help-block"><small>:message</small></p>') !!}
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

    $('#min_amount').keyup(function(){
        var min_amount = parseInt(price_to_number($('#min_amount').val()));
        var autoMoney = autoMoneyFormat(min_amount);
        $('#min_amount').val(autoMoney);
    });
    
    $('#max_amount').keyup(function(){
        var max_amount = parseInt(price_to_number($('#max_amount').val()));
        var autoMoney = autoMoneyFormat(max_amount);
        $('#max_amount').val(autoMoney);
    });
});

</script>
@endsection