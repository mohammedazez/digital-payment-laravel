@extends('layouts.admin')
@section('meta')
<meta http-equiv="refresh" content="300">
@endsection
@section('content')
<section class="content-header hidden-xs hidden-sm">
    <h1>Transaksi <small>Saldo Paypal</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Transaksi</a></li>
        <li class="active">Saldo Paypal</li>
    </ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                   <h3 class="box-title">Saldo Paypal</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable"  class="table table-hover">
                      <thead>
                         <tr class="custom__text-green">
                            <th>No.</th>
                            <th>ID</th>
                            <!--<th>Trx.ID</th>-->
                            <th>Name</th>
                            <th>Addres Paypal</th>
                            <th>Rate</th>
                            <th>Nominal USD</th>
                            <!--<th>Nominal IDR</th>-->
                            <th>Fee</th>
                            <th>Total</th>
                            <th>Transaksi Kode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>#</th>
                         </tr>
                      </thead>
                  <tbody>
                  </tbody>
               </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div>
    <div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box"> 
                <div class="box-header">
                    <h3 class="box-title">Saldo Paypal</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @foreach($antrianMobile as $data)
                        <tr>
                            <td>
                                <div><i class="fa fa-calendar"></i><small> {{date("d M Y", strtotime($data->created_at))}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">#{{$data->id}}</div>
                                <div>{{$data->user->name}}</div>
                                <div>Addres Paypal: {{$data->address_paypal}}</div>
                                <div>Rate: {{$data->rate}}</div>
                                <div>Fee Paypal: {{$data->fee}}</div>
                                <div>Total: {{$data->total}}</div>
                            </td>
                            <td align="right" style="width:35%;">
                                <div><i class="fa fa-clock-o"></i><small> {{date("H:i:s", strtotime($data->created_at))}}</small></div>
                                @if($data->status == 0)
                                <div><span class="label label-warning">PROSES</span></div>
                                @elseif($data->status == 1)
                                <div><span class="label label-success">BERHASIL</span></div>
                                @elseif($data->status == 2)
                                <div><span class="label label-danger">GAGAL</span></div>
                                @elseif($data->status == 3)
                                <div><span class="label label-primary">REFUND</span></div>
                                @endif
                                <div style="margin-top:5px;">
                                    <a href="{{url('/admin/transaksi/saldo-paypal', $data->id)}}" class="btn-loading label label-primary">DETAIL</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer" align="center" style="padding-top:13px;">
                   @include('pagination.default', ['paginator' => $antrianMobile])
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
        // deferRender: true,
        processing: true,
        serverSide: false,
        autoWidth: false,
        info: false,
        ajax:{
            url : "{{ url('admin/transaksi/paypal/get-data') }}",
        },
        columns:[
                  {data: null, width: "50px", sClass: "text-center", orderable: false},
                  {data: 'id', defaulContent: '-' },
                //   {data: 'trxid', defaulContent: '-' },
                  {data: 'name', defaulContent: '-'},
                  {data: 'address_paypal', defaulContent: '-'},
                  {data: 'rate', defaulContent: '-'},
                  {data: 'nominal_usd', defaulContent: '-', sClass: "text-right"},
                //   {data: 'nominal_idr', defaulContent: '-', sClass: "text-right"},
                  {data: 'fee', defaulContent: '-', sClass: "text-right"},
                  {data: 'total', defaulContent: '-', sClass: "text-right"},
                  {data: 'transaksi_code', defaulContent: '-'},
                  {data: 'status', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: "action", defaultColumn: "-", orderable: false, searchable: false},
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