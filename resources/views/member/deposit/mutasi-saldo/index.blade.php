@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Depsoit <small>Mutasi Saldo</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li><a href="Javascript:;">Deposit</a></li>
    	<li class="active">Mutasi Saldo</li>
   </ol>
   </section>
   <section class="content">
      <div class="row hidden-xs hidden-sm">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Mutasi Saldo</h3>
               </div><!-- /.box-header -->
               <div class="box-body table-responsive">
               <table id="DataTable"  class="table table-hover">
                  <thead>
                     <tr class="custom__text-green">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Type</th>
                        <th>Jumlah</th>
                        <th>Saldo</th>
                        <th>Trxid</th>
                        <th>Keterangan</th>
                     </tr>
                  </thead>
                  <tbody>
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
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Mutasi Saldo</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($mutasiMobile->count() > 0)
                  @foreach($mutasiMobile as $data)
                  <tr>
                     <td>
                       <div><i class="fa fa-calendar"></i> <small>{{date("d M Y", strtotime($data->created_at))}}</small></div>
                       <div style="font-size: 12px;font-weight: bold;">{{$data->note}}</div>
                       <div style="color:grey;font-style: italic;">Sisa Saldo : Rp {{number_format($data->saldo, 0, '.', '.')}}</div>
                     </td>
                     <td align="right" style="width:35%;">
                        <div><i class="fa fa-clock-o"></i> <small>{{date("H:i:s", strtotime($data->created_at))}}</small></div>
                        @if($data->type == 'debit')
                        <div style="font-weight: bold;" class="text-danger"> - Rp {{number_format($data->nominal, 0, '.', '.')}}</div>
                        @else
                        <div style="font-weight: bold;" class="text-success">Rp {{number_format($data->nominal, 0, '.', '.')}}</div>
                        @endif
                     </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                      <td colspan="2" style="text-align:center;font-style:italic;">Mutasi belum tersedia</td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            <div class="box-footer" align="center" style="padding-top:13px;">
                @include('pagination.default', ['paginator' => $mutasiMobile])
            </div>
         </div><!-- /.box -->
     </div>
   </div>
</section>
@endsection
@section('js')
<script>
$(document).ready(function() {
    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
        autoHight: true,
        info: false,
        ajax:{
            url : "{{ route('get.mutasiSaldo.datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        columns:[
                  {data: 'no', sClass: "text-left", orderable: false},
                  {data: 'created_at', defaulContent: '-' },
                  {data: 'type', defaulContent: '-' },
                  {data: 'nominal', defaulContent: '-' , sClass: "text-right"},
                  {data: 'saldo', defaulContent: '-' , sClass: "text-right"},
                  {data: 'trxid', defaulContent: '-' },
                  {data: 'note', defaulContent: '-' },
                ]
     });
     table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
        } );
     }).draw();
});
</script>
@endsection