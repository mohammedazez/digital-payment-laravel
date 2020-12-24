@extends('layouts.member')
<style type="text/css">
 
#share-buttons img {
width: 35px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
}


.product__list ul li{
    margin-bottom: 0.8rem;
    background: #C8F1C8;
    border: 1px solid #32CD32;
    color: #48465B;
    padding: 1.4rem 2rem;
    cursor: pointer;
}

.product__list ul li label{
    cursor: pointer;
}

.product__flex{
    display: flex;
}

.product__right{
    margin-left: auto;
}

.product__title{
    font-size: 16px;
    font-weight: 400;
    color: #595d6e;
}

.product__desc{
    font-size: 12px;
    color: #74788d;
    font-weight: 400;
}

.product__price{
    font-size: 16px;
    font-weight: 600;
    color: #48465b;
}

.product__poin{
    font-size: 14px;
    color: #ffb822;
}


.product__flex{
    display: flex;
}

.product__right{
    margin-left: auto;
}

.product__width{
    margin-left: 1.4rem; 
    width: 100%;
}

.product__custom-input{
    border: 1px solid #366cf3;
}

.product__radio input[type=radio]{
    visibility: hidden;
    margin-top: -10px;
}

.product__radio .check{
    display: block;
    border: 2px solid #497DED;
    border-radius: 100%;
    height: 18px;
    width: 18px;
    z-index: 5;
    transition: border .25s linear;
    -webkit-transition: border .25s linear;
}

.product__radio:hover .check{
    border: 2px solid #497DED;
}

.product__radio::before{
    display: block;
    position: absolute;
	content: '';
    border-radius: 100%;
    height: 5px;
    width: 5px;
    top: 5px;
	left: 5px;
    margin: auto;
	transition: background 0.25s linear;
	-webkit-transition: background 0.25s linear;
}

input[type=radio]:checked ~ .check {
  border: 3px solid #0DFF92;
}

input[type=radio]:checked ~ .check::before{
  background: #0DFF92;
}

.modal__text{
    text-align: center;
    font-size: 18px;
    color: #48465B;
}

.modal__text span{
    font-weight: 600;
}

#modalPIN .modal-header .modal-title{
    color: #48465B;
    font-weight: 600;
}

.input__group-margin{
    margin-top: 3rem;
    margin-bottom: 1rem;
}
 
</style>
@section('content')
<section class="content-header hidden-xs">
    <h1>Transaksi <small>Pembelian {{$kategori->product_name}}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Pembelian</a></li>
        <li class="active">{{$kategori->product_name}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Pembelian {{$kategori->product_name}}</h3>
                </div>
                <form role="form" action="{{url('/member/process/orderproduct')}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        @if(Session::has('alert-success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <h4><i class="fa fa-check" style="margin-right: 5px;"></i>Berhasil</h4>
                            <p>{!! Session::get('alert-success') !!}</p>
                        </div>
                        <div class="modal fade" id="myModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header alert-success">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4><i class="fa fa-check" style="margin-right: 5px;"></i>Berhasil</h4>
                                        <p>{!! Session::get('alert-success') !!}</p>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Referral</h4>
                                        <p align="center">
                                        Setiap ada yang bergabung & bertransaksi di {{setting()->nama_sistem}} melalui link atau URL Referral Sobat dibawah ini, maka Sobat mendapatkan bonus Rp 25 tiap transaksi. Dan lebih hebat lagi bonus transaksi otomatis ditambahkan pada saldo Sobat TANPA SYARAT APAPUN tanpa minimal deposit ataupun kejar poin.<br>
                                        <a href="../referral">Selengkapnya >></a>
                                        {{-- Sebagai simulasi, Sobat mengajak 100 teman bergabung & bertransaksi di {{setting()->nama_sistem}} baik untuk dipakai sendiri maupun dijual kembali dan setiap teman bertransaksi sebanyak 10x dalam sehari yang artinya dalam sehari ada 1000 transaksi dan tinggal dikali saja 30 untuk mencari jumlah transaksi dalam sebulan. Jadi 30.000 (jumlah transaksi sebulan) x 25 (bonus tiap transaksi) = Rp 750.000,00 WOW sungguh luar biasa bukan, ini hanya simulasi kecil dan kami yakin Sobat {{setting()->nama_sistem}} bisa lebih hebat dari itu. Terima kasih banyak.</p> --}}
                                        <center>
                                            <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(coderef(), 'QRCODE')}}" alt="barcode" />
                                            <br/>

                                        <label>Affiliate anda :</label>
                                        <div class="input-group">
                                            <input class="form-control input-sm" id="ref" type="text" value="{{ url('/') }}/register?ref={{ sprintf("%04d", Auth::user()->id) }}" readonly style="text-align:center;">
                                            <div class="input-group-addon"><a href="Javascript:;" class="copy-text" data-clipboard-target="#ref"><i class="fa fa-clone"></i></a></div>
                                        </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                            <input type="hidden" name="type" id="pembeliankategori_id" value="{{$kategori->id}}">

                            <!-- ===================================== Pulsa All Operator ===================================== -->
                            @if(in_array(strtoupper($kategori->type), ["REGULER","TRANSFER"]))
                                <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
                                    <label>Nomor Tujuan : </label>
                                    <div class="input-group">
                                       <span class="input-group-btn">
                                        <button class="btn custom__bg-greenTwo" id="showModal" type="button"><span><i class="fa fa-book fa-fw"></i></span>&nbsp;</button>
                                      </span>
                                        <input type="number" name="target" value="{{ old('target') }}" class="form-control phone_number"  min="0" autocomplete="off" placeholder="Masukkan Nomor Handphone / Rekening Pengisian" autocomplete="off" autofocus>
                                    </div>
                                    {!! $errors->first('target', '<p class="help-block"><small>:message</small></p>') !!}
                                </div>


                                <!-- Custom form --> 
                                <div id="product-list"></div>
                                <!-- Penutup Custom form -->

                            <!-- ===================================== Token Listrik ===================================== -->    
                            @elseif(in_array(strtoupper($kategori->type), ["PLN"]))
                                <div class="form-group{{ $errors->has('no_meter_pln') ? ' has-error' : '' }}">
                                    <div class="form-group{{ $errors->has('no_meter_pln') ? ' has-error' : '' }}">
                                        <label>No. Meter/ID Pel : </label>
                                        <input type="number" name="no_meter_pln" value="{{ old('no_meter_pln') }}" class="form-control" placeholder="No. Meter atau ID Pelanggan adalah nomor yang tertera pada kartu pelanggan" autocomplete="off" autofocus required>
                                        {!! $errors->first('no_meter_pln', '<p class="help-block"><small>:message</small></p>') !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
                                    <label>Nomor HP : </label>
                                    <input type="number" name="target" value="{{ old('target') }}" class="form-control" placeholder="Masukkan Nomor Handphone Pembeli" autocomplete="off">
                                    {!! $errors->first('target', '<p class="help-block"><small>:message</small></p>') !!}
                                </div>

                                @if(isset($operator))
                                
                                    @php
                                        switch(Auth::user()->roles[0]->id)
                                        {
                                            case 3:
                                                $products = $operator->V_pembelianproduk_agen;
                                                break;
                                                    
                                            case 4:
                                                $products = $operator->V_pembelianproduk_enterprise;
                                                break;
                                                    
                                            default:
                                                $products = $operator->V_pembelianproduk_personal;
                                                break;
                                        }
                                    @endphp
                                    
                                    @if(count($products) > 0)
                                    <div class="form-group product__list"><label>Produk :</label>
                                        <ul class="list-group">
                                            @foreach($products as $data)
                                            <li class="list-group-item" onclick="onBuy('{{$data->product_id}}', '{{$data->product_name}}', '{{$data->price}}')">
                                                <div class="product__flex">
                                                    <div class="product__radio">
                                                        <input type="radio" id="product-{{$data->product_id}}" name="selector">
                                                        <div class="check"></div>
                                                    </div>
                                                    <label for="product-{{$data->product_id}}" class="product__width">
                                                        <div class="product__flex">
                                                            <div class="product__left product__title">
                                                                {{$data->product_name}}
                                                            </div>
                                                            <div class="product__right product__price">
                                                                Rp {{number_format($data->price, 0, '.', '.')}}
                                                            </div>
                                                        </div>
                                                        <div class="product__flex" style="margin-top: 1rem;">
                                                            <div class="product__left product__desc">
                                                            {{$data->desc?$data->desc:'-'}}
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                @endif
                                
                            <!-- ===================================== Voucher Game ===================================== -->    
                            @elseif(in_array(strtoupper($kategori->type), ["GAME"]))

                                <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
                                    <label>Nomor Tujuan : </label>
                                    <input type="number" name="target" value="{{ old('target') }}" class="form-control" placeholder="Masukkan Nomor ID Player atau Zone ID Game" autocomplete="off" autofocus>
                                    {!! $errors->first('target', '<p class="help-block"><small>:message</small></p>') !!}
                                </div>

                                <div class="form-group{{ $errors->has('operator') ? ' has-error' : '' }}">
                                    <label>Jenis Game : </label>
                                    <select name="operator" id="operator" class="form-control">
                                        @if( $kategori->pembelianoperator->count() > 0 )
                                            @if($kategori->pembelianoperator->count() > 1)
                                                <option value="">Pilih Operator ...</option>
                                                @foreach($kategori->pembelianoperator->sortBy('product_name') as $data)
                                                <option value="{{$data->id}}">{{$data->product_name}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ $kategori->pembelianoperator[0]->id }}">{{ $kategori->pembelianoperator[0]->product_name }}</option>
                                            @endif
                                        @endif
                                    </select>
                                    {!! $errors->first('operator', '<p class="help-block"><small>:message</small></p>') !!}
                                </div>

                                <div id="product-list">
                                    @if(isset($operator))
                                    
                                        @php
                                            switch(Auth::user()->roles[0]->id)
                                            {
                                                case 3:
                                                    $products = $operator->V_pembelianproduk_agen;
                                                    break;
                                                        
                                                case 4:
                                                    $products = $operator->V_pembelianproduk_enterprise;
                                                    break;
                                                        
                                                default:
                                                    $products = $operator->V_pembelianproduk_personal;
                                                    break;
                                            }
                                        @endphp
                                        
                                        @if(count($products) > 0)
                                        <div class="form-group product__list"><label>Produk :</label>
                                            <ul class="list-group">
                                                @foreach($products as $data)
                                                <li class="list-group-item" onclick="onBuy('{{$data->product_id}}', '{{$data->product_name}}', '{{$data->price}}')">
                                                    <div class="product__flex">
                                                        <div class="product__radio">
                                                            <input type="radio" id="product-{{$data->product_id}}" name="selector">
                                                            <div class="check"></div>
                                                        </div>
                                                        <label for="product-{{$data->product_id}}" class="product__width">
                                                            <div class="product__flex">
                                                                <div class="product__left product__title">
                                                                    {{$data->product_name}}
                                                                </div>
                                                                <div class="product__right product__price">
                                                                    Rp {{number_format($data->price, 0, '.', '.')}}
                                                                </div>
                                                            </div>
                                                            <div class="product__flex" style="margin-top: 1rem;">
                                                                <div class="product__left product__desc">
                                                                {{$data->desc?$data->desc:'-'}}
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    @endif
                                </div>
                           

                            <!-- =================== ALL VOUCHER AND ANOTHER DATA ============================= -->
                            @elseif(in_array(strtoupper($kategori->type), ["LAIN","SMS","INTERNET"]))

                                    <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
                                        <label>Nomor Tujuan : </label>
                                        <div class="input-group">
                                           <span class="input-group-btn">
                                            <button class="btn btn__greenHover" id="showModal" type="button"><span><i class="fa fa-book fa-fw"></i></span>&nbsp;</button>
                                          </span>
                                        <input type="number" name="target" value="{{ old('target') }}" class="form-control phone_number" min="0" autocomplete="off" placeholder="Masukkan Nomor Handphone / Rekening Pengisian" autocomplete="off" autofocus>
                                        </div>
                                        {!! $errors->first('target', '<p class="help-block"><small>:message</small></p>') !!}
                                    </div>

                                    <div class="form-group{{ $errors->has('operator') ? ' has-error' : '' }}">
                                        <label>Provider/Operator : </label>
                                        <select name="operator" id="operator" class="form-control">
                                            @if( $kategori->pembelianoperator->count() > 0 )
                                                @if($kategori->pembelianoperator->count() > 1)
                                                    <option value="">Pilih Operator ...</option>
                                                    @foreach($kategori->pembelianoperator->sortBy('product_name') as $data)
                                                    <option value="{{$data->id}}">{{$data->product_name}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $kategori->pembelianoperator[0]->id }}">{{ $kategori->pembelianoperator[0]->product_name }}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>

                                    <div id="product-list">
                                        @if(isset($operator))
                                        
                                            @php
                                                switch(Auth::user()->roles[0]->id)
                                                {
                                                    case 3:
                                                        $products = $operator->V_pembelianproduk_agen;
                                                        break;
                                                            
                                                    case 4:
                                                        $products = $operator->V_pembelianproduk_enterprise;
                                                        break;
                                                            
                                                    default:
                                                        $products = $operator->V_pembelianproduk_personal;
                                                        break;
                                                }
                                            @endphp
                                        
                                            @if(count($products) > 0)
                                            <div class="form-group product__list"><label>Produk :</label>
                                                <ul class="list-group">
                                                    @foreach($products as $data)
                                                    <li class="list-group-item" onclick="onBuy('{{$data->product_id}}', '{{$data->product_name}}', '{{$data->price}}')">
                                                        <div class="product__flex">
                                                            <div class="product__radio">
                                                                <input type="radio" id="product-{{$data->product_id}}" name="selector">
                                                                <div class="check"></div>
                                                            </div>
                                                            <label for="product-{{$data->product_id}}" class="product__width">
                                                                <div class="product__flex">
                                                                    <div class="product__left product__title">
                                                                        {{$data->product_name}}
                                                                    </div>
                                                                    <div class="product__right product__price">
                                                                        Rp {{number_format($data->price, 0, '.', '.')}}
                                                                    </div>
                                                                </div>
                                                                <div class="product__flex" style="margin-top: 1rem;">
                                                                    <div class="product__left product__desc">
                                                                    {{$data->desc?$data->desc:'-'}}
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                            @endif
                    </div>

                </form>
            </div>
        </div>
        <div class="col-md-6 hidden-xs hidden-sm">
            <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label"><span class="custom__btn-green" style="padding-right: 20px;padding-left: 20px;">3 Transaksi Terakhir</span></li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                
                @if($transaksi->count() > 0)
                @foreach($transaksi as $data)
                <li>
                    @if($data->status == 0)
                    <i class="fa fa-shopping-cart bg-yellow-active"></i>
                    @elseif($data->status == 1)
                    <i class="fa fa-shopping-cart bg-green-active"></i>
                    @elseif($data->status == 2)
                    <i class="fa fa-shopping-cart bg-red-active "></i>
                    @elseif($data->status == 3)
                    <i class="fa fa-shopping-cart bg-light-blue-active"></i>
                    @endif
                    <div class="timeline-item">
                        <span class="time" style="padding-top: 5px;padding-bottom: 5px;"><i class="fa fa-clock-o"></i> {{date("d M Y H:m:s", strtotime($data->created_at))}}</span>
                        @if($data->status == 0)
                        <h3 class="timeline-header" style="padding-top: 5px;padding-bottom: 5px;"><a href="#">[#{{$data->id}}]</a> TRANSAKSI PROSES</h3>
                        @elseif($data->status == 1)
                        <h3 class="timeline-header" style="padding-top: 5px;padding-bottom: 5px;"><a href="#">[#{{$data->id}}]</a> TRANSAKSI BERHASIL</h3>
                        @elseif($data->status == 2)
                        <h3 class="timeline-header" style="padding-top: 5px;padding-bottom: 5px;"><a href="#">[#{{$data->id}}]</a> TRANSAKSI GAGAL</h3>
                        @elseif($data->status == 3)
                        <h3 class="timeline-header" style="padding-top: 5px;padding-bottom: 5px;"><a href="#">[#{{$data->id}}]</a> TRANSAKSI REFUND</h3>
                        @endif
                        
                        <div class="timeline-body" style="padding-top: 5px;padding-bottom: 5px;">
                            <small>{{$data->note}}</small>
                        </div>
                    </div>
                </li>
                @endforeach
                @else
                <li>
                    <i class="fa fa-exclamation-circle custom__btn-green"></i>
                    <div class="timeline-item">
                        <div class="timeline-body" style="padding-top: 5px;padding-bottom: 5px;text-align:center;">
                            <h4 style="font-style:italic;">Transaksi belum terseda</h4>
                        </div>
                    </div>
                </li>
                @endif
                
                <li class="time-label"><span class="custom__btn-greenHover" style="padding-right: 20px;padding-left: 20px;"><a href="{{url('/member/riwayat-transaksi')}}" style="color: white;">Lihat Semuanya</a></span></li>
            </ul>
        </div>
    </div>
    <div class="row hidden-xs hidden-sm">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Antrian Permintaan Pembelian</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding" >
                    <table id="DataTable" class="table table-hover">
                        <thead>
                          <tr class="custom__text-green">
                              <th>No.</th>
                              <th>Produk & No Pengisian</th>
                              <th>IDPel</th>
                              <th>Keterangan</th>
                              <th>Pengirim</th>
                              <th>Tanggal</th>
                              <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; ?>
                        @if($antrian->count() > 0)
                        @foreach($antrian as $data)
                        <tr style="font-size: 13px;">
                            <td>{{$no++}}</td>
                            <td>{{$data->produk}}<br>{{$data->target}}</td>
                            <td>{{$data->mtrpln}}</td>
                            <td width="30%">{{$data->note}}</td>
                            <td>{{$data->pengirim}}</td>
                            <td>{{$data->created_at}}</td>
                            @if($data->status == 0)
                            <td><span class="label label-warning">PENDING</span></td>
                            @elseif($data->status == 1)
                            <td><span class="label label-success">DIPROSES</span></td>
                            @else
                            <td><span class="label label-danger">GAGAL</span></td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='10' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
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
                    <h3 class="box-title">Antrian Permintaan Pembelian</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table">
                        @foreach($antrian as $data)
                        <tr>
                            <td>
                                <div><i class="fa fa-calendar"></i><small> {{date("d M Y", strtotime($data->created_at))}}</small></div>
                                <div style="font-size: 14px;font-weight: bold;">{{$data->produk}}</div>
                                <div>{{$data->target}}</div>
                            </td>
                            <td align="right">
                                <div><i class="fa fa-clock-o"></i><small> {{date("H:m:s", strtotime($data->created_at))}}</small></div>
                                <div>{{$data->pengirim}}</div>
                                @if($data->status == 0)
                                <div><span class="label label-warning">PENDING</span></div>
                                @elseif($data->status == 1)
                                <div><span class="label label-success">DIPROSES</span></div>
                                @else
                                <div><span class="label label-danger">GAGAL</span></div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-style: none;padding-top: 0px;"><div style="font-style: italic;">Catatan : {{$data->note}}</div></td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

<!-- Modal -->
<div id="modalHistory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Riwayat Transaksi</h4>
      </div>
      <div class="modal-body">
        <div class="row hidden-xs hidden-sm">
            <div class="col-xs-12"> 
                <table id="DataTableHistory"  class="table table-hover table-condensed">
              <thead>
                 <tr class="custom__text-green">
                    <th>No.</th>
                    <th>ID Trans</th>
                    <th>Produk</th>
                    <th>No Pengisian</th>
                    <th>Tanggal</th>
                 </tr>
              </thead>
              <tbody>
              </tbody>
           </table>
            </div>
        </div>
           
           
        <div class="row hidden-lg hidden-md">
            <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title"><a href="{{url('/member')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Riwayat Transaksi</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 0px">
               <table class="table table-hover">
                  @if($transaksisMobile->count() > 0)
                  @foreach($transaksisMobile as $data)
                  <tr>
                     <td>
                        <a href="#" onclick="toGetPhone('{{$data->target}}');return false;" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-calendar"></i> <small>{{date("d M Y", strtotime($data->created_at))}}</small></div>
                           <div style="font-size: 14px;font-weight: bold;">{{$data->produk}}</div>
                           <div>{{$data->target}}</div>
                           <div>{{$data->mtrpln}}</div>
                           <div><code>{{$data->via}}</code></div>
                        </a>
                     </td>
                     <td align="right">
                        <a href="#" onclick="toGetPhone('{{$data->target}}');return false;" class="btn-loading" style="color: #464646">
                           <div><i class="fa fa-clock-o"></i> <small>{{date("H:m:s", strtotime($data->created_at))}}</small></div>
                           <div>Rp {{number_format($data->total, 0, '.', '.')}}</div>
                           <div>{{$data->pengirim}}</div>
                           @if($data->status == 0)
                           <div><span class="label label-warning">PROSES</span></div>
                           @elseif($data->status == 1)
                           <div><span class="label label-success">BERHASIL</span></div>
                           @elseif($data->status == 2)
                           <div><span class="label label-danger">GAGAL</span></div>
                           @elseif($data->status == 3)
                           <div><span class="label label-primary">REFUND</span></div>
                           @endif
                        </a>
                     </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                      <td colspan="2" style="text-align:center;font-style:italic;">Riwayat Transaksi belum tersedia</td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            
            <div class="box-footer" align="center" style="padding-top:13px;">
               @include('pagination.default', ['paginator' => $transaksisMobile])
           </div>
         </div><!-- /.box -->
     </div>
        </div>
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      <!--</div>-->
    </div>

  </div>
</div>


<!-- Modal PIN --> 
<div id="modalPIN" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Konfirmasi PIN</h4>
        </div>
        <div class="modal-body">
            <div class="modal__text">
                Anda akan membeli <span class="product_name"></span> ke nomor <span class="target"></span> seharga <span class="price"></span>
            </div>

            <div class="form-group">
                <div class="input-group input__group-margin">
                    <span class="input-group-btn">
                        <button class="btn custom__btn-greenHover" type="button"><span><i class="fa fa-lock"></i></span>&nbsp;</button>
                    </span>
                    <input type="number" id="pin" name="pin" class="form-control" autocomplete="off" placeholder="Masukkan PIN Anda" autocomplete="off" autofocus>
                </div>
                <p class="help-block" style="display:none" id="pin_error"><small id="pin_error_message"></small></p>
            </div>
        </div>
        <div class="modal-footer">
            <form action="{{ url('/member/process/orderproduct') }}" method="POST" id="order_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="pin" value="">
                <input type="hidden" name="produk" value="">
                <input type="hidden" name="target" value="">
                <input type="hidden" name="no_meter_pln" value="">
                <button type="button" class="btn custom__btn-greenHover btn-lg btn-block" id="btn-submit-pin" onclick="beliButton()">Beli</button>
            </form>
        </div> 
    </div>

  </div>
</div>

</section>




<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modalKWH" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Check KWH PLN</h4>
        </div>
        <div class="modal-body">
            <div id="content-kwh">
                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
<!--{!! app('captcha')->renderFooterJS('en') !!}-->
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=target]').typeahead({
      source: function(query, result)
      {
        if( query.length >= 4 )
        {
            // $.ajax({
            //     url : "{{ route('beli.get.typehead') }}",
            //     method:"POST",
            //     data:{ _token: "{{csrf_token()}}", query:query},
            //     dataType:"json",
            //     success:function(target)
            //     {
            //         result($.map(target, function(item){
            //             return item;
            //         }));
            //     }
            // });
        }
      }
     });
    
     $('input[name=no_meter_pln]').typeahead({
      source: function(query, result)
      {
        if( query.length >= 4 )
        {
          // $.ajax({
          //   url : "{{ route('beli.get.typehead.pln') }}",
          //   method:"POST",
          //   data:{ _token: "{{csrf_token()}}", query:query},
          //   dataType:"json",
          //   success:function(mtrpln)
          //   {
          //     result($.map(mtrpln, function(item){
          //     return item;
          //    }));
          //   }
          // });
        }
      }
     });
});

function rupiah(nStr) {
       nStr += '';
       x = nStr.split('.');
       x1 = x[0];
       x2 = x.length > 1 ? '.' + x[1] : '';
       var rgx = /(\d+)(\d{3})/;
       while (rgx.test(x1))
       {
          x1 = x1.replace(rgx, '$1' + '.' + '$2');
       } 
       return "Rp " + x1 + x2;
}

 $(document).on('click','#showModal', function(){
     $('#modalHistory').modal();
 });

function onBuy(product_id, name, price) {
    var target = $('input[name="target"]').val();
    var no_meter_pln = $('input[name="no_meter_pln"]').val();
    $modal = $('#modalPIN');
    $modal.find('.product_name').html(name);
    $modal.find('.target').html(no_meter_pln?no_meter_pln:target);
    $modal.find('.price').html(rupiah(price));
    $modal.find('.product_id').html(product_id);

    $modal.find('input[name="target"]').val(target);
    $modal.find('input[name="produk"]').val(product_id);
    $modal.find('input[name="no_meter_pln"]').val(no_meter_pln);

    $modal.find('#pin').val('');
    $modal.find('input[name="pin"]').val('');
    $modal.find('.form-group').removeClass("has-error");
    $modal.find('#pin_error_message').html('');
    $modal.find('#pin_error').hide();

    $modal.modal();
}

function beliButton()
{
    $('#btn-submit-pin').prop('disabled',true);
    
    $('#order_form').submit()
    $modal = $('#modalPIN');
    var pin = $modal.find('#pin').val();

    if( pin.length >= 4 ) {
        $modal.find('input[name="pin"]').val(pin);
        $modal.find('.form-group').removeClass("has-error");
        $modal.find('#pin_error_message').html('');
        $modal.find('#pin_error').hide();
        $modal.find('form#order_form').submit();
    } else {
        $modal.find('.form-group').addClass("has-error");
        $modal.find('#pin_error_message').html('PIN tidak valid!');
        $modal.find('#pin_error').show();
    }
}
 
 function toGetPhone(phone){
    $('input[name=target]').val('');
    $('input[name=target]').val(phone);
    $('#modalHistory').modal('hide');
 }
     
 $(document).ready(function() {
    var table = $('#DataTableHistory').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        autoHight: false,
        // "iDisplayLength": 5,
        info: false, 
        "bFilter": false,
        "bLengthChange": false,
        "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        ajax:{
            url : "{{ route('beli.get.riwayat.datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        columns:[
                  {data: 'no', sClass: "text-left", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'produk', defaulContent: '-' },
                  {data: 'target', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                ]
     });
     
     $('#DataTableHistory tbody').on('click', 'tr', function () {
        getOperator();
        var data = table.row( this ).data();
        $('input[name=target]').val('');
        $('input[name=target]').val(data['target']);
        $('#modalHistory').modal('hide');
    } );
    
    
    $(function () {
       $('#DataTable').DataTable({
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "iDisplayLength": 50,
         "searching": false,
         "lengthChange": false,
         "info": false
       });
    });
    // =========================== Prefix Operator ==============================//
    var parent;
    var timerid;
    $(document).ready(function () {
        var idkategori = "<?php echo json_encode($kategori->id) ?>";
        $(".phone_number").on('input propertychange paste', function () {
            var no_hp = $(this).val();
            
            if( no_hp.length >= 3 )
            {
                var prefix = no_hp.substring(0, 4);
                
                if ( prefix.length == 4 || ["998","999"].includes(no_hp) )
                {
                    parent = $(this).closest("form");
    
                    clearTimeout(timerid);
                    timerid = setTimeout(function () {
                        getPulsa(prefix);
                    }, 500);
                }
            }
        });
    });
    
    function getOperator() {
        $('#operator').append('<option value="" selected="selected">Loading...</option>');
        $.ajax({
            url: "{{ url('/process/getoperator') }}",
            dataType: "json",
            type: "GET",
            data: {
                'category': $("#pembeliankategori_id").val()
            },
            success: function (response) {
                if(response.length != 0){
                    $('#operator').empty();
                    $('#operator').append('<option value="" selected="selected">Pilih Operator ...</option>');
                    $('#produk').empty();
                    $('#produk').append('<option value="" selected="selected">Pilih Produk ...</option>');
                    $.each(response, function(index, operatorObj){
                            if (operatorObj.status == 0) {
                                $('#operator').append('<option value="'+operatorObj.id+'" style="color: #C8C8C8;" disabled>'+operatorObj.product_name+'</option>');
                            }else{
                                $('#operator').append('<option value="'+operatorObj.id+'">'+operatorObj.product_name+'</option>');
                            }
                    });
                }
            },
            error: function (response) {
                toastr.error("Data tidak ditemukan, periksa kembali nomor handphone tujuan anda");
                $('#operator_'+value.product_name.split(' ').join('').toLowerCase()+'').empty();
                $('#operator_'+value.product_name.split(' ').join('').toLowerCase()+'').append('<option value="" selected="selected">Pilih Operator ...</option>');
                $('#produk_'+value.product_name.split(' ').join('').toLowerCase()+'').empty();
                $('#produk_'+value.product_name.split(' ').join('').toLowerCase()+'').append('<option value="" selected="selected">Pilih Produk ...</option>');
            }
        });
    }

    function getPulsa($prefix)
    {
        $('#product-list').empty();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        const operator = $('#operator');
        
        $.ajax({
            url: "{{ url('/member/process/prefixproduct') }}",
            dataType: "json",
            type: "get",
            data: {
                'prefix': $prefix,
                'parent': $("#pembeliankategori_id").val(),
                'no_product': (operator.length ? 1 : 0)
            },
            success: function (response) {
                if( operator.length ) {
                    if( response.operator.length > 0 ) {
                        operator.empty();
                        $.each(response.operator, function(i, op) {
                            operator.append('<option value="' + op.id + '">' + op.product_name + '</option>');
                        });
                        
                        operator.val(response.operator[0].id).change();
                    }
                }
                else if( response.produk.length > 0 )
                {
                    var html = '<div class="form-group product__list"><label>Produk :</label><ul class="list-group">';

                    $.each(response.produk, function(index, produkObj) {
                        if (produkObj.status == 1)
                        {
                            html += '<li class="list-group-item" onclick="onBuy(\'' + produkObj.product_id + '\', \'' + produkObj.product_name + '\', \'' + produkObj.price + '\')">';
                            html += '<div class="product__flex">';
                            html += '<div class="product__radio">';
                            html += '<input type="radio" id="product-' + produkObj.id + '" name="selector">';
                            html += '<div class="check"></div>';
                            html += '</div>';
                            html += '<label for="product-' + produkObj.id + '" class="product__width">';
                            html += '<div class="product__flex">';
                            html += '<div class="product__left product__title">';
                            html += produkObj.product_name;
                            html += '</div>';
                            html += '<div class="product__right product__price">';
                            html += rupiah(produkObj.price);
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="product__flex" style="margin-top: 1rem;">';
                            html += '<div class="product__left product__desc">';
                            html += produkObj.desc?produkObj.desc:'-';
                            html += '</div>';
                            html += '</div>';
                            html += '</label>';
                            html += '</div>';
                            html += '</li>';
                        }
                    });

                    html += '</ul></div>';

                    $(html).appendTo('#product-list');
                }
                else
                {
                    toastr.error("Produk tidak ditemukan");
                }
            },
            error: function (response) {
                toastr.error("Data tidak ditemukan, periksa kembali nomor handphone tujuan anda");
                $('#product-list').empty();
            }
    
        });
    }
    
    $('#operator').on('change', function(e) {

        var pembelianoperator_id = e.target.value;
        var pembeliankategori_id = {{$kategori->id}};

        $('#product-list').empty();

        if( parseInt(pembelianoperator_id) > 0 && parseInt(pembeliankategori_id) > 0 )
        {
            $.ajax({
                url: "{{ url('/member/process/findproduct') }}",
                dataType: "json",
                type: "GET",
                data: {
                    'pembelianoperator_id': pembelianoperator_id,
                    'pembeliankategori_id': pembeliankategori_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.length > 0)
                    {
                        var html = '<div class="form-group product__list"><label>Produk :</label><ul class="list-group">';

                        $.each(response, function(index, produkObj) {
                            if (produkObj.status == 1)
                            {
                                html += '<li class="list-group-item" onclick="onBuy(\'' + produkObj.product_id + '\', \'' + produkObj.product_name + '\', \'' + produkObj.price + '\')">';
                                html += '<div class="product__flex">';
                                html += '<div class="product__radio">';
                                html += '<input type="radio" id="product-' + produkObj.id + '" name="selector">';
                                html += '<div class="check"></div>';
                                html += '</div>';
                                html += '<label for="product-' + produkObj.id + '" class="product__width">';
                                html += '<div class="product__flex">';
                                html += '<div class="product__left product__title">';
                                html += produkObj.product_name;
                                html += '</div>';
                                html += '<div class="product__right product__price">';
                                html += rupiah(produkObj.price);
                                html += '</div>';
                                html += '</div>';
                                html += '<div class="product__flex" style="margin-top: 1rem;">';
                                html += '<div class="product__left product__desc">';
                                html += produkObj.desc?produkObj.desc:'-';
                                html += '</div>';
                                html += '</div>';
                                html += '</label>';
                                html += '</div>';
                                html += '</li>';
                            }
                        });

                        html += '</ul></div>';

                        $(html).appendTo('#product-list');
                    }
                    else
                    {
                        toastr.error("Produk tidak ditemukan");
                    }
                    
                },
                error: function (response) {
                    $('#produk').empty();
                    $('#produk').append('<option value="" selected="selected">-- Pilih Produk --</option>');
                    toastr.error("TERJADI KESALAHAN, SILAHKAN REFRESH HALAMAN DAN LAKUKAN LAGI.");
                }
        
            });
        }
    });

});
</script>

@if(Session::has('alert-success'))
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModalSuccess').modal('show');
    });
    $(function(){
  new Clipboard('.copy-text');
  $('.copy-text').on('click', function(){
      toastr.info("URL berhasil di salin");
  });
  
});
</script>
@endif
@endsection