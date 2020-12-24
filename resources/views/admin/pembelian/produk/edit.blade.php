@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Produk <small>{{$produks->pembeliankategori->product_name}}</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pembelian</a></li>
        <li><a href="{{url('/admin/pembelian-produk', $produks->pembeliankategori->slug)}}" class="btn-loading"> Produk {{$produks->pembeliankategori->product_name}}</a></li>
    	<li class="active">Ubah Produk</li>
    </ol>
</section>
<section class="content">
    <div class="row">      
        <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
                <div class="box-header">
                    <i class="fa fa-text-width"></i>
                    <h3 class="box-title">Detail Produk {{$produks->product_name}} (Data Lokal)</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <td>ID</td>
                            <td>:</td>
                            <td>#{{$produks->id}}</td>
                        </tr>
                        <tr>
                            <td>ID (Server)</td>
                            <td>:</td>
                            <td>#{{$produks->product_id}}</td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>:</td>
                            <td>{{$produks->product_name}}</td>
                        </tr>
                        <tr>
                            <td>Operator</td>
                            <td>:</td>
                            <td>{{$produks->pembelianoperator->product_name}}</td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>{{$produks->pembeliankategori->product_name}}</td>
                        </tr>
                        <tr>
                            <td>Harga Default</td>
                            <td>:</td>
                            <!-- <td>Rp {{number_format($produks->price, 0, '.', '.')}}</td> -->
                            <td>Rp {{number_format($produks->price_default, 0, '.', '.')}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td>{{$produks->desc}}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            @if($produks->status == 1)
                            <td><label class="label label-success">Tersedia</label></td>
                            @else
                            <td><label class="label label-danger">Gangguan</label></td>
                            @endif
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        
        <div class="col-md-6">
            <div class="box box-solid box-penjelasan">
                <div class="box-header">
                    <i class="fa fa-text-width"></i>
                    <h3 class="box-title">Detail Produk {{$produks->product_name}} (Data API)</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">

                 @foreach($results as $data)
                    <table class="table">
                        <tr>
                            <td>ID</td>
                            <td>:</td>
                            <td>#{{$data['id']}}</td>
                        </tr>
                        <tr>
                            <td>ID (Server)</td>
                            <td>:</td>
                            <td>#{{$data['code']}}</td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>:</td>
                            <td>{{$data['description']}}</td>
                        </tr>
                        <tr>
                            <td>Operator</td>
                            <td>:</td>
                            <td>{{$data['operator']}}</td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>{{$produks->pembeliankategori->product_name}}</td>
                        </tr>
                        <tr>
                            <td>Harga Default</td>
                            <td>:</td>
                            <td>Rp {{number_format($data['price_api'], 0, '.', '.')}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td>{{$produks->desc}}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            @if($data['status'] == "1")
                            <td><label class="label label-success">Tersedia</label></td>
                            @else
                            <td><label class="label label-danger">Gangguan</label></td>
                            @endif
                        </tr>
                    </table>
                    @endforeach
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    
    <div class="row">   
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/admin/pembelian-produk', $produks->pembeliankategori->slug)}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Ubah Harga Produk</h3>
                </div>
                <form role="form" action="{{url('/admin/pembelian-produk/update', $produks->id)}}" method="post">
                <input name="_method" type="hidden" value="PATCH">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label>Harga Default: </label>

                            <div class="input-group">
                                <div class="input-group-addon">Rp. </div>
                                <input type="text" id="price_default" class="form-control" name="price_default" value="{{number_format($produks->price_default, 0, '.', '.')}}"  readonly="">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('price_markup') ? ' has-error' : '' }}">
                            <!-- <label>Harga Produk: </label> -->
                            <label>Harga Markup: </label>
                            <div class="input-group">
                                <div class="input-group-addon">Rp. </div>
                                <!-- <input type="number" id="number" class="form-control" name="price" value="{{$produks->price ?? old('price')}}"  placeholder="Masukkan Kode Icon Kategori"> -->
                                <input type="text" id="price_markup" class="form-control" name="price_markup" value="{{number_format($produks->price_markup, 0, '.', '.')}}" placeholder="Masukkan nominal markup" Kategori">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Harga Jual: </label>
                            <div class="input-group">
                                <div class="input-group-addon">Rp. </div>
                                <input type="text" id="price_jual" class="form-control" name="price_jual" value="{{number_format($produks->price, 0, '.', '.')}}">
                            </div>
                            {!! $errors->first('price_jual', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                    </div>
                </form>
            </div>
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

    $('#price_markup').keyup(function(){
        var price_default=parseInt(price_to_number($('#price_default').val()));
        var price_markup=parseInt(price_to_number($('#price_markup').val()));
        var price_jual=parseInt(price_to_number($('#price_jual').val()));
        console.log('price_default',price_default);
        console.log('price_markup',price_markup);
        console.log('price_jual',price_jual);
        var total_jual=price_default+price_markup;

        var autoMoney = autoMoneyFormat(price_markup);
        $('#price_markup').val(autoMoney);
        $('#price_jual').val(number_to_price(total_jual));
    });

    $('#price_jual').keyup(function(){
        var price_default=parseInt(price_to_number($('#price_default').val()));
        var price_markup=parseInt(price_to_number($('#price_markup').val()));
        var price_jual=parseInt(price_to_number($('#price_jual').val()));
        console.log('price_default',price_default);
        console.log('price_markup',price_markup);
        console.log('price_jual',price_jual);
        var total_markup=price_jual-price_default;

        var autoMoney = autoMoneyFormat(price_jual);
        $('#price_jual').val(autoMoney);
        $('#price_markup').val(number_to_price(total_markup));
    });
});

</script>
@endsection