@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Transaksi <small>Tagihan Pembayaran</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Transaksi</a></li>
 	<li class="active">Tagihan</li>
</ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Tagihan Pembayaran</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable" class="table table-hover">
                        <thead>
                            <tr class="custom__text-green" style="font-size: 13px;">
                                <th>ID Tagihan</th>
                                <th>Produk & ID Pelanggan</th>
                                <th>Nama</th>
                                <th>Jumlah Bayar & Periode</th>
                                <th>Pengirim</th>
                                <th>Via</th>
                                <th>Status</th>
                                <th>Expired</th>
                                <th>Tanggal</th>
                                <th colspan="2">#</th>
                            </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box"> 
                <div class="box-header">
                    <h3 class="box-title">Data Tagihan Pembayaran</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @foreach($tagihanMobile as $data)
                        <tr>
                            <td>
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->created_at}}</small></div>
                                <div><small>ID : #{{$data->tagihan_id}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->product_name}}</div>
                                <div>{{$data->no_pelanggan}}</div>
                                <div>{{$data->nama}}</div>
                                <div><code>{{$data->via}}</code></div>
                            </td>
                            <td align="right" style="width:40%;">
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->updated_at}}</small></div>
                                <div>Rp {{number_format($data->jumlah_bayar, 0, '.', '.')}}</div>
                                <div><a href="{{url('/admin/users', $data->user->id)}}" class="btn-loading"><small>{{$data->user->name}}</small></a></div>
                                @if($data->status == 0)
                                <div><label class="label label-warning">MENUNGGU</label></div>
                                @elseif($data->status == 1)
                                <div><label class="label label-primary">PROSES</label></div>
                                @elseif($data->status == 2)
                                <div><span class="label label-success">BERHASIL</span></div>
                                @else
                                <div><span class="label label-danger">GAGAL</span></div>
                                @endif
                                <div style="margin-top:5px;">
                                    <form method="POST" action="{{ url('/admin/transaksi/tagihan/hapus', $data->id) }}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a href="{{url('/admin/transaksi/tagihan', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        info: false,
        ajax:{
            url : "{{ url('/admin/transaksi/tagihan/datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        columns:[
                  {data: 'tagihan_id', defaulContent: '-' },
                  {data: 'product_name', defaulContent: '-' },
                  {data: 'nama', defaulContent: '-'},
                  {data: 'jumlah_bayar', defaulContent: '-' },
                  {data: 'pengirim', defaulContent: '-' },
                  {data: 'via', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: 'expired', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: "action_detail", defaultColumn: "-", orderable: false, searchable: false},
                  {data: "action_hapus", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
});
</script>
@endsection