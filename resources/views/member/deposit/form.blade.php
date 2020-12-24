@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Transaksi <small>Deposit Saldo</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Deposit</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Deposit Saldo</h3>
               </div>
               <form role="form" action="{{url('/member/process/depositsaldo')}}" method="post">
              @csrf
                  <div class="box-body">
                     @if(Session::has('alert-sukses'))
                        <div class="alert alert-success alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                           <h4><i class="fa fa-check"></i>Berhasil</h4>
                           <p>{!! Session::get('alert-sukses') !!}</p>
                        </div>
                      @endif
                     @if(Session::has('alert-error'))
                        <div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                           <h4><i class="fa fa-check"></i>Error</h4>
                           <p>{!! Session::get('alert-error') !!}</p>
                        </div>
                      @endif
                     <div class="form-group{{ $errors->has('nominal') ? ' has-error' : '' }}">
                        <label>Nominal : </label>
                        <div class="input-group">
                           <div class="input-group-addon">Rp. </div>
                           <input type="text" name="nominal" id="nominal" class="form-control" min="0" value="{{ old('nominal') }}" placeholder="Masukkan Nominal Deposit" autofocus>
                        </div>
                        {!! $errors->first('nominal', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
              
                  </div>

                  <div class="box-footer">
                     <button type="button" onclick="showModal()" class="btn btn-primary btn-block">&nbsp;&nbsp;Lanjutkan&nbsp;&nbsp;</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="row hidden-xs hidden-sm">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Data Deposit Anda</h3>
               </div><!-- /.box-header -->
               <div class="box-body table-responsive no-padding">
               <table id="DataTable" class="table table-hover">
                  <thead>
                     <tr class="custom__text-green">
                        <th>Bank</th>
                        <th>Nominal Transfer</th>
                        <th>Status</th>
                        <th>Expire</th>
                        <th>Tgl Request</th>
                        <th>Tgl Update</th>
                        <th>#</th>
                     </tr>
                  </thead>
                  <tbody>
                  @if($depositsWeb->count() > 0)
                  @foreach($depositsWeb as $data)
                  <tr style="font-size: 14px;">
                     <td>{{ $data->bank->nama_bank }}</td>
                     @if($data->bank_id == '5')
                        <td>BTC {{ $data->nominal_trf }}</td>
                     @else
                        <td>Rp {{ number_format($data->nominal_trf, 0, '.', '.') }}</td>
                     @endif
                     @if($data->status == 0)
                     <td><span class="label label-warning">MENUNGGU</span></td>
                     @elseif($data->status == 1)
                     <td><span class="label label-success">BERHASIL</span></td>
                     @elseif($data->status == 3)
                     <td><span class="label label-primary">VALIDASI</span></td>
                     @elseif($data->status == 2)
                     <td><span class="label label-danger">GAGAL</span></td>
                     @endif
                     @if($data->expire == 1)
                     <td><span class="label label-info">AKTIF</span></td>
                     @else
                     <td><span class="label label-danger">EXPIRE</span></td>
                     @endif
                     <td>{{$data->created_at}}</td>
                     <td>{{$data->updated_at}}</td>
                     <td>
                        @if($data->status == 0)
                            @if(!empty($data->payment_url))
                            <a href="{{ $data->payment_url }}" class="label label-primary custom__btn-green">Detail</a>
                            @else
                            <a href="{{ url('/member/deposit', $data->id) }}" class="label label-primary custom__btn-green">Detail</a>
                            @endif
                        @else
                            <a href="{{ url('/member/deposit', $data->id) }}" class="label label-primary custom__btn-green">Detail</a>
                        @endif
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan='9' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                  </tr>
                  @endif
                  </tbody>
               </table>
            </div><!-- /.box-body -->
         </div><!-- /.box -->
      </div>
   </div>
   <div class="row hidden-lg hidden-md">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Deposit Anda</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px;">
               <table class="table">
                  @if($depositsMobile->count() > 0)
                  @foreach($depositsMobile as $data)
                  
                    @php
                        $detailURL = $data->status == 0 ? (!empty($data->payment_url) ? $data->payment_url : url('/member/deposit', $data->id)) : url('/member/deposit', $data->id);
                    @endphp
                  
                  <tr>
                     <td>
                        <a href="{{ $detailURL }}" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-calendar"></i><small> {{date("d M Y", strtotime($data->created_at))}}</small></div>
                           <div style="font-size: 14px;font-weight: bold;">TOPUP Saldo Rp {{number_format($data->nominal, 0, '.', '.')}}</div>
                           <div>{{$data->bank->nama_bank}}</div>
                        </a>
                     </td>
                     <td align="right">
                        <a href="{{ $detailURL }}" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-clock-o"></i><small> {{date("H:m:s", strtotime($data->created_at))}}</small></div>
                           <div>Rp {{number_format($data->nominal_trf, 0, '.', '.')}}</div>
                           @if($data->status == 0)
                           <div><span class="label label-warning">MENUNGGU</span></div>
                           @elseif($data->status == 1)
                           <div><span class="label label-success">BERHASIL</span></div>
                           @elseif($data->status == 3)
                           <div><span class="label label-primary">VALIDASI</span></div>
                           @elseif($data->status == 2)
                           <div><span class="label label-danger">GAGAL</span></div>
                           @endif
                        </a>
                      </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                      <td colspan="2" style="text-align:center;font-style:italic;">Riwayat Transaksi belum tersedia</td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            <div class="box-footer" align="center" style="padding-top:13px;">
               @include('pagination.default', ['paginator' => $depositsMobile])
            </div>
         </div><!-- /.box -->
      </div>
   </div>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="min-width: 320px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Deposit Saldo</h4>
      </div>
      <form id="deposit" method="POST" action="{{route('process.bank.deposit')}}">
       @csrf
        <input type="hidden" id="deposit_nominal" name="nominal">
        <input type="hidden" id="deposit_id_category_bank" name="id_category_bank">
        <input type="hidden" id="deposit_bank_id" name="bank_id">
        <input type="submit" value="Go" style="display: none">
      </form>
      <div style="padding-left: 10px">
      <div id="modal_nominal" style="font-size: 24pt;align:right"></div>
      <div id="modal_title" style="padding-left: 5px"></div>
      </div>
      <div class="modal-body" style="max-height: 70vh;min-height: 400px;overflow-y: scroll;padding:5px">
        <div id="bank_kategori" class="list-group" style="margin-bottom: 0">
          @foreach($banks_kategori as $kategoripay)
          @if($kategoripay->status == 1)
            <a href="#" onclick="showBank({{$kategoripay->id}})" class="list-group-item {{$kategoripay->status == '0'?'disabled':''}}" style="min-height: 63px">
              <img src="{{ asset('img/icon/bank-category')}}/{{$kategoripay->icon}}" style="width: 50px;float: left;padding-right: 10px ">
              <h4 class="list-group-item-heading">{{$kategoripay->paymethod}}</h4>
              <p class="list-group-item-text">{!! $kategoripay->deskripsi !!}</p>
            </a>
            @endif
          @endforeach
        </div>
        <div id="bank" class="list-group" style="margin-bottom: 0">
        </div>
      </div>
      <div class="modal-footer" id="modal_footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div id="myModalCC" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Credit Card Payment</h4>
      </div>
      <div class="modal-body">
        <form role="myform" method="POST" action="{{route('process.bank.deposit')}}">
          @csrf
            <div class="form-group hidden">
                <label>CATEGORY BANK</label>
                <div class="input-group">
                  <input type="text" name="id_category_bank" id="id_category_bank">
                </div>
            </div>
              <div class="form-group hidden">
                  <label>NOMINAL</label>
                  <div class="input-group">
                    <input type="text" name="nominal" id="nominal_cc" class="form-control" placeholder="Masukkan Nominal Deposit" autocomplete="off" autofocus>
                  </div>
              </div>
            <div class="form-group">
                <label for="cardName">HOLDER NAME</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="cardName" name="cardName" placeholder="Holder Name" autocomplete="off" autofocus />
                    <span class="input-group-addon"><i class="fa fa-address-book-o"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="cardNumber">CARD NUMBER</label>
                <div class="input-group">
                    <input type="number" min="0" class="form-control" id="cardNumber" name="cardNumber" placeholder="Valid Card Number" autocomplete="off" autofocus />
                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="expityMonth">EXPIRY DATE</label>
                        <div class="row">
                          <div class="col-sm-6">
                              <input type="number" min="0" max="99" class="form-control" id="expityMonth" name="expityMonth" autocomplete="off" placeholder="MM" />
                          </div>
                          <div class="col-sm-6">
                              <input type="number" min="0" max="99" class="form-control" id="expityYear" name="expityYear" autocomplete="off" placeholder="YY" />
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 pull-right">
                    <div class="form-group">
                        <label for="cvCode">CVC</label>
                        <input type="password" class="form-control" id="cvCode" name="cvCode" maxlength="3" autocomplete="off" placeholder="CVC" />
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class='form-control btn custom__btn-greenHover btn-block' onclick="javascript:void(0);">
                Total Pembayaran Rp. <span id="final_pay">0</span>
              </div>
            </div>
						<div class="form-group hidden">
							<button class='form-control btn btn-success btn-block' id="bayar-finish" type='submit'> Bayar</button>
						</div>
        </form>
				<div class="form-group">
					<button class='form-control btn btn-success btn-block' id="bayar" type='submit'> Bayar</button>
				</div>
      </div>
    </div>
  </div>
</div>


@endsection
@section('js')
<script>

$(document).ready(function () {
	$("#bayar").click(function(){
	  $('#bayar').html("<i class='fa fa-spinner faa-spin animated fa-fw'></i> Loading...");
	  $('#bayar').attr('style', 'cursor:not-allowed;pointer-events: none;');

		if($('#cardName').val() == ''){
			$('#cardName').focus();
			swal("Error", "Holder name tidak boleh kosong!", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}

		if($('#cardNumber').val() == ''){
			$('#cardNumber').focus();
			swal("Error", "Masukkan 16 Digit nomor credit card dengan benar", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}

    var re16digit = /^\d{16}$/
    if (!re16digit.test($('#cardNumber').val())) {
				$('#cardNumber').focus();
				swal("Error", "Masukkan 16 Digit nomor credit card dengan benar", "error");
        // alert("Please enter your 16 digit credit card numbers");
        $('#bayar').html("Bayar");
        $('#bayar').removeAttr('style');
        return false;
    }

		if($('#expityMonth').val() == ''){
			$('#expityMonth').focus();
			swal("Error", "Expired Month tidak boleh kosong!", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}
		if ($('#expityMonth').val().length !=2  || isNaN($('#expityMonth').val())){
			$('#expityMonth').focus();
			swal("Error", "Format Expired Mounth MM .exp (02)", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
	 }
	 if ($('#expityMonth').val() > 12){
		 $('#expityMonth').focus();
		 swal("Error", "Format Expired Mounth anda melebihi Bulan Yang ada!", "error");
		 $('#bayar').html("Bayar");
		 $('#bayar').removeAttr('style');
		 return false;
	}
		if($('#expityYear').val() == ''){
			$('#expityYear').focus();
			swal("Error", "Expired Year tidak boleh kosong!", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}
 		if ($('#expityYear').val().length !=2  || isNaN($('#expityYear').val())){
			$('#expityYear').focus();
			swal("Error", "Format Year Mounth MM .exp (23)", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}

		var yearNow = new Date().getFullYear().toString().substr(-2);
 		if ($('#expityYear').val() < yearNow){
			$('#expityYear').focus();
 		 swal("Error", "Format Expired Year anda sudah terlewat!", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}

		if($('#cvCode').val() == ''){
			$('#cvCode').focus();
			swal("Error", "CVC Code tidak boleh kosong!", "error");
			$('#bayar').html("Bayar");
			$('#bayar').removeAttr('style');
			return false;
		}

		document.getElementById('bayar-finish').click();
	});
      var kategori_pay = <?php echo json_encode($banks_kategori); ?>;

      $('#myModalCC').on('show.bs.modal', function () {
          var passing_nominal = $('#nominal').val();
          $('#nominal_cc').val(passing_nominal);
          $('#final_pay').html((passing_nominal == '')?'0':passing_nominal);

          var radioValueok = $("input[name='id_category_bank']:checked").val();
          $('#id_category_bank').val(radioValueok);
      })
      $('#myModalCC').on('hidden.bs.modal', function () {
          for(i=0; i < kategori_pay.length; i++){
            $('#select_bank_'+kategori_pay[i].id+'').html('');
          }

          var radioButtonCategoryBank = document.getElementsByName('id_category_bank');
          for(var i = 0; i < radioButtonCategoryBank.length; i++){
              if(radioButtonCategoryBank[i].checked){
                  radioButtonCategoryBank[i].checked = false;
              }
          }

          $(this)
           .find("input,textarea,select")
              .val('')
              .end()
           .find("input[type=checkbox], input[type=radio]")
              .prop("checked", "")
              .end();
      })

      $("input[name='id_category_bank']").click(function(){
          var radioValue = $("input[name='id_category_bank']:checked").val();

          //jika pembayaran credit card
             $.blockUI({ css: {
                   border: 'none',
                   padding: '15px',
                   backgroundColor: '#000',
                   '-webkit-border-radius': '10px',
                   '-moz-border-radius': '10px',
                   opacity: .5,
                   color: '#fff',
                   fontSize:'16px',
               },
                message: 'Loading...'
             })
          	 Pace.track(function(){
          		 $.ajax({
          	        url: "{{route("get.bank.deposit")}}",
          	        type: 'POST',
          	        data: {_token:"{{ csrf_token() }}",id_category_bank:radioValue},
          	        success: function(response){
          	            //console.log(response);
                      if(response.success == true)
                      {
                          if(response.data == '2'){
                            $('#myModalCC').modal('show');
                          }else{
                              for(i=0; i < kategori_pay.length; i++){
                                $('#select_bank_'+kategori_pay[i].id+'').html('');
                              }
    
                              var radioButtonCategoryBank = document.getElementsByName('id_category_bank');
                              for(var i = 0; i < radioButtonCategoryBank.length; i++){
                                  if(radioButtonCategoryBank[i].checked){
                                      rate_value = radioButtonCategoryBank[i].value;
    
                                      var objTo = document.getElementById('select_bank_'+kategori_pay[i].id+'')
                                      var divtest = document.createElement("div");
                                      divtest.setAttribute("id", "bank_"+kategori_pay[i].id+"");
                                      divtest.innerHTML = response.data;
                                      objTo.appendChild(divtest);
                                  }
                              }
                          }

                          $.unblockUI();
                        }else if(response.success == false){
                          $.unblockUI();
                          for(i=0; i < kategori_pay.length; i++){
                            $('#select_bank_'+kategori_pay[i].id+'').html('');
                          }

                          var radioButtonCategoryBank = document.getElementsByName('id_category_bank');
                          for(var i = 0; i < radioButtonCategoryBank.length; i++){
                              if(radioButtonCategoryBank[i].checked){
                                  radioButtonCategoryBank[i].checked = false;
                              }
                          }
                          toastr.error(response.message);
                        }else{
                          $.unblockUI();
                          toastr.error("silahkan refresh kembali!.");
                        }
          	        }
          	    });
              });
      });

});

   $(function () {
      $('#DataTable').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "iDisplayLength": 50,
        "searching": false,
        "lengthChange": false,
        "info": false
      });
   });
   // Select your input element.
   var number = document.getElementById('nominal');

   // Listen for input event on numInput.
//   number.onkeydown = function(e) {
//       if(!((e.keyCode > 95 && e.keyCode < 106)
//          || (e.keyCode > 47 && e.keyCode < 58) 
//          || e.keyCode == 8)) {
//           return false;
//       }
//   }
//   $('.submit').on('click', function(){
//       $('.submit').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
//       $('.submit').attr('style', 'cursor:not-allowed;pointer-events: none;');
//     });


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

      $('#nominal').keyup(function(){
        var nominal=parseInt(price_to_number($('#nominal').val()));
        var autoMoney = autoMoneyFormat(nominal);
        $('#nominal').val(autoMoney);
    });
  });
  

  
function showModal(){
  var nominal = $('#nominal').val();
  if( nominal == "" || nominal == 0 ){
     toastr.error("Silahkan masukan nominal deposit.");
     return false;
  }
  $('#myModal').modal('show');
  $('#modal_nominal').empty();
  $('#modal_nominal').append('Rp. ' + $('#nominal').val());
  $("#bank_kategori").show();
  $("#modal_title").empty();
  $("#modal_title").append('Pilih metode pembayaran');
  $("#bank").empty();
}
$('#myModal').modal({backdrop: 'static', keyboard: false, show: false})  

function showBank($id){

        $("#bank_kategori").hide(500);
        $.ajax({
                    url: "{{route("get.bank.deposit")}}",
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_category_bank': $id
                    },
                    success: function(response){
                        //console.log(response);
                      if(response.success == true)
                      {
                          $("#modal_title").empty();
                          $("#modal_title").append('Pilih Bank tujuan');
                         var base = base_url('banks/');
                         $('#bank').append('<button class="btn btn-sm" onclick="showModal()"><i class="fa fa-arrow-circle-left"></i></button>')
                           response.data.forEach(bank =>{
                              $('#bank').append(
                                '<a href="#" onclick="deposit('+bank.id+','+bank.bank_kategori_id+')" class="list-group-item" style="min-height:63px"><img src="'+base+bank.image+'" style="width: 50px;float: left;padding-right: 10px;"><h4 class="list-group-item-heading">'+bank.nama_bank+'</h4><p class="list-group-item-text" align="right">'+bank.atas_nama+'</p></a>'
                             );
                           })
                      }else if(response.success == false){
                          $('#myModal').modal('hide');
                          toastr.error(response.message);
                      }else{
                          toastr.error("silahkan refresh kembali!.");
                      }
                    }
                });
}

function deposit($bank_id, $bank_kategori){

    $.blockUI();
    $('#myModal').modal('hide');
    $('#deposit_nominal').val($('#nominal').val());
    $('#deposit_id_category_bank').val($bank_kategori);
    $('#deposit_bank_id').val($bank_id);  
    $('#deposit').submit();
}
</script>
@endsection