@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembayaran <small>Operator</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;"> Pembayaran</a></li>
    	<li class="active">Operator</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Opearator</h3>
                    <!--<a href="{{route('pembayaran-operator.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Operator" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>-->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="custom__text-green">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Operator</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php $no=1; ?>
                        @if($operator->count() > 0)
                        @foreach($operator as $data)
                        <tr style="font-size: 14px;">
                            <td>{{$no++}}</td>
                            <td>{{$data->id}}</td>
                            <td>{{$data->product_name}}</td>
                            <td>{{$data->pembayarankategori->product_name}}</td>
                            @if($data->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>
                                <form method="POST" action="{{ route('pembayaran-operator.destroy', $data->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{route('pembayaran-operator.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" style="text-align: center;font-size: 13px;font-style: italic;background-color: #F8F8F8">Data tidak tersedia</td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    @include('pagination.default', ['paginator' => $operator])
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection