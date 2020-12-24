@extends('layouts.admin')
@section('meta')
<meta http-equiv="refresh" content="60">
@endsection
@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Transaksi <small>Produk</small></h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Transaksi</a></li>
    <li class="active">Produk</li>
</ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Transaksi Produk</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable" class="table table-hover">
                        <thead>
                            <tr class="custom__text-green" style="font-size: 13px;">
                                <th>No</th>
                                <th>ID Order</th>
                                <th>Produk & NoHP</th>
                                <th>ID Pelanggan</th>
                                <th>Pengirim</th>
                                <th>Via</th>
                                <th>Tgl Request</th>
                                <th>Tgl Updated</th>
                                <th>Status</th>
                                <th colspan="2">#</th>
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
                    <h3 class="box-title">Data Transaksi Produk</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @foreach($transaksiProdukMobile as $data)
                        <tr>
                            <td>
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->created_at}}</small></div>
                                <div><small>ID : #{{$data->id}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->produk}}</div>
                                <div>{{$data->target}}</div>
                                <div>{{$data->mtrpln}}</div>
                                <div><code>{{$data->via}}</code></div>
                            </td>
                            <td align="right" style="width:40%;">
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->updated_at}}</small></div>
                                <div><small>ID Trx : 
                                    @if($data->order_id == 0)
                                    -
                                    @else
                                    #{{$data->order_id}}
                                    @endif</small></div>
                                <div><a href="{{url('/admin/users', $data->user->id)}}" class="btn-loading"><small>{{$data->user->name}}</small></a></div>
                                @if($data->status == 0)
                                <div><label class="label label-warning">PROSES</label></div>
                                @elseif($data->status == 1)
                                <div><label class="label label-success">BERHASIL</label></div>
                                @elseif($data->status == 2)
                                <div><span class="label label-danger">GAGAL</span></div>
                                @elseif($data->status == 3)
                                <div><span class="label label-primary">REFUND</span></div>
                                @endif
                                <div style="margin-top:5px;">
                                    <form method="POST" action="{{ url('/admin/transaksi/produk/hapus', $data->id) }}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a href="{{url('/admin/transaksi/produk', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer" align="center" style="padding-top:13px;">
                   @include('pagination.default', ['paginator' => $transaksiProdukMobile])
               </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        // serverSide: false,
        serverSide: true,
        autoWidth: false,
        info: false,
        ajax:{
             url: "{{ url('/admin/transaksi/produk/datatables') }}",
             dataType: "json",
             type: "POST",
             data:{ _token: "{{csrf_token()}}"}
           },

        // order: [[ 7, "desc" ]],
        columns:[
                  {data: 'no', width: "50px", sClass: "text-center", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'produk', defaulContent: '-' },
                  {data: 'mtrpln', defaulContent: '-'},
                  {data: 'pengirim', defaulContent: '-' },
                  {data: 'via', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: 'updated_at', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: "action_detail", defaultColumn: "-", orderable: false, searchable: false},
                  {data: "action_hapus", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
     // table.on( 'order.dt search.dt', function () {
     //    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
     //      cell.innerHTML = i+1;
     //    } );
     // }).draw();
});
</script>
@endsection