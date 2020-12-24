@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Harga <small>{{$kategoris->product_name}}</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="Javascript:;"> Harga Produk</a></li>
 	<li class="active">{{$kategoris->product_name}}</li>
</ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
      <div class="col-md-12">
         <div class="box">
            <div class="box-header with-border">
               <h3 class="box-title"><span class="hidden-xs">Produk {{$kategoris->product_name}}</span></h3>
            </div><!-- /.box-header -->
                @foreach($kategoris->pembayaranoperator as $operator)
                <h4 style="font-weight: bold;text-align: center;">{{$operator->product_name}}</h4>
                <div class="box-body table-responsive">
                   <table class="table table-hover" style="margin-bottom:20px;">
                       <thead>
                           <tr>
                               <th>Produk</th>
                               <th>Kode</th>
                               <th>Biaya Admin</th>
                               <th class="text-center">Status</th>
                           </tr>
                       </thead>
                      <tbody align="left">
                          @if(count($operator->pembayaranproduk) > 0)
                          @foreach($operator->pembayaranproduk as $produk)
                          <tr>
                              <td>{{$produk->product_name}}</td>
                              <td>{{$produk->code}}</td>
                              <td>Rp {{number_format($produk->price_markup, 0, '', '.') }}</td>
                              @if($produk->status == 1)
                              <td class="text-center"><span class="label label-success">TERSEDIA</span></td>
                              @else
                              <td class="text-center"><span class="label label-danger">GANGGUAN</span></td>
                              @endif
                          </tr>
                          @endforeach
                          @else
                          <tr>
                              <td colspan="3" align="center" style="font-style: italic;">Produk Belum Tersedia</td>
                          </tr>
                          @endif
                      </tbody>
                    </table>
                  </div><!-- /.box-body -->
            @endforeach
         </div><!-- /.box -->
      </div>
   </div>


       <div class="row hidden-lg hidden-md">
           <div class="col-xs-12">
               <div class="box">
                   <div class="box-header">
                       <h3 class="box-title" style="font-size:18px;"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>{{$kategoris->product_name}}</h3>
                   </div><!-- /.box-header -->
                   @foreach($kategoris->pembayaranoperator as $data)
                   <h4 style="font-weight: bold;text-align: center;">{{$data->product_name}}</h4>
                   <div class="box-body" style="padding: 0px">
                       <table class="table table-hover">
                           @if(count($data->pembayaranproduk) > 0)
                           @foreach($data->pembayaranproduk as $produk)
                           <tr>
                               <td>
                                   <div>{{$produk->code}}</div>
                                   <div style="font-size: 14px;font-weight: bold;">{{$produk->product_name}}</div></td>
                               <td align="right" style="width:25%;">
                                   @if($produk->status == 1)
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
                   @endforeach
               </div><!-- /.box -->
           </div>
       </div>

</section>
@endsection
