@extends('layouts.member')

@section('content')
<style type="text/css">
aside.sidebar .single {
     padding: 30px 15px;
     margin-top: 0;
     background: #fcfcfc;
     border: 1px solid #f0f0f0;
}
 aside.sidebar .single h3.side-title {
     margin: 0;
     margin-bottom: 0;
     padding: 0;
     font-size: 20px;
     color: #333;
     text-transform: uppercase;
}
 aside.sidebar .single h3.side-title:after {
     content: '';
     width: 60px;
     height: 1px;
     background: #00b0ff;
     display: block;
     margin-top: 6px;
}
 .single.contact-info {
     text-align: left;
     background: none;
     border: none;
}
 .single.contact-info li {
     margin-top: 30px;
}
 .single.contact-info li .icon {
     display: block;
     float: left;
     margin-right: 10px;
     width: 50px;
     height: 50px;
     border-radius: 50%;
     border: 1px solid #f0f0f0;
     color: #00b0ff;
     text-align: center;
     line-height: 50px;
}
 .single.contact-info li .info {
     overflow: hidden;
}

</style>
<section class="content-header hidden-xs">
  <h1>Layanan <small>Bantuan</small></h1>
   <ol class="breadcrumb">
      <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Layanan Bantuan</li>
   </ol>
   </section>
   <section class="content">
      <div class="row" style="margin-top:10px;">
          <div class="col-md-12">
            <div class="box">
               <div class="box-header">
                  <h3 class="box-title">Layanan Bantuan</h3>
              </div>
              <div class="box-body" style="text-align: center">
                <div class="row" style="margin-top:10px;">
                  <div class="col-md-12">

              <aside class="sidebar">
                <div class="single contact-info">
                  <h3 class="side-title">Contact Information</h3>
                  <div class="row">
                      @php
                          $chunk = array_chunk($layananbantuan,3);
                      @endphp
                      @foreach($chunk as $row)
                          @foreach($row as $list)
                            <div class="col-md-4">
                              <ul class="list-unstyled">
                                <li>
                                  <div class="icon"><i class="fa fa-{{$list['icon']}}"></i></div>
                                  <div class="info"><p><b>{{$list['title']}}</b> <br><div class="text-muted">{{$list['description']}}</div></p></div>
                                </li>
                              </ul>
                            </div>
                          @endforeach
                      @endforeach
                  </div>
                </div>
                <aside class="sidebar">
                <div class="single contact-info">
                <h3 class="side-title"><b>Pilih bantuan di bawah ini</h3><b>
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-group">
                            <a href="https://api.whatsapp.com/send?phone='.{{$wa->description}}.'&text=Halo%20admin%20saya%20mau%20komplain%20transaksi" class="btn-loading list-group-item {{ url('/member/biodata')  == request()->url() ? 'active' : '' }}"><i class="fa fa-handshake-o" style="margin-right: 5px;"></i> Komplain Transaksi</a>
                            <a href="https://api.whatsapp.com/send?phone='.{{$wa->description}}.'&text=Halo%20admin%20saya%20mau%20konfirmasi%20deposit%20" class="btn-loading list-group-item {{ url('/member/ubah-password')  == request()->url() ? 'active' : '' }}"><i class="fa fa-cc-mastercard" style="margin-right: 5px;"></i> Konfirmasi Deposit</a>
                            <a href="https://api.whatsapp.com/send?phone='.{{$wa->description}}.'&text=Halo%20admin%20deposit%20saya%20kok%20belum%20masuk" class="btn-loading list-group-item {{ url('/member/ubah-password')  == request()->url() ? 'active' : '' }}"><i class="fa fa-credit-card-alt" style="margin-right: 5px;"></i> Deposit Belum Masuk</a>
                            </div>
                </section>
                

                  </div>
              </div>
            </div>
          </div>
      </div>
   </div>
</section>
@endsection