@extends('layouts.member')

@section('content')
<section class="content-header">
	<h1>Bonus <small>Transaksi Referral</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Bonus Transaksi Referral</li>
    </ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Bonus Transaksi Referral Anda</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover" id="DataTable">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No</th>
                                <th>User</th>
                                <th>Trx Referral</th>
                                <th>Bonus</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row hidden-lg hidden-md">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Bonus Transaksi Referral Anda</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($komisi_trx_pulsa->count() > 0)
                      @foreach($komisi_trx_pulsa as $data)
                      <tr>
                         <td>
                            <a href="#!" class="btn-loading" style="color: #464646">
                               <div><i class="fa fa-calendar"></i> <small>{{date("d M Y", strtotime($data->created_at))}}</small></div>
                               <div style="font-size: 14px;font-weight: bold;">{{$data->name}}</div>
                               <div>{{$data->note}}</div>
                            </a>
                         </td>
                         <td align="right">
                            <a href="#!" class="btn-loading" style="color: #464646">
                               <div><i class="fa fa-clock-o"></i> <small>{{date("H:m:s", strtotime($data->created_at))}}</small></div>
                               <div>Rp {{number_format($data->komisi, 0, '.', '.')}}</div>
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
               
           </div>
         </div><!-- /.box -->
     </div>
   </div>
</section>
@endsection
@section('js')
<script>
$(document).ready(function() {
    var table_bonus = $('#DataTable_bonus').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
        autoHight: true,
        info: false,
        ajax:{
            url : "{{ route('get.komisi-trx-ref.datatablesOne') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        sDom: '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        columns:[
                  {data: 'no', width: "50px", sClass: "text-left", orderable: false},
                  {data: 'name', defaulContent: '-' },
                  {data: 'note', defaulContent: '-' },
                  {data: 'komisi', defaulContent: '-' , sClass: "text-right"},
                  {data: 'created_at', defaulContent: '-' },
                ]
     });
     table_bonus.on( 'order.dt search.dt', function () {
        table_bonus.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
        } );
     }).draw();

    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
        autoHight: true,
        info: false,
        ajax:{
            url : "{{ route('get.komisi-trx-ref.datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        sDom: '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        columns:[
                  {data: 'no', width: "50px", sClass: "text-left", orderable: false},
                  {data: 'name', defaulContent: '-' },
                  {data: 'note', defaulContent: '-' },
                  {data: 'komisi', defaulContent: '-' , sClass: "text-right"},
                  {data: 'created_at', defaulContent: '-' },
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