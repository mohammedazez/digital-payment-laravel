@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Tagihan <small>Pembayaran</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Tagihan Pembayaran</li>
   </ol>
   </section>
   <section class="content">
      <div class="row hidden-xs hidden-sm">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Tagihan Pembayaran</h3>
               </div><!-- /.box-header -->
               <div class="box-body table-responsive">
               <table id="DataTable"  class="table table-hover">
                  <thead>
                     <tr class="custom__text-green">
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Nomor / ID Pelanggan</th>
                        <th>Nama</th>
                        <th>Periode</th>
                        <th>Via</th>
                        <th>Status</th>
                        <th>Expired</th>
                        <th>Tanggal</th>
                        <th>#</th>
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
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Tagihan Pembayaran</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($tagihanMobile->count() > 0)
                  @foreach($tagihanMobile as $data)
                    <tr>
                        <td>
                            <a href="{{url('/member/tagihan-pembayaran', $data->id)}}" class="btn-loading" style="color: #464646">
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->created_at}}</small></div>
                                <div><small>ID : #{{$data->tagihan_id}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->product_name}}</div>
                                <div>{{$data->no_pelanggan}}</div>
                                <div><code>{{$data->via}}</code></div>
                            </a>
                        </td>
                        <td align="right" style="width:40%;">
                            <a href="{{url('/member/tagihan-pembayaran', $data->id)}}" class="btn-loading" style="color: #464646">
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->updated_at}}</small></div>
                                <div style="text-transform: capitalize;">{{$data->nama}}</div>
                                <div>Rp {{number_format($data->jumlah_bayar, 0, '.', '.')}}</div>
                                @if($data->status == 0)
                                <div><label class="label label-warning">MENUNGGU</label></div>
                                @elseif($data->status == 1)
                                <div><label class="label label-primary">PROSES</label></div>
                                @elseif($data->status == 2)
                                <div><span class="label label-success">BERHASIL</span></div>
                                @else
                                <div><span class="label label-danger">GAGAL</span></div>
                                @endif
                            </a>
                         <div>
                            @if($data->status == 0)
                            <a href="{{url('/member/tagihan-pembayaran', $data->id)}}" class="btn-loading label label-primary">Bayar</a>
                            @elseif($data->status == 1)
                            <a href="{{url('/member/tagihan-pembayaran', $data->id)}}" class="btn-loading label label-primary">Detail</a>
                            @elseif($data->status == 2)
                            <a href="{{url('/member/tagihan-pembayaran', $data->id)}}" class="btn-loading label label-primary">Detail</a>
                            @else
                            <a href="{{url('/member/tagihan-pembayaran', $data->id)}}" class="btn-loading label label-primary">Detail</a>
                            @endif
                          </div>
                            
                        </td>
                    </tr>
                  @endforeach
                  @else
                  <tr>
                      <td colspan="2" style="text-align:center;font-style:italic;">Tagihan Pembayaran belum tersedia</td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            <div class="box-footer" align="center" style="padding-top:13px;">
               @include('pagination.default', ['paginator' => $tagihanMobile])
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
            url : "{{ route('get.tagihan-pembayaran.datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        columns:[
                  {data: 'no', sClass: "text-left", orderable: false},
                  {data: 'product_name', defaulContent: '-' },
                  {data: 'no_pelanggan', defaulContent: '-' },
                  {data: 'nama', defaulContent: '-'},
                  {data: 'periode', defaulContent: '-' },
                  {data: 'via', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: 'expired', defaulContent: '-' },
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