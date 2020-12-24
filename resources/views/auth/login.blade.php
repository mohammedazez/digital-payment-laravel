<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Cache-control" content="public">
        <meta name="robot" content="index, follow">
        <title>Masuk | {{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <!-- For Search Engine Meta Data  -->
        <meta name="description" content="Distributor & Server Pulsa Termurah dan Terlengkap yang menyediakan berbagai produk (Pulsa All operator, Pulsa Internet, Voucher Game Online, Token Listrik dan lain - lain)." />
        <meta name="keywords" content="Distributor, Distributor Puslsa, Pulsa, Server Pulsa, Pulsa H2H, Pulsa Murah, distributor pulsa elektrik termurah dan terpercaya, Pulsa Isi Ulang, Pulsa Elektrik, Pulsa Data, Pulsa Internet, Voucher Game, Game Online, Token Listrik, Token PLN, Pascaprabayar, Prabayar, PPOB, Server Pulsa Terpercaya, Bisnis Pulsa Terpercaya, Bisnis Pulsa termurah, website pulsa" />
        <meta name="author" content="{{$GeneralSettings->nama_sistem}}" />
        <meta property="business:contact_data:street_address" content="{{$GeneralSettings->alamat}}" />
        <meta property="business:contact_data:locality" content="Makassar" />
        <meta property="business:contact_data:postal_code" content="90222" />
        <meta property="business:contact_data:country_name" content="Indonesia" />
        <meta property="business:contact_data:email" content="{{$GeneralSettings->email}}" />
        <meta property="business:contact_data:phone_number" content="{{$GeneralSettings->hotline}}" />
        <meta property="business:contact_data:website" content="{{$GeneralSettings->website}}" />
        
        <!-- Social Media Metta -->
        <meta property="fb:admins" content="{{$GeneralSettings->nama_sistem}}"/>
        <meta property="og:site_name" content="{{$GeneralSettings->nama_sistem}}">
        <meta property="og:url" content="{{ $actual_link }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Masuk | {{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}">
        <meta property="og:description" content="Distributor & Server Pulsa Termurah dan Terlengkap yang menyediakan berbagai produk (Pulsa All operator, Pulsa Internet, Voucher Game Online, Token Listrik dan lain - lain).">
        <meta property="og:image" content="https://hijaupay.com/assets/images/slider/slider_ke2.png">
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="">
        <meta name="twitter:creator" content="">
        <meta name="twitter:url" content="{{ $actual_link }}">
        <meta name="twitter:title" content="Masuk | {{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}">
        <meta name="twitter:description" content="Distributor & Server Pulsa Termurah dan Terlengkap yang menyediakan berbagai produk (Pulsa All operator, Pulsa Internet, Voucher Game Online, Token Listrik dan lain - lain).">
        <meta name="twitter:image" content="https://tripay.co.id/assets/images/banner_1.png">
        
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
                @if(Session::has('alert-success'))
                    <div class="alert alert-success alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                       <h4><i class="fa fa-check"></i>Berhasil</h4>
                       <p>{!! Session::get('alert-success') !!}</p>
                    </div>
                @endif
                @if (session('alert-error'))
                    <div class="alert alert-error alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <h4><i class="fa fa-ban fa-fw" style="margin-right: 5px;"></i>{{ session('alert-error') }}</h4>
                    </div>
                @endif
                
                <form action="{{url('/login')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="number" name="phone" class="form-control" placeholder="Nomor Handphone">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        {!! $errors->first('phone', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}" style="margin-bottom:0px;">
                        <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        {!! $errors->first('password', '<p class="help-block"><small>:message</small></p>') !!}
                    </div>
                    <div class="row" style="margin-bottom: 0px;">
                        <div class="col-xs-6">
                            <div class="checkbox icheck" align="left">
                                <label>
                                    <input type="checkbox" class="custom__check-green" name="remember" checked> <span style="margin-left:5px;">Ingat Saya</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="checkbox icheck" align="right">
                                <a href="{{ url('/password/reset') }}" class="custom__text-green" style="text-decoration: underline;"><span>Lupa Kata Sandi</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit btn btn-primary btn-block btn-flat">Masuk</button>
                    </div>
                </form>
                
                <!--<div class="social-auth-links text-center">
                    <p>- OR -</p>
                   <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-social btn-facebook">
                        <i class="fa fa-facebook"></i> Login dengan Facebook
                    </a>
                    <a href="{{ url('auth/google') }}" class="btn btn-block btn-social btn-google">
                        <i class="fa fa-google-plus" style="font-size:17px;"></i> Login dengan Google+
                    </a>
                </div>-->
                <div align="center">
                    <span>Belum punya akun?</span>
                    <h5 style="margin-top:5px;margin-bottom:0px;font-weight:bold;font-size:17px;"><a href="{{url('/register')}}" class="custom__text-green">Daftar Sekarang</a></h5>
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
    </body>
</html>