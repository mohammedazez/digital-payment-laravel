@extends('layouts.member')

@section('content')
<style>
table.grid {
    width:100%;
    border:none;
    background-color:#3c8dbc;
    padding:0px;
}
table.grid tr {
    text-align:center;
}
table.grid td {
    border:4px solid white;
    padding:6px;
}
.margin-top-responsive-5{
    margin-top:5px;
}
.btn-grid{
    background:#325d88;
    color:#ffffff;
}
td.active{
    background:#367fa9;
}
 .bungkus {
    position: relative;
    text-align: center;
}

.center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /*font-size: 18px;*/
}

.img-profile { 
    /*width: 100%;*/
    /*height: auto;*/
    opacity: 0.3;
}
.fa-check {
    opacity:0.5;               /* Opacity (Transparency) */
    color: rgba(0, 0, 0, 0.75);   /* RGBA Color (Alternative Transparency) */
}
.fa-check {
    color: #444;
}

.img-verif-profile{
    max-width:80px;
    /*opacity: 0.3;*/
}

@media screen and (max-width: 780px) {
    .grid small{
        font-size:11px;
    }
    .margin-top-responsive-5{
        margin-top:0px;
    }	
}
</style>
<section class="content-header hidden-xs">
    <h1>Data Profile <small>{{Auth::user()->name}}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Profile</a></li>
    	<li class="active">{{Auth::user()->name}}</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-solid">
            <div class="box-header with-border header-profile" style="display:none;">
                <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a><b>DATA PROFIL</b></h3>
            </div>
            <div class="box-body box-profile">
                <!--{{$notifValidation}}-->
                @if($notifValidation == 0)
                        @if(Auth::user()->image != null)
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" alt="{{Auth::user()->name}}">
                        @else
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('/ibh/images/default-avatar.svg')}}" alt="{{Auth::user()->name}}">
                        @endif
                @else
                    <div class="bungkus">
                        @if(Auth::user()->image != null)
                        <img class="profile-user-img img-responsive img-circle img-profile" src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" alt="{{Auth::user()->name}}">
                        @else
                        <img class="profile-user-img img-responsive img-circle img-profile" src="{{asset('admin-lte/dist/img/avatar5.png')}}" alt="{{Auth::user()->name}}">
                        @endif
                        <!--<div class="center"><i class="fa fa-check" style="font-size:68px;"></i></div>-->
                        <div class="center"><img  class="img-verif-profile" src="{{asset('img/log-verified.png')}}" alt="{{Auth::user()->name}}"></div>
                    </div>
                @endif
                <h3 class="profile-username text-center" style="font-size:18px;margin-bottom:5px;">{{Auth::user()->name}}</h3>
                <p class="text-muted text-center"><i class="fa fa-money" style="margin-right:5px;"></i> Rp {{number_format(Auth::user()->saldo, 0, '.', '.')}},-</p>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="list-group">
                            <a href="{{url('/member/biodata')}}" class="btn-loading list-group-item {{ url('/member/biodata')  == request()->url() ? 'active' : '' }}"><i class="fa fa-user" style="margin-right: 5px;"></i> Ubah Biodata</a>
                            <a href="{{url('/member/ubah-password')}}" class="btn-loading list-group-item {{ url('/member/ubah-password')  == request()->url() ? 'active' : '' }}"><i class="fa fa-unlock" style="margin-right: 5px;"></i> Ubah Kata Sandi</a>
                            <a href="{{url('/member/picture')}}" class="btn-loading list-group-item {{ url('/member/picture')  == request()->url() ? 'active' : '' }}"><i class="fa fa-image" style="margin-right: 5px;"></i> Ubah Foto Profile</a>
                            <a href="{{url('/member/rekening-paypal')}}" class="btn-loading list-group-item {{ url('/member/rekening-paypal')  == request()->url() ? 'active' : '' }}"><i class="fa fa-paypal" style="margin-right: 5px;"></i> Rekening PayPal</a>
                            <a href="{{url('/member/testimonial')}}" class="btn-loading list-group-item {{ url('/member/testimonial')  == request()->url() ? 'active' : '' }}"><i class="fa fa-commenting" style="margin-right: 5px;"></i> Kirim Testimonial</a>
                            <a href="{{url('/member/rekening-bank')}}" class="btn-loading list-group-item {{ url('/member/rekening-bank')  == request()->url() ? 'active' : '' }}"><i class="fa fa-university" style="margin-right: 5px;"></i> Alamat Bank</a>
                            <a href="{{url('/member/pin')}}" class="btn-loading list-group-item {{ url('/member/pin')  == request()->url() ? 'active' : '' }}"><i class="fa fa-key" style="margin-right: 5px;"></i> Pin</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-green box-penjelasan">
            <div class="box-header with-border">
                <h3 class="box-title">Tentang Saya</h3>
                <div class="box-tools pull-right box-minus" style="display:none;">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-envelope margin-r-5"></i>  Alamat Email</strong>
                <p class="text-muted">{{Auth::user()->email}}</p>
                <hr style="margin-top:5px;margin-bottom:5px;">
                <strong><i class="fa fa-mobile margin-r-5"></i>  Nomor Handphone</strong>
                <p class="text-muted">{{Auth::user()->phone}}</p>
                <hr style="margin-top:5px;margin-bottom:5px;">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Kota</strong>
                <p class="text-muted">{{Auth::user()->city}}</p>
                <hr style="margin-top:5px;margin-bottom:5px;">
                <strong><i class="fa fa-clock-o margin-r-5"></i> Tanggal Bergabung</strong>
                <p class="text-muted">{{Auth::user()->created_at}}</p>
                <hr style="margin-top:5px;margin-bottom:5px;">
                <strong><i class="fa fa-sign-in margin-r-5"></i> Login Terakhir</strong>
                <p class="text-muted">{{Auth::user()->last_login}}</p>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-9">
        @yield('profile')
    </div>
</div>

</section><!-- /.content -->
@endsection

@section('js')
<script>
$(function(){
  new Clipboard('.copy-text');
  $('.copy-text').on('click', function(){
      toastr.info("URL berhasil di salin");
  });
  
});
</script>
@endsection