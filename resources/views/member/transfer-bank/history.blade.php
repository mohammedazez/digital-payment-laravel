@extends('layouts.member')
@section('meta')
<meta http-equiv="refresh" content="300">
@endsection
@section('content')
<section class="content-header hidden-xs">
  <h1>Riwayat <small>Transfer Bank</small></h1>
   <ol class="breadcrumb">
      <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Riwayat Transfer Bank</li>
   </ol>
   </section>
   <section class="content">
      <div class="row hidden-xs hidden-sm">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Riwayat Transfer Bank</h3>
               </div><!-- /.box-header -->
               <div class="box-body table-responsive">
               <table id="DataTable"  class="table table-hover">
                  <thead>
                     <tr class="custom__text-green">
                        <th>No.</th>
                        <!-- <th>ID TransS</th> -->
                        <th>Penerima</th>
                        <th>Nominal</th>
                        <th>Code Bank</th>
                        <th>Bank</th>
                        <th>NO Rekening</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th colspan="3">#</th>
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
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Riwayat Transfer Bank</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($transaksisMobile->count() > 0)
                  @foreach($transaksisMobile as $data)
                  <tr>
                     <td>
                        <a href="#" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-calendar"></i> <small>{{date("d M Y", strtotime($data->created_at))}}</small></div>
                           <div style="font-size: 14px;font-weight: bold;">Rek: {{$data->no_rekening}}</div>
                           <div>Kode: {{$data->code_bank}}</div>
                           <div>Bank: {{$data->jenis_bank}}</div>
                           <div><span class="label label-primary">Rp {{number_format($data->nominal, 0, '.', '.')}}</span></div>
                        </a>
                     </td>
                     
                     <td align="right">
                        <a href="#" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-clock-o"></i> <small>{{date("H:m:s", strtotime($data->created_at))}}</small></div>
                           <div><a href="'.url('/member/transfer-bank/show', $data->id).'" class="btn-loading btn custom__btn-greenHover btn-sm" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-search fa-fw"></i></i></a></div>
                           <div><a href="'.url('/member/transfer-bank/print', $data->id).'" class="btn-loading btn custom__btn-greenHover btn-sm" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-print fa-fw"></i></i></a></div>
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
    $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
    {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };
    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        info: false,
        ajax:{
            url : "{{ url('/member/transfer-bank/history/datatables') }}",
        },
        
        "rowCallback": function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
        columns:[
                  {data: null, width: "50px", sClass: "text-left", orderable: false},
                  {data: 'penerima', defaulContent: '-'},
                  {data: 'nominal', defaulContent: '-'},
                  {data: 'code_bank', defaulContent: '-'},
                  {data: 'jenis_bank', defaulContent: '-'},
                  {data: 'no_rekening', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: 'action_print', defaulContent: '-' },
                  {data: 'action_detail', defaulContent: '-' }
                ]
     });
});
</script>
@endsection