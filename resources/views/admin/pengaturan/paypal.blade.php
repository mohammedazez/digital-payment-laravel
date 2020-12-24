@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Setting <small>Pembelian PayPal</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li class="active">Pembelian PayPal</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title">Pembelian PayPal</h3>
               </div>
               <form role="form" action="" method="post">
                @csrf
                  <div class="box-body">
                    <div class="form-group{{ $errors->has('min_amount') ? ' has-error' : '' }}">
                        <label>Jumlah Minimum Pembelian : </label>
                        <input type="number" step="1" id="min_amount" class="form-control" name="min_amount" value="{{ $settings['min_amount'] }}">
                    </div>
                    <div class="form-group{{ $errors->has('start_hour') ? ' has-error' : '' }}">
                        <label>Jam Mulai Aktif : </label>
                        <input type="text" id="start_hour" class="form-control" name="start_hour" value="{{ $settings['start_hour'] }}">
                    </div>
                    <div class="form-group{{ $errors->has('end_hour') ? ' has-error' : '' }}">
                        <label>Jam Akhir Aktif : </label>
                        <input type="text" id="end_hour" class="form-control" name="end_hour" value="{{ $settings['end_hour'] }}">
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