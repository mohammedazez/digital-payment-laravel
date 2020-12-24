@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembayaran <small>Kategori</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;"> Pembayaran</a></li>
        <li><a href="{{route('pembayaran-operator.index')}}" class="btn-loading"> Kategori</a></li>
    	<li class="active">Tambah Kategori</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-green">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('pembayaran-operator.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Ubah Kategori</h3>
                </div>
                <form role="form" action="{{route('pembayaran-operator.update', $operator->id)}}" method="post">
                <input name="_method" type="hidden" value="PATCH">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('kategori') ? ' has-error' : '' }}">
                            <label>Kategori Pembayaran : </label>
                            <select name="kategori" class="form-control">
                                <option value="">-- Pilih Kategori Pembayaran --</option>
                                @foreach($kategori as $data)
                                <option value="{{$data->id}}" {{ $operator->pembayarankategori_id == $data->id ? 'selected' : '' }}>{{$data->product_name}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('kategori', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label>Nama Operator : </label>
                            <input type="text" class="form-control" name="product_name" value="{{$operator->product_name ?? old('product_name')}}"  placeholder="Masukkan Nama Kategori">
                            {!! $errors->first('product_name', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label>Status Operator : </label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $operator->status == 1 ? 'selected' : '' }}>AKTIF</option>
                                <option value="0" {{ $operator->status == 0 ? 'selected' : '' }}>TIDAK AKTIF</option>
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
                        <tr class="custom__text-green">
                            <th>Nama Operator</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                        @if($operators->count() > 0)
                        @foreach($operators as $data)
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