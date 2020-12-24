@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembelian <small>Kategori</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pembelian</a></li>
    	<li class="active">Kategori</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Kategori</h3>
                    <!--<a href="{{route('pembelian-kategori.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Kategori" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>-->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No. Urut</th>
                                <th>ID</th>
                                <th>ID (Server)</th>
                                <th>Nama Kategori</th>
                                <th>Icon</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($kategoris as $data)
                        <tr style="font-size: 14px;">
                            <td>{{$data->sort_product}}</td>
                            <td>{{$data->id}}</td>
                            <td>{{$data->product_id}}</td>
                            <td>{{$data->product_name}}</td>
                            <td><i class="fa fa-{{ $data->icon }}"></i></td>
                            @if($data->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>
                                <form method="POST" action="{{ route('pembelian-kategori.destroy', $data->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{route('pembelian-kategori.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection