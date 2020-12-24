@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembayaran <small>Operator</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;"> Pembayaran</a></li>
        <li><a href="{{route('pembayaran-operator.index')}}" class="btn-loading"> Operator</a></li>
    	<li class="active">Tambah Operator</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('pembayaran-operator.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah Operator</h3>
                </div>
                <form role="form" action="{{route('pembayaran-operator.store')}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('kategori') ? ' has-error' : '' }}">
                            <label>Kategori Pembayaran : </label>
                            <select name="kategori" class="form-control">
                                <option value="">-- Pilih Kategori Pembayaran --</option>
                                @foreach($kategori as $data)
                                <option value="{{$data->id}}">{{$data->product_name}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('status', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label>Nama Operator : </label>
                            <input type="text" class="form-control" name="product_name"  placeholder="Masukkan Nama Kategori">
                            {!! $errors->first('product_name', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label>Status Operator : </label>
                            <select name="status" class="form-control">
                                <option value="1">AKTIF</option>
                                <option value="0">TIDAK AKTIF</option>
                            </select>
                            {!! $errors->first('status', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
                <div class="box-header">
                    <i class="fa fa-server"></i>
                    <h3 class="box-title">Data Operator Pembayaran</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="text-primary">
                            <th>Nama Operator</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                        @if($operator->count() > 0)
                        @foreach($operator as $data)
                        <tr>
                            <td>{{$data->product_name}}</td>
                            <td>{{$data->pembayarankategori->product_name}}</td>
                            @if($data->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" style="text-align: center;font-size: 13;font-style: italic;background-color: #F8F6F6">Data tidak ditemukan</td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection