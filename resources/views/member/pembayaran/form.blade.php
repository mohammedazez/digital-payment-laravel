@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
	<h1>Transaksi <small>{{$kategori->product_name}}</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Pembayaran</a></li>
    	<li class="active">{{$kategori->product_name}}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>{{$kategori->product_name}}</h3>
                </div>
                <form action="{{url('/member/process/cektagihan')}}" method="POST">
                <div class="box-body">
                    {{csrf_field()}}
                    <input type="hidden" name="type" id="pembayarankategori_id" value="{{$kategori->id}}">
                    <div class="form-group{{ $errors->has('operator') ? ' has-error' : '' }}" hidden>
                        <label>Kategori Tagihan : </label>
                        <select name="operator" id="operator" class="form-control">
                            <option value="">Pilih Tagihan ...</option>
                            @foreach($kategori->pembayaranoperator as $data)
                                <!--<option value="{{$data->id}}" {{ old('operator') == $data->id ? 'selected' : '' }}>{{$data->product_name}}</option>-->
                                <option value="{{$data->id}}" {{ $kategori->id == $data->pembayarankategori_id ? 'selected' : '' }}>{{$data->product_name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('operator', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group{{ $errors->has('produk') ? ' has-error' : '' }}">
                        <label>Jenis Tagihan : </label>
                        <select name="produk" id="produk" class="form-control">
                            <option value="">Pilih Jenis Tagihan ...</option>
                            @foreach($produk as $pd)
                                <!--<option value="{{$pd->id}}">{{$pd->product_name}}</option>-->
                                <option value="{{$pd->code}}">{{$pd->product_name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('produk', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group{{ $errors->has('nomor_rekening') ? ' has-error' : '' }}">
                        <label>No. Rekening/ID Pelanggan : </label>
                        <input type="text" name="nomor_rekening" class="form-control" value="{{ old('nomor_rekening') }}" placeholder="Masukkan Nomor Pelanggan" autocomplete="off">
                        {!! $errors->first('nomor_rekening', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
                        <label>Nomor HP Pembeli : </label>
                        <input type="number" id="number" name="target" id="target" class="form-control phone_number" value="{{ old('target') }}" placeholder="Masukkan Nomor Handphone" autocomplete="off">
                        {!! $errors->first('target', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group{{ $errors->has('pin') ? ' has-error' : '' }}">
                        <label>Pin : </label>
                        <input type="number" id="number" name="pin" class="form-control pin" placeholder="Masukkan PIN anda" autocomplete="off" autofocus>
                        {!! $errors->first('pin', '<p class="help-block"><small>:message</small></p>') !!}
                        <p><i>Untuk melihat pin anda,silahkan lihat di profile!</i></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="cek_tagihan" class="submit btn btn-primary btn-block">&nbsp;&nbsp;Cek Tagihan&nbsp;&nbsp;</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 hidden-xs hidden-sm">
            <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label"><span class="custom__bg-greenTwo" style="padding-right: 20px;padding-left: 20px;">3 Transaksi Terakhir</span></li>
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
                    <i class="fa fa-exclamation-circle custom__bg-greenTwo"></i>
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
</section>
@endsection
@section('js')
<script type="text/javascript">
$( document ).ready(function() {
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
        
        
     $('input[name=target]').typeahead({
      source: function(query, result)
      {
          $.ajax({
            url : "{{ route('beli.get.typehead') }}",
            method:"POST",
            data:{ _token: "{{csrf_token()}}", query:query},
            dataType:"json",
            success:function(target)
            {
              result($.map(target, function(item){
              return item;
             }));
            }
          })
      }
     });
    
        // Select your input element.
        var number = document.getElementById('number');
        
        // Listen for input event on numInput.
        number.onkeydown = function(e) {
           if(!((e.keyCode > 95 && e.keyCode < 106)
             || (e.keyCode > 47 && e.keyCode < 58) 
             || e.keyCode == 8)) {
               return false;
           }
        }
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
        
        $('#operator').on('change', function(e){
           var pembayaranoperator_id = e.target.value;
           var pembayarankategori_id = {{$kategori->id}};
           $('#produk').empty();
           $('#produk').append('<option value="" selected="selected">Loading...</option>');
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/member/process/findproductpembayaran') }}",
                dataType: "json",
                type: "POST",
                data: {
                    'pembayaranoperator_id': pembayaranoperator_id,
                    'pembayarankategori_id': pembayarankategori_id
                },
                success: function (response) {
                    $('#produk').empty();
                    $('#produk').append('<option value="" selected="selected">-- Pilih Jenis Tagihan --</option>');
                    $.each(response, function(index, produkObj){
                        $('#produk').append('<option value="'+produkObj.code+'">'+produkObj.product_name+'</option>');
                    });
                },
                error: function (response) {
                    toastr.error("TERJADI KESALAHAN, SILAHKAN REFRESH HALAMAN DAN LAKUKAN LAGI.");
                }
        
            });
        });
        
        // $('#produk').on('change', function(e){
        //   $('#produk_ppob').val(event.target.options[event.target.selectedIndex].text);
        // });
        
        // $('#cek_tagihan').on('click', function(){
        //   $('#cek_tagihan').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
        //   $('#cek_tagihan').attr('style', 'cursor:not-allowed;pointer-events: none;');
        //   var target = $('input[name="target"]').val();
        //   $('#target_phone').val(target);
        //   $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ url('/member/process/cektagihan') }}",
        //         dataType: "json",
        //         type: "POST",
        //         data: {
        //             'produk': $('#produk').val(),
        //             'nomor_rekening': $('input[name="nomor_rekening"]').val(),
        //             'target': $('input[name="target"]').val()
        //         },
        //         success: function (response) {
        //             $('#cek_tagihan').html("Cek Tagihan");
        //             $('#cek_tagihan').removeAttr('style');
        //             if ((response.errors)) {
        //                 toastr.error("Semua data wajib diisi, tidak boleh ada data yang kosong.");
        //             }else{
        //                 if (response.error) {
        //                     $('#detail').html('<div align="center"><h4 style="font-weight:bold;">'+response.message+'</h4></div>');
        //                 }else{
        //                     $('#nama').text(response.data.nama);
        //                     $('#periode').text(response.data.periode);
        //                     $('#jumlah_tagihan').text(rupiah(response.data.jumlah_tagihan));
        //                     $('#admin').text(rupiah(response.data.admin));
        //                     $('#jumlah_bayar').text(rupiah(response.data.jumlah_bayar));
        //                     $('#tagihan_id').val(response.data.tagihan_id);
        //                     $('#harga').val(response.data.jumlah_bayar);
        //                     $('#bulan').val(response.data.periode);
        //                     $('.submit').removeClass('hidden');
        //                 }
        //             }
        //         },
        //         error: function (response) {
        //             $('#cek_tagihan').html("Cek Tagihan");
        //             $('#cek_tagihan').removeAttr('style');
        //             toastr.error("TERJADI KESALAHAN, SILAHKAN REFRESH HALAMAN DAN LAKUKAN LAGI.");
        
        //         }
        //     });
        // });

});
</script>
@endsection