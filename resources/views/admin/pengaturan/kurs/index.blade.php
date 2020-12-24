@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Setting <small>Kurs</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="{{route('setting.kurs.index')}}" class="btn-loading">Kurs</a></li>
      <li class="active">Minimal Deposit</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-green">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('bank.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Set Kurs</h3>
               </div>
               <form role="form" action="{{route('setting.kurs.update')}}" method="post">
               <input name="_method" type="hidden" value="PATCH">
               {{csrf_field()}}
                    <div class="box-body">
                        @foreach($kurs as $k)
                            <div class="form-group{{ $errors->has($k->name) ? ' has-error' : '' }}">
                                <label>{{ $k->name }} : </label>
                                <input type="text" class="form-control" name="{{ $k->name }}" id="{{ $k->name }}" value="{{number_format($k->value, 0, '.', '.')}}"  placeholder="">
                                {!! $errors->first($k->name, '<p class="help-block"><small>:message</small></p>') !!}
                            </div>
                        @endforeach
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
    
    @foreach($kurs as $k)
        $('#{{$k->name}}').keyup(function(){
            var {{$k->name}} = parseInt(price_to_number($('#{{$k->name}}').val()));
            var autoMoney = autoMoneyFormat({{$k->name}});
            $('#{{$k->name}}').val(autoMoney);
        });
    @endforeach
});

</script>
@endsection