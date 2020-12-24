<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-control" content="public">
        <meta name="robot" content="index, follow">
        <title>Daftar | {{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <!-- For Search Engine Meta Data  -->
        <meta name="description" content="Distributor & Server Pulsa Termurah dan Terlengkap yang menyediakan berbagai produk (Pulsa All operator, Pulsa Internet, Voucher Game Online, Token Listrik dan lain - lain)." />
        <meta name="keywords" content="Distributor, Distributor Puslsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, p-store.id, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa" />
        <meta name="author" content="{{$GeneralSettings->nama_sistem}}" />
        <meta property="business:contact_data:street_address" content="{{$GeneralSettings->alamat}}" />
        <meta property="business:contact_data:locality" content="Ngawi" />
        <meta property="business:contact_data:postal_code" content="63263" />
        <meta property="business:contact_data:country_name" content="Indonesia" />
        <meta property="business:contact_data:email" content="{{$GeneralSettings->email}}" />
        <meta property="business:contact_data:phone_number" content="{{$GeneralSettings->hotline}}" />
        <meta property="business:contact_data:website" content="{{$GeneralSettings->website}}" />
        
        <!-- Social Media Metta -->
        <meta property="fb:admins" content="{{$GeneralSettings->nama_sistem}}"/>
        <meta property="og:site_name" content="{{$GeneralSettings->nama_sistem}}">
        <meta property="og:url" content="{{ $actual_link }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Daftar | {{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}">
        <meta property="og:description" content="Distributor & Server Pulsa Termurah dan Terlengkap yang menyediakan berbagai produk (Pulsa All operator, Pulsa Internet, Voucher Game Online, Token Listrik dan lain - lain).">
        <meta property="og:image" content="https://p-store.id/assets/images/banner_1.png">
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="">
        <meta name="twitter:creator" content="">
        <meta name="twitter:url" content="{{ $actual_link }}">
        <meta name="twitter:title" content="Daftar | {{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}">
        <meta name="twitter:description" content="Distributor & Server Pulsa Termurah dan Terlengkap yang menyediakan berbagai produk (Pulsa All operator, Pulsa Internet, Voucher Game Online, Token Listrik dan lain - lain).">
        <meta name="twitter:image" content="https://hijaupay.com/assets/images/slider/slider_ke2.png">
        
        <!-- Add to home screen for mobile -->
        <link rel="manifest" href="/manifest.json">
        <!-- for Safari on iOS -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="#006CAA">
        <meta name="apple-mobile-web-app-title" content="{{$GeneralSettings->nama_sistem}}">
        <link rel="apple-touch-icon" href="/assets/images/icons/icon-152x152.png">
        <!-- for windows -->
        <meta name="msapplication-TileImage" content="/assets/images/icons/icon-144x144.png">
        <meta name="msapplication-TileColor" content="#2F3BA2">
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/icon" href="{{asset('/images/vaficon.png')}}"/>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('/admin-lte/plugin/iCheck/square/blue.css')}}">
    
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                margin: 0; 
            }
            .login-page,.register-page{
                background:#fff
            }
        </style>
    </head>
    <body class="hold-transition login-page" style="height:80%;">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><img src="{{ asset('images/logo-FIRTZPAY-2020.png?cache='.time()) }}" style="max-width:150px"></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <form action="{{url('/register')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        {!! $errors->first('name', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                     <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        {!! $errors->first('username', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" class="form-control" placeholder="Alamat Email" value="{{ old('email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        {!! $errors->first('email', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="number" name="phone" class="form-control" placeholder="Nomor Handphone" value="{{ old('phone') }}">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        {!! $errors->first('phone', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('city') ? ' has-error' : '' }}">
                        <input type="text" name="city" class="form-control" placeholder="Kota Sekarang" value="{{ old('city') }}">
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                        {!! $errors->first('city', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        {!! $errors->first('password', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Kata Sandi">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        {!! $errors->first('password_confirmation', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('pin') ? ' has-error' : '' }}">
                        <input type="number" name="pin" minlength="4" maxlength="4" class="form-control" placeholder="Buat 4 digit PIN transaksi">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        {!! $errors->first('pin', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    
                    
                    @if( !empty(Cookie::get('ref')) || !empty(request()->get('ref')) )
                    <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Kode Refferal (opsional)" value="{{ !empty(Cookie::get('ref')) ? Cookie::get('ref') : request()->get('ref') }}" readonly disabled>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    @else
                    <div class="form-group has-feedback {{ $errors->has('kode_referral') ? ' has-error' : '' }}">
                    <input type="text" name="kode_referral" maxlength="4" class="form-control" placeholder="Kode Refferal (opsional)">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    @endif
                    
                    <p style="font-size: 13px;text-align:center;">Dengan menekan Daftar Akun, saya mengkonfirmasi telah menyetujui <a href="{{url('/tos')}}" class="custom__text-green" style="color: #378CFF;text-decoration: underline;">Syarat dan Ketentuan</a>, serta <a href="{{url('/privacy-policy')}}" class="custom__text-green" style="color: #378CFF;text-decoration: underline;">Kebijakan Privasi</a> {{$GeneralSettings->nama_sistem}}.</p>
                    <div class="form-group">
                        <button type="submit" class="submit btn btn-primary btn-block btn-flat">Daftar</button>
                    </div>
                </form>
                <div align="center">
                    <span>Sudah punya akun?</span>
                    <h5 style="margin-top:5px;margin-bottom:0px;font-weight:bold;font-size:17px;"><a href="{{url('/login')}}" class="custom__text-green">Masuk Sekarang</a></h5>
                </div>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="{{asset('/admin-lte/plugin/iCheck/icheck.min.js')}}"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
            $('.submit').on('click', function(){
               $('.submit').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
               $('.submit').attr('style', 'cursor:not-allowed;pointer-events: none;');
            });
        </script>
        <script>
              function maxLengthCheck(object)
              {
                if (object.value.length > object.maxLength)
                  object.value = object.value.slice(0, object.maxLength)
              }
        </script>
    </body>
</html>