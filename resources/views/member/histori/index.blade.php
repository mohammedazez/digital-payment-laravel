@extends('layouts.member')
@section('meta')
<meta http-equiv="refresh" content="30">
@endsection
@section('content')
<section class="content-header hidden-xs">
  <h1>Riwayat <small>Transaksi</small></h1>
   <ol class="breadcrumb">
      <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Riwayat Transaksi</li>
   </ol>
   </section>
   <section class="content">
      <div class="row hidden-xs hidden-sm">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Riwayat Transaksi</h3>
               </div><!-- /.box-header -->
               <div class="box-body table-responsive">
               <table id="DataTable"  class="table table-hover">
                  <thead>
                     <tr class="custom__text-green">
                        <th>No.</th>
                        <th>ID Trans</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>No Pengisian</th>
                        <th>IDPel</th>
                        <th>Pengirim</th>
                        <th>Via</th>
                        <th>Tanggal</th>
                        <th>Status</th>
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
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Riwayat Transaksi</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($transaksisMobile->count() > 0)
                  @foreach($transaksisMobile as $data)
                  <tr>
                     <td>
                        <a href="{{url('/member/riwayat-transaksi', $data->id)}}" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-calendar"></i> <small>{{date("d M Y", strtotime($data->created_at))}}</small></div>
                           <div style="font-size: 14px;font-weight: bold;">{{$data->produk}}</div>
                           <div>{{$data->target}}</div>
                           <div>{{$data->mtrpln}}</div>
                           <div><code>{{$data->via}}</code></div>
                        </a>
                     </td>
                     <td align="right">
                        <a href="{{url('/member/riwayat-transaksi', $data->id)}}" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-clock-o"></i> <small>{{date("H:m:s", strtotime($data->created_at))}}</small></div>
                           <div>Rp {{number_format($data->total, 0, '.', '.')}}</div>
                           <div>{{$data->pengirim}}</div>
                           @if($data->status == 0)
                           <div><span class="label label-warning">PROSES</span></div>
                           @elseif($data->status == 1)
                           <div><span class="label label-success">BERHASIL</span></div>
                           @elseif($data->status == 2)
                           <div><span class="label label-danger">GAGAL</span></div>
                           @elseif($data->status == 3)
                           <div><span class="label label-primary">REFUND</span></div>
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
               @include('pagination.default', ['paginator' => $transaksisMobile])
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
            url : "{{ route('get.riwayat.datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        columns:[
                  {data: 'no', sClass: "text-left", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'produk', defaulContent: '-' },
                  {data: 'total', defaulContent: '-' , sClass: "text-right"},
                  {data: 'target', defaulContent: '-' },
                  {data: 'mtrpln', defaulContent: '-' },
                  {data: 'pengirim', defaulContent: '-' },
                  {data: 'via', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: "action", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
});
</script>
@endsection