@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
	<h1>Pembelian <small>Produk (Level Agen)</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pembelian</a></li>
    	<li class="active">Produk (Level Agen)</li>
    </ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Produk (Level Agen)</h3><button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" style="padding: 3px 7px;margin-left:5px;"><i class="fa fa-trash"></i><span class="hidden-xs hidden-sm"> Hapus Semua Data Produk</span></button>
                </div><!-- /.box-header -->
                <div style="text-align: center;margin: 5px;">
                    <div id="desktop" class="hidden-xs hidden-sm">
                        @foreach($KategoriPembelian as $data)
                        <a href="{{url('/admin/pembelian-produk/markup/role-agen', $data->slug)}}" class="btn-loading btn btn-primary {{ url('/admin/pembelian-produk/markup/role-agen', $data->slug) == request()->url() ? 'active' : '' }}" style="padding: 3px 7px;margin: 2px">{{$data->product_name}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    
                    <table id="DataTable" class="table table-hover" style="margin-bottom:20px;">
                        <thead>
                            <tr class="custom__text-green">
                                <th>ID</th>
                                <th>ID Server</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Update Terakhir</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            @if(count($produksWeb) > 0)
                            @foreach($produksWeb as $produk)
                            <tr style="font-size: 13px;">
                                <td>#{{$produk->id}}</td>
                                <td>#{{$produk->product_id}}</td>
                                <td>{{$produk->product_name}}</td>
                                <td>Rp {{number_format($produk->price, 0, '.', '.')}}</td>
                                <td>{{$produk->updated_at}}</td>
                                @if($produk->status == 1)
                                <td><label class="label label-success">Tersedia</label></td>
                                @else
                                <td><label class="label label-danger">Gangguan</label></td>
                                @endif
                                <td>
                                    <form method="POST" action="{{ route('admin.produkAgen.delete', $produk->id) }}" accept-charset="UTF-8">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;"><i class="fa fa-trash"></i></button>
                                     </form>
                               </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" style="font-style:italic;text-align:center;background-color:#F3F3F3;">Data Produk tidak ditemukan</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/admin')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Data Produk</h3><button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" style="padding: 3px 7px;margin-left:5px;"><i class="fa fa-trash"></i><span class="hidden-xs hidden-sm"> Hapus Semua Data Produk</span></button>
                </div><!-- /.box-header -->
                <div style="text-align: center;margin-bottom: 10px;margin-top: 10px;">
                    <div id="mobile" class="hidden-lg hidden-md">
                        @foreach($KategoriPembelian as $data)
                        <a href="{{url('/admin/pembelian-produk/markup/role-agen', $data->slug)}}" class="btn-loading btn btn-primary {{ url('/admin/pembelian-produk/markup/role-agen', $data->slug) == request()->url() ? 'active' : '' }}" style="width:30px;padding: 3px 7px;"><i class="fa fa-{{$data->icon}}"></i><span class="hidden-xs hidden-sm" style="margin-left:5px;">{{$data->product_name}}</span></a>
                        @endforeach
                    </div>
                </div>
                <div class="box-body" style="padding: 0px">
                    <table class="table table-hover">
                        @if($produksMobile->count() > 0)
                        @foreach($produksMobile as $data)
                        <tr>
                            <td>
                                <div><small>ID : #{{$data->id}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->pembelianoperator->product_name}} - {{$data->product_name}}</div>
                                <div>{{$data->pembeliankategori->product_name}}</div>
                            </td>
                            <td align="right" style="width:35%;">
                                <div><small>ID Product : #{{$data->product_id}}</small></div>
                                <div><div>Rp {{number_format($data->price, 0, '.', '.')}}</div></div>
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
                <div class="box-footer" align="center" style="padding-top:13px;">
                   @include('pagination.default', ['paginator' => $produksMobile])
               </div>
            </div><!-- /.box -->
        </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Semua Produk Operator</h4>
            </div>
            <div class="modal-body" style="text-align:center;">
                <div id="body">
                    <p>Apakah anda yakin ingin menghapus semua data produk dari semua operator yang tersedia?</p>
                    <p style="font-style:italic;"><small>Tindakan tersebut akan mengosongkan semua data produk dalam database, tetapi anda dapat mengisinya kembali dengan cara update produk yang terdapat dalam halaman produk.</small></p>
                </div>
            </div>
            <div class="modal-footer" style="text-align:center;">
                <button type="button" class="btn btn-primary" id="proses">Kosongkan Sekarang</button>
            </div>
        </div>
     </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(function () {
       $('#DataTable').DataTable({
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "iDisplayLength": 50,
         "searching": false,
         "lengthChange": false,
         "info": false,
         "order": [[ 0, "asc" ]]
       });
    });
    function loading() {
        $('#body').html('<div class="text-center" style="margin-top: 20px; margin-bottom:20px;"><i class="fa fa-spinner fa-2x faa-spin animated"></i></div>');
    }
    $('#proses').on('click', function(){
        loading();
        $('#proses').attr('disabled', true);
        $('#proses').text('Loading...');
         
        $.ajax({
            url: "{{ url('/admin/pembelian-produk/markup/role-agen/delete') }}",
            type: "post",
            data: {
                '_token': '{{csrf_token()}}',
            },
            
            success: function(data){
                location.reload();
            }
        });     
    });
</script>
@endsection