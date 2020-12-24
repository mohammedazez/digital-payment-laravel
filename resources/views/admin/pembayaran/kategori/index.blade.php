@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembayaran <small>Kategori</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;"> Pembayaran</a></li>
    	<li class="active">Kategori</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Kategori</h3>
                    <!--<a href="{{route('pembayaran-kategori.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Kategori" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>-->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="custom__text-green">
                            <th>No. Urut</th>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($kategori as $data)
                        <tr style="font-size: 14px;">
                            <td>{{$data->sort_product}}</td>
                            <td>{{$data->id}}</td>
                            <td>{{$data->product_name}}</td>
                            <td><img width="20px" src="{{ url('assets/images/icon_web/'.$data->icon) }}"></td>
                            @if($data->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>
                                <form method="POST" action="{{ route('pembayaran-kategori.destroy', $data->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{route('pembayaran-kategori.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    @include('pagination.default', ['paginator' => $kategori])
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection