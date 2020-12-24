@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Beli <small>Saldo Paypal</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Beli Saldo Paypal</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Beli Saldo Paypal</h3>
               </div>
               <form role="form" action="{{url('/member/buy-paypal')}}" method="post">
               {{ csrf_field() }}
                  <div class="box-body">
                    <div class="form-group{{ $errors->has('address_paypal') ? ' has-error' : '' }}">
                        <label>Akun Paypal anda : </label>
                        <input type="email" id="address_paypal" name="address_paypal" value="{{ old('address_paypal') }}" class="form-control phone_number" autocomplete="off" placeholder="Masukkan Alamat Paypal Penerima" autocomplete="off" autofocus>
                        {!! $errors->first('address_paypal', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group{{ $errors->has('nominal') ? ' has-error' : '' }}">
                        <label>Nominal : </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
                            <input id="number" type="text" class="form-control nominal" name="nominal"  value="0" placeholder="Nominal Pembelian">
                        </div>
												{!! $errors->first('nominal', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group">
                        <label>Calculator Rate (Rp. <span id="ratekurs1">{{number_format(0,0,',','.')}}</span>) : </label>
                        <div class="row">
                            <div class="col-md-12">
                                <table cellspacing="0" class="table" style="background-color: #0CB4FF;color:white;">
                                    <tr style="background-color: #0775a7;">
                                        <td class="text-left" width="50%">Rate</td>
                                        <td class="text-left" width="10%"> : </td>
                                        <td class="text-right"> <span id="ratekurs2">{{number_format(0,0,',','.')}}</span> IDR </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" width="50%">Total <b>(<span id="ratekurs3">{{number_format(0,0,',','.')}}</span> IDR x <span id="transaction"> 0.00</span> USD)</b></td>
                                        <td class="text-left" width="10%"> : </td>
                                        <td class="text-right"> <span id="total">0</span> IDR </td>
                                    </tr>
                                    <tr hidden>
                                        <td class="text-left" width="50%">Administrasi Fee</td>
                                        <td class="text-left" width="10%"> : </td>
                                        <td class="text-right"> <span id="fee">0</span> IDR </td>
                                    </tr>
                                    <tr style="background-color: #0775a7;">
                                        <td class="text-left" width="50%">Grand Total</td>
                                        <td class="text-left" width="10%"> : </td>
                                        <td class="text-right"> <span id="grand_total">0</span> IDR </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                        <label>Pin : </label>
                        <input type="text" id="number" name="pin" class="form-control pin" placeholder="Masukkan PIN anda" autocomplete="off" autofocus>
                        {!! $errors->first('pin', '<p class="help-block"><small>:message</small></p>') !!}
                        <p><i>Untuk melihat pin anda,silahkan lihat di profile!</i></p>
                    </div>
                     <div id="hitung">
                     </div>
                  </div>

                  <div class="box-footer">
                     <button type="submit" class="submit btn custom__btn-greenHover btn-block">&nbsp;&nbsp;Continue&nbsp;&nbsp;</button>
                  </div>
               </form>
            </div>
         </div>
        <div class="col-md-6">
            <div class="box box-default" style="min-height:530px;">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Ketentuan</h3>
                </div>
                <div class="box-body" align="left">
                    <p><b>Ketentuan :</b>
                    <br/>1. Minimal Transaksi Sebesar <b><i>${{ number_format($ppsetting['min_amount'], 2, ',', '') }}</i></b>.
                    <br/>2. Setiap Transaksi akan divalidasi terlebih dahulu.
                    <br/>3. Jam Oprasional {{ $ppsetting['start_hour'] }} - {{ $ppsetting['end_hour'] }}.
                    <br/>4. Untuk <b><i>Paypal Indonesia</i></b> transaksi bebas <b><i>fee</i></b>.
                    <br/>
              </div>
          </div>
      </div>
</section>
@endsection
@section('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script>

$(document).ready(function(){
    var fee = 0;
    var rate = 0;
    var currencyFrom = 0;
    var currencyTo = 0;
    var total_amount = 0;

    function formatNumber(numb){
        o = numb.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        return o.toString();
    }

    function convertToRupiah(angka)
    {
    	var rupiah = '';
    	var angkarev = angka.toString().split('').reverse().join('');
    	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    	return rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function price_to_number(v){
      if(!v){return 0;}
          v=v.split('.').join('');
          v=v.split(',').join('');
      return Number(v.replace(/[^0-9.]/g, ""));
    }


    $('.nominal').keyup(function(){
        var toNumber=parseInt(price_to_number($('.nominal').val()));
        $('.nominal').val(toNumber);
    });

    function definitelyNaN (val) {
        return isNaN(val && val !== true ? Number(val) : parseFloat(val));
    }

    $('.nominal').on('input propertychange paste', function () {
        var nominal = $('.nominal').val();
        var rateDB = <?php echo json_encode($rate);?>;
        var rateDBLast = <?php echo json_encode($rateLast->rate);?>;

        // var rate = 0;
        var rate = parseInt(rateDBLast);
        rateDB.forEach(function(data) {
            if(parseInt(nominal) >= parseInt(data.usd_from) && parseInt(nominal) <= parseInt(data.usd_to)){
                rate = data.rate;
            }
        });

        $('#ratekurs1').html(convertToRupiah(parseInt(rate)));
        $('#ratekurs2').html(convertToRupiah(parseInt(rate)));
        $('#ratekurs3').html(convertToRupiah(parseInt(rate)));

        var convDollar = numeral(nominal).format('0,0.00');
        var ttl_withrate =  parseInt(rate) * parseInt(nominal);
        var checkNaN = definitelyNaN(ttl_withrate);
        if(checkNaN == true){
            ttl_withrate = 0;
        };

        $('#transaction').html(convDollar);
        $('#total').html(convertToRupiah(ttl_withrate));
        if (ttl_withrate >= 250000) {
            var fee = 0;
            var fee = $('#fee').html(fee);
            $('#grand_total').html(convertToRupiah(ttl_withrate));
        } else {
            var fee = 0;
            var fee = $('#fee').html(fee);
            $('#grand_total').html(convertToRupiah(ttl_withrate));
        }
    });
});

</script>
@endsection