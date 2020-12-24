@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Data <small>Voucher</small></h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Voucher</li>
</ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="hidden-xs">Voucher</span></h3>
                    <div class="box-tools">
                        <a href="{{route('voucher.create')}}" class="btn-loading btn btn-primary" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable" class="table table-striped table-consended" style="font-size:12px;">
                        <thead>
                            <tr class="custom__text-green text-center">
                                <th>No</th>
                                <th>Code</th>
                                <th>Bonus (saldo)</th>
                                <th>Exp Date</th>
                                <th>Qty</th>
                                <th>Use</th>
                                <th>Status</th>
                                <th>F.Membership</th>
                                <th>F.Date Reg User</th>
                                <th>F.Verified/Non Verified</th>
                                <th>F.Min Saldo</th>
                                <th>F.Max Saldo</th>
                                <th>Tanggal pembuatan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody class="read">
                            <?php $no=1; ?>
                            @foreach($voucher as $data)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$data->code}}</td>
                                <td>Rp {{number_format($data->bonus, 0, '.', '.')}}</td>
                                <td>{{date('d-m-Y', strtotime($data->expired_date))}}</td>
                                <td>{{$data->qty}}</td>
                                <td>{{$data->use_kupon}}</td>
                                @if($data->status == 1)
                                <td><label class="label label-success">AKTIF</label></td>
                                @else
                                <td><label class="label label-danger">TIDAK AKTIF</label></td>
                                @endif
                                
                                @if($data->filter_level_user == 1)
                                    <td class="text-center">
                                        <label class="label label-success">YES</label>
                                        @if($data->value_level_user == 1)
                                            <br><span class="text-muted">MEMBERSHIP PERSONAL</span>
                                        @elseif($data->value_level_user == 3)
                                            <br><span class="text-muted">MEMBERSHIP AGEN</span>
                                        @elseif($data->value_level_user == 4)
                                            <br><span class="text-muted">MEMBERSHIP ENTERPRISE</span>
                                        @endif
                                    </td>
                                @else
                                    <td class="text-center"><label class="label label-danger">NO</label></td>
                                @endif
                                
                                @if($data->filter_datereg_user == 1)
                                    <td class="text-center"><label class="label label-success">YES</label><br><span class="text-muted">{{date("d-m-Y", strtotime($data->value_datereg_user))}}</span></td>
                                @else
                                    <td class="text-center"><label class="label label-danger">NO</label></td>
                                @endif
                                @if($data->filter_verified == 1)
                                    <td class="text-center"><label class="label label-success">YES</label><br><span class="text-muted">{{$data->value_verified}}</span></td>
                                @else
                                    <td class="text-center"><label class="label label-danger">NO</label></td>
                                @endif
                                @if($data->filter_saldo == 1)
                                    <td class="text-center"><label class="label label-success">YES</label><br><span class="text-muted">Rp {{number_format($data->value_saldo, 0, '.', '.')}}</span></td>
                                @else
                                    <td class="text-center"><label class="label label-danger">NO</label></td>
                                @endif
                                @if($data->filter_saldo_max == 1)
                                    <td class="text-center"><label class="label label-success">YES</label><br><span class="text-muted">Rp {{number_format($data->value_saldo_max, 0, '.', '.')}}</span></td>
                                @else
                                    <td class="text-center"><label class="label label-danger">NO</label></td>
                                @endif
                                
                                <td>{{date('d-m-Y H:i:s', strtotime($data->created_at))}}</td>
                                <td>
                                    <form method="POST" action="{{ route('voucher.destroy', $data->id) }}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <a href="{{ route('voucher.edit', $data->id) }}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size:10px;">Ubah</i></a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div><div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Produk</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @if($voucher->count() > 0)
                        @foreach($voucher as $data)
                        <tr>
                            <td>
                                <div><small>{{$data->code}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->code}}</div>
                                <div>{{$data->bonus}}</div>
                            </td>
                            <td align="right" style="width:35%;">
                                <div><small>ID : #{{$data->id}}</small></div>
                                <div>{{$data->code}}</div>
                                @if($data->status == 1)
                                <div><span class="label label-success">Tersedia</span></div>
                                @else
                                <div><span class="label label-danger">Gangguan</span></div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="colspan" style="text-align:center;font-style:italic;">produk tidak tersedia</td>
                        </tr>
                        @endif
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
     "info": false
   });
});
</script>
@endsection