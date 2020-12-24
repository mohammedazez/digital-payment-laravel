@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
  <h1>Pembayaran <small>Produk</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pembayaran</a></li>
      <li class="active">Produk</li>
    </ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Produk</h3>
                </div><!-- /.box-header -->
                <div style="text-align: center;margin: 5px;">
                    <div id="desktop" class="hidden-xs hidden-sm">
                      <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                @foreach($KategoriPembayaran as $data)
                                <?php
                                  $stopword = array('tagihan');
                                  $text = (trim(strtolower($data->product_name)));
                                  $sub_kalimat = (strtoupper(trim(str_replace($stopword, '', $text))));
                                ?>
                                <a href="{{url('/admin/pembayaran-produk', $data->slug)}}" class="btn-loading btn btn-primary {{ url('/admin/pembayaran-produk', $data->slug) == request()->url() ? 'active' : '' }}" style="padding: 3px 7px;margin: 2px">{{$sub_kalimat}}</a>
                                @endforeach
                            </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">

                    <table class="table table-hover" style="margin-bottom:20px;">
                        <tr class="custom__text-green">
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Operator</th>
                            <th>Kategori</th>
                            <th>Biaya Default</th>
                            <th>Markup Biaya</th>
                            <th>Biaya Admin</th>
                            <th>Update Terakhir</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php $no=1; ?>
                        @if(count($produks) > 0)
                        @foreach($produks as $produk)
                        <tr style="font-size: 13px;">
                            <td>#{{$produk->id}}</td>
                            <td>{{$produk->code}}</td>
                            <td>{{$produk->product_name}}</td>
                            <td>{{$produk->pembayaranoperator->product_name}}</td>
                            <td>{{$produk->pembayarankategori->product_name}}</td>
                            <td>Rp {{number_format($produk->price_default, 0, '.', '.')}} </td>
                            <td>Rp {{number_format($produk->markup, 0, '.', '.')}} </td>
                            <td>Rp {{number_format($produk->price_markup, 0, '.', '.')}} </td>
                            <td>{{$produk->updated_at}}</td>
                            @if($produk->status == 1)
                            <td><label class="label label-success">Tersedia</label></td>
                            @else
                            <td><label class="label label-danger">Gangguan</label></td>
                            @endif
                            <td>
                                <form method="POST" action="{{ route('admin.pembayaranProduk.delete', $produk->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;"><i class="fa fa-trash"></i></button>
                                 </form>
                           </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" style="font-style:italic;text-align:center;background-color:#F3F3F3;">Data Produk tidak ditemukan</td>
                        </tr>
                        @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Produk</h3>
                </div><!-- /.box-header -->
                <div style="text-align: center;margin-bottom: 10px;margin-top: 10px;">
                    <div id="mobile" class="hidden-lg hidden-md">
                        @foreach($KategoriPembayaran as $data)
                        <a href="{{url('/admin/pembayaran-produk', $data->slug)}}" class="btn-loading btn btn-primary {{ url('/admin/pembayaran-produk', $data->slug) == request()->url() ? 'active' : '' }}" style="width:30px;padding: 3px 7px;"><i class="fa fa-{{$data->icon}}"></i><span class="hidden-xs hidden-sm" style="margin-left:5px;">{{$data->product_name}}</span></a>
                        @endforeach
                    </div>
                </div>
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @if($produks->count() > 0)
                        @foreach($produks as $data)
                        <tr>
                            <td>
                                <div><small>{{$data->pembayarankategori->product_name}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->product_name}}</div>
                                <div>{{$data->pembayaranoperator->product_name}}</div>
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
    function loading() {
        $('#body').html('<div class="text-center" style="margin-top: 20px; margin-bottom:20px;"><i class="fa fa-spinner fa-2x faa-spin animated"></i></div>');
    }
    $('#proses').on('click', function(){
        loading();
        $('#proses').attr('disabled', true);
        $('#proses').text('Loading...');

        $.ajax({
            url: '/admin/pembelian-produk/delete',
            type: "post",
            data: {
                '_token': '{{csrf_token()}}',
            },

            success: function(data){
                location.reload();
            }
        });
    });

    $('#showProduk').on('change', function(e){
        $('.loading').html("<div class='hidden-lg' style='text-align:center;'><i class='fa fa-spinner fa-4x faa-spin animated text-primary' style='margin-top:100px;'></i></div>");
        $('.sidebar-mini').removeClass('sidebar-open');
        var slug = e.target.value;
        //ajax
        if (slug != '') {
            $.get('/admin/pembelian-produk/'+ slug, function(data){
                //success data
                window.location.href='http://localhost:8000/admin/pembelian-produk/'+ slug;
            });
        }else{
            window.location.href='http://localhost:8000';
        }
    });
</script>
@endsection
