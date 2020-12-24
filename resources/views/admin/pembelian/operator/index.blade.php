@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembelian <small>Operator</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pembelian</a></li>
    	<li class="active">Operator</li>
    </ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Operator</h3>
                    <!--<a href="{{route('pembelian-operator.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Kategori" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>-->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="DataTable" class="table table-hover">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No</th>
                                <th>ID</th>
                                <th>ID Server</th>
                                <th>Nama Operator</th>
                                <th>Kategori</th>
                                <th>Jumlah Produk</th>
                                <th>Update Terakhir</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; ?>
                        @if($operators->count() > 0)
                        @foreach($operators as $data)
                        <tr style="font-size: 14px;">
                            <td>{{$no++}}</td>
                            <td>{{$data->id}}</td>
                            <td>{{$data->product_id}}</td>
                            <td>{{$data->product_name}}</td>
                            <td>{{$data->pembeliankategori->product_name}}</td>
                            <td>{{$data->pembelianproduk->count()}}</td>
                            <td>{{$data->updated_at}}</td>
                            @if($data->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>
                               <form method="POST" action="{{ route('pembelian-operator.destroy', $data->id) }}" accept-charset="UTF-8">
                                  <input name="_method" type="hidden" value="DELETE">
                                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                  <a href="{{route('pembelian-operator.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                  <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                               </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" style="text-align: center;font-size: 12px;font-style: italic;background-color: #F5F5F5">Data tidak tersedia</td>
                        </tr>
                        @endif
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
                    <h3 class="box-title"><a href="{{url('/admin')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Data Operator</h3>
                    <a href="{{route('pembelian-operator.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Kategori" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @foreach($operators as $data)
                        <tr>
                            <td>
                                <div><small>ID : #{{$data->id}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->product_name}}</div>
                                <div>{{$data->pembeliankategori->product_name}}</div>
                            </td>
                            <td align="right">
                                <div><small>ID Product : #{{$data->product_id}}</small></div>
                                <div><span class="label label-success">AKTIF</span></div>
                                <div style="margin-top:5px;">
                                    <form method="POST" action="{{ route('pembelian-operator.destroy', $data->id) }}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a href="{{route('pembelian-operator.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
   </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
$(function () {
   $('#DataTable').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
     "iDisplayLength": 50,
     "searching": false,
     "lengthChange": false,
     "info": false,
     "order": [[ 0, "asc" ]]
   });
});
</script>
@endsection