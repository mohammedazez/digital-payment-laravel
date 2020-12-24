@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Transaksi <small>Transfer Bank</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Transfer</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Transfer Bank</h3>
               </div>
               <form role="form" action="{{url('/member/transfer-bank/send', $inquiry->uuid)}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                      @if(Session::has('alert-success'))
                        <div class="alert alert-success alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                           <h4><i class="fa fa-check"></i>Berhasil</h4>
                           <p>{!! Session::get('alert-success') !!}</p>
                        </div>
                      @endif
                     @if(Session::has('alert-error'))
                        <div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                           <h4><i class="fa fa-check"></i>Error</h4>
                           <p>{!! Session::get('alert-error') !!}</p>
                        </div>
                      @endif
                      
                     <div class="form-group">
                        <label>Bank Tujuan : </label>
                        <div class="input-group" style="width: 100%;">
                           <input type="text" class="form-control" name="bank_name" value="{{ $inquiry->bank_name }}" readonly>
                        </div>
                     </div>

                     <div class="form-group">
                        <label>No. Rekening : </label>
                        <div class="input-group" style="width: 100%;">
                           <input type="text" class="form-control" name="destination_number" value="{{ $inquiry->destination_number }}" readonly>
                        </div>
                     </div>
                     
                     <div class="form-group">
                        <label>Nama Penerima : </label>
                        <div class="input-group" style="width: 100%;">
                           <input type="text" class="form-control" name="destination_name" value="{{ $inquiry->destination_name }}" readonly>
                        </div>
                     </div>
                     
                     <div class="form-group">
                        <label>Jumlah : </label>
                        <div class="input-group" style="width: 100%;">
                           <input type="text" class="form-control" name="amount" value="{{ $originalAmount }}" readonly>
                        </div>
                     </div>
                     
                     <div id="hitung">
                     </div>
                  </div>
                  
                  <input type="hidden" name="token" value="{{ $inquiry->token }}">
                  <input type="hidden" name="note" value="{{ Auth::user()->name }} via Hijaupay">
                  <input type="hidden" name="bank_code" value="{{ $inquiry->bank_code }}">
                  <input type="hidden" name="pin" value="{{ $pin }}">

                  <div class="box-footer">
                     <button type="submit" class="submit btn custom__btn-greenHover btn-block">&nbsp;&nbsp;Proses Transfer&nbsp;&nbsp;</button>
                  </div>
               </form>
            </div>
         </div>
        <div class="col-md-6"></div>
      </div>

</section>
@endsection
@section('js')
<script>
   $('.submit').on('click', function(){
       $('.submit').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
       $('.submit').attr('style', 'cursor:not-allowed;pointer-events: none;');
    });
  });
  
</script>
@endsection