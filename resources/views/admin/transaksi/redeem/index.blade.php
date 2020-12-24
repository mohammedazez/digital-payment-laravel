@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Transaksi <small>Redeem Voucher</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
 	<li><a href="#">Transaksi</a></li>
 	<li class="active">Data Redeem Voucher</li>
</ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Redeem Voucher</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="" class="table table-hover">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode Voucher</th>
                                <th>Tanggal</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody class="read">
                            <?php $no=1; ?>
                            @if($redeem->count() > 0)
                            @foreach($redeem as $data)
                            <tr style="font-size: 13px;">
                                <td>{{$no++}}</td>
                                <td><div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="{{url('/admin/users', $data->user['id'])}}" class="btn-loading">{{$data->user['name']}}</a></div></td>
                                <td>{{$data->voucher->code}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <form method="POST" action="{{ url('/admin/transaksi/redeem/hapus', $data->id) }}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a href="{{url('/admin/transaksi/redeem/detail', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Detail</i></a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='10' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
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
     "info": false
   });
});
</script>
@endsection