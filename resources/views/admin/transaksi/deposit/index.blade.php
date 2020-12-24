@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
    <h1>Transaksi <small>Deposit Saldo</small></h1>
    <ol class="breadcrumb">
     	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Transaksi</a></li>
     	<li class="active">Deposit</li>
    </ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Request Deposit</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable" class="table table-hover" style="font-size: 13px;">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No</th>
                                <th>ID Deposit</th>
                                <th>Bank</th>
                                <th>Nominal Transfer</th>
                                <th>Status</th>
                                <th>Expire</th>
                                <th>User</th>
                                <th>Tanggal</th>
                                <th colspan="2">#</th>
                            </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div>
    <div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box"> 
                <div class="box-header">
                    <h3 class="box-title">Data Transaksi Produk</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @foreach($depositsMobile as $data)
                        <tr>
                            <td>
                                <div style="font-size:12px;"><i class="fa fa-calendar"></i><small> {{$data->created_at}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->bank->nama_bank}}</div>
                                @if($data->status == 0)
                                <div><label class="label label-warning">MENUNGGU</label></div>
                                @elseif($data->status == 1)
                                <div><label class="label label-success">BERHASIL</label></div>
                                @elseif($data->status == 3)
                                <div><label class="label label-primary">VALIDASI</label></div>
                                @elseif($data->status == 2)
                                <div><label class="label label-danger">GAGAL</label></div>
                                @endif
                                <div><a href="{{url('/admin/users', $data['user']['id'])}}" class="btn-loading"><small>{{$data['user']['name']}}</small></a></div>
                            </td>
                            <td align="right">
                                <div style="font-size:12px;">ID : #{{$data['id']}}</div>
                                <div>Rp {{number_format($data->nominal_trf, 0, '.', '.')}}</div>
                                @if($data->expire == 1)
                                <div><label class="label label-info">AKTIF</label></div>
                                @else
                                <div><label class="label label-danger">EXPIRED</label></div>
                                @endif
                                <div style="margin-top:5px;">
                                    <form method="POST" action="{{url('/admin/transaksi/deposit/hapus', $data['id'])}}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a href="{{url('/admin/transaksi/deposit/show', $data['id'])}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer" align="center" style="padding-top:13px;">
                   @include('pagination.default', ['paginator' => $depositsMobile])
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
            url : "{{ url('/admin/transaksi/deposit/datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        columns:[
                  {data: 'no', width: "50px", sClass: "text-center", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'nama_bank', defaulContent: '-' },
                  {data: 'nominal_trf', defaulContent: '-'},
                  {data: 'status', defaulContent: '-' },
                  {data: 'expire', defaulContent: '-' },
                  {data: 'name', defaulContent: '-' },
                  {data: 'updated_at', defaulContent: '-' },
                  {data: "action_detail", defaultColumn: "-", orderable: false, searchable: false},
                  {data: "action_hapus", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
});
</script>
@endsection