@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembelian <small>Operator</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pembelian</a></li>
        <li><a href="{{route('pembelian-operator.index')}}" class="btn-loading"> Operator</a></li>
    	<li class="active">Tambah Operator</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('pembelian-operator.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah Operator</h3>
                </div>
                <form role="form" action="{{route('pembelian-operator.store')}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('kategori') ? ' has-error' : '' }}">
                            <label>Kategori : </label>
                            <select name="kategori" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $data)
                                <option value="{{$data->id}}">{{$data->product_name}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('kategori', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label>ID Server : </label>
                            <input type="text" class="form-control" name="product_id"  placeholder="Masukkan ID Operator Server">
                            {!! $errors->first('product_id', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label>Nama Operator : </label>
                            <input type="text" class="form-control" name="product_name"  placeholder="Masukkan Nama Operator">
                            {!! $errors->first('product_name', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
                            <label>Nomor Prefix : </label>
                            <input type="text" class="form-control" name="prefix"  placeholder="Masukkan Nomor Prefix Operator">
                            {!! $errors->first('prefix', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('img_url') ? ' has-error' : '' }}">
                            <label>URL Gambar : </label>
                            <input type="text" class="form-control" name="img_url"  placeholder="Masukkan URL Gambar Operator">
                            {!! $errors->first('img_url', '<p class="help-block"><small>:message</small></p>') !!}
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
                    <h3 class="box-title">Data Operator 10 Terakhir</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" style="font-size: 13px;">
                        <tr class="text-primary">
                            <th>No</th>
                            <th>Nama Operator</th>
                            <th>Kategori</th>
                            <th>Update Terakhir</th>
                        </tr>
                        <?php $no=1; ?>
                        @if($operators->count() > 0)
                        @foreach($operators as $data)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$data->product_name}}</td>
                            <td>{{$data->pembeliankategori->product_name}}</td>
                            <td>{{$data->updated_at}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" style="text-align: center;font-size: 12px;font-style: italic;background-color: #F5F5F5">Data tidak tersedia</td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection