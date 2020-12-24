@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembayaran <small>Produk</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;"> Pembayaran</a></li>
        <li><a href="{{url('/admin/pembayaran-produk')}}" class="btn-loading"> Produk</a></li>
        <li><a href="{{url('/admin/pembayaran-produk', $kategori->slug)}}" class="btn-loading"> {{$kategori->product_name}}</a></li>
    	<li class="active">Ubah Produk</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/admin/pembayaran-produk', $kategori->slug)}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Ubah Produk</h3>
                </div>
                <form role="form" action="{{url('/admin/pembayaran-produk/update/'.$produk->id)}}" method="post">
                <input name="_method" type="hidden" value="PATCH">
                {{csrf_field()}}
                    <div class="box-body">
                        <input type="hidden" name="kategori" value="{{$kategori->id}}">
		                    <input type="hidden" name="kategori_slug" value="{{$kategori->slug}}">
                        <div class="form-group{{ $errors->has('operator') ? ' has-error' : '' }}">
                            <label>Operator : </label>
                            <select name="operator" class="form-control">
                                <option value="">-- Pilih Operator Pembayaran --</option>
                                @foreach($operator as $data)
                                <option value="{{$data->id}}" {{ $produk->pembayaranoperator_id == $data->id ? 'selected' : '' }}>{{$data->product_name}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('operator', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                            <label>Nama Produk : </label>
                            <input type="text" class="form-control" name="product_name" value="{{$produk->product_name ?? old('product_name')}}" placeholder="Masukkan Nama Produk">
                            {!! $errors->first('product_name', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label>Kode Produk : </label>
                            <input type="text" class="form-control" name="code" value="{{$produk->code ?? old('code')}}" placeholder="Masukkan Kode Produk">
                            {!! $errors->first('code', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group">
                            <label>Biaya Default (Server) : </label>
                            <input type="text" class="form-control" id="biaya_default" value="{{number_format($produk->price_default, 0, '.', '.')}}" readonly disabled>
                        </div>
                        <div class="form-group{{ $errors->has('markup') ? ' has-error' : '' }}">
                            <label>Markup Biaya : </label>
                            <input type="text" class="form-control" name="markup" id="markup" value="{{number_format($produk->markup, 0, '.', '.')}}" placeholder="Masukkan Biaya Admin">
                            {!! $errors->first('markup', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group">
                            <label>Biaya Admin : </label>
                            <input type="text" class="form-control" id="biaya_admin" value="{{number_format($produk->price_markup, 0, '.', '.')}}" readonly disabled>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label>Status Produk : </label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $produk->status == 1 ? 'selected' : '' }}>Tersedia</option>
                                <option value="0" {{ $produk->status == 0 ? 'selected' : '' }}>Gangguan</option>
                            </select>
                            {!! $errors->first('status', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="submit btn btn-primary btn-block">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
                <div class="box-header">
                    <i class="fa fa-server"></i>
                    <h3 class="box-title">Produk {{$kategori->product_name}} 10 Terakhir</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="text-primary">
                            <th>Nama Produk</th>
                            <th>Opearator</th>
                            <th>Kode</th>
                            <th>Status</th>
                        </tr>
                        @if($produks->count() > 0)
                        @foreach($produks as $data)
                        <tr>
                            <td>{{$data->product_name}}</td>
                            <td>{{$data->pembayaranoperator->product_name}}</td>
                            <td>{{$data->code}}</td>
                            @if($data->status == 1)
                            <td><label class="label label-success">Tersedia</label></td>
                            @else
                            <td><label class="label label-danger">Gangguan</label></td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" style="text-align: center;font-size: 13;font-style: italic;background-color: #F8F6F6">Data tidak ditemukan</td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>


        <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
                <div class="box-header">
                    <i class="fa fa-server"></i>
                    <h3 class="box-title">Produk {{$kategori->product_name}} 10 Terakhir</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr class="text-primary">
                            <th>Nama Produk</th>
                            <th>Opearator</th>
                            <th>Kode</th>
                            <th>Status</th>
                        </tr>
                        @if($produks->count() > 0)
                        @foreach($produks as $data)
                        <tr>
                            <td>{{$data->product_name}}</td>
                            <td>{{$data->pembayaranoperator->product_name}}</td>
                            <td>{{$data->code}}</td>
                            @if($data->status == 1)
                            <td><label class="label label-success">Tersedia</label></td>
                            @else
                            <td><label class="label label-danger">Gangguan</label></td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" style="text-align: center;font-size: 13;font-style: italic;background-color: #F8F6F6">Data tidak ditemukan</td>
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

$(document).ready(function() {

    function autoMoneyFormat(b){
        var _minus = false;
        if (b<0) _minus = true;
        b = b.toString();
        b=b.replace(".","");
        b=b.replace("-","");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--){
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)){
        c = b.substr(i-1,1) + "." + c;
        } else {
        c = b.substr(i-1,1) + c;
        }
        }
        if (_minus) c = "-" + c ;
        return c;
    }

      function price_to_number(v){
      if(!v){return 0;}
          v=v.split('.').join('');
          v=v.split(',').join('');
      return Number(v.replace(/[^0-9.]/g, ""));
      }

      function number_to_price(v){
      if(v==0){return '0,00';}
          v=parseFloat(v);
          // v=v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          v=v.split('.').join('*').split(',').join('.').split('*').join(',');
      return v;
      }

      function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
      }

    $('#markup').keyup(function(){
        var markup = parseInt(price_to_number($('#markup').val()));
        var biaya_admin = autoMoneyFormat(parseInt(price_to_number($('#biaya_default').val())) + markup);
        var autoMoney = autoMoneyFormat(markup);
        $('#markup').val(autoMoney);
        $('#biaya_admin').val(biaya_admin);
    });

});

</script>
@endsection
