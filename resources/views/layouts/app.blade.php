<?php $actual_link = "https://".@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI']; ?>
<!DOCTYPE html>
<html lang="id">
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

   <title>@yield('title')</title>
  
   <!-- Basic Page Needs
   ================================================== -->
   
   
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta http-equiv="Cache-control" content="public">
   <meta name="robot" content="index, follow">
   <!-- Mobile Specific Metas
   ================================================== -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
  
   <!-- For Search Engine Meta Data  -->
   <meta name="description" content="@yield('description')" />
   <meta name="keywords" content="@yield('keywords')" />
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
   <meta property="og:title" content="@yield('title')">
   <meta property="og:description" content="@yield('description')">
   <meta property="og:image" content="@yield('img')">

   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:site" content="">
   <meta name="twitter:creator" content="">
   <meta name="twitter:url" content="{{ $actual_link }}">
   <meta name="twitter:title" content="@yield('title')">
   <meta name="twitter:description" content="@yield('description')">
   <meta name="twitter:image" content="@yield('img')">
   
   <!-- for Safari on iOS -->
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="#006CAA">
   <meta name="apple-mobile-web-app-title" content="{{$GeneralSettings->nama_sistem}}">
   <link rel="apple-touch-icon" href="/assets/images/icons/logo.png">
   <!-- for windows -->
   <meta name="msapplication-TileImage" content="/assets/images/icons/logo.png">
   <meta name="msapplication-TileColor" content="#2F3BA2">

   <!-- Favicon -->
   <link rel="shortcut icon" type="image/icon" href="{{asset('/images/logo.png')}}"/>
   
    <!-- Main structure css file -->
    <link  rel="stylesheet" href="{{asset('/assets/style.css')}}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{asset('/assets/responsive.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-flash.min.css">
    
    <link rel="stylesheet" href="{{ url('/css/app.css?rev='.time()) }}">
   
  @yield('css')
   <style>
    @media screen and (max-width: 780px) {
        
        .member-area{
            margin-top:8px;
        }
            
    }
    
    .navbar-default .navbar-nav>li>a{
        padding: 30px 10px;
    }
    
    input[type=checkbox]:checked{
      color: #f00 !important;
    } 
    
    </style>
    @yield('style')
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id="></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', '');
    </script>
    <!-- End - Google Analytics -->
    
 <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','');</script>
<!-- End Google Tag Manager -->
   </head>
  
   <body>
       <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id="
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
   <!-- Start Preloader
   <div id="preload-block">
      <div class="square-block"></div>  
   </div>
   End Preloader -->
  
   <!-- Start Header Section -->
   <header id="header">
      <!-- Start Main Menu -->
      <nav id="mainnav" class="navbar navbar-default" role="navigation">
         <div class="container">
            <div class="navbar-header">
               <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
               </button>
               <!-- Start Brand/Logo Block -->
               <a class="navbar-brand" href="{{url('/')}}">
                  <img class="logo-scroll img-responsive" src="{{ asset('images/logo.png') }}" alt="logo" style="max-width: 150px;">
                  <img class="logo-dark-scroll img-responsive" src="{{ asset('images/logo.png') }}" style="display: none;max-width: 150px;">
               </a>
            </div>
            <!--  Collect the nav links, forms, and other content for toggling  -->
            <div id="navbar" class="navbar-collapse collapse">
               <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
                  <li class="{{ url('/') == request()->url() ? 'active' : '' }}"><a href="{{url('/')}}" class="page-scroll">Home</a></li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Panduan</a>
                     <ul class="dropdown-menu">
                        <li><a href="{{ url('/cara-transaksi') }}" class="page-scroll">Cara Transaksi</a></li>
                        <li><a href="{{ url('/deposit') }}" class="page-scroll">Cara Deposit</a></li>
                     </ul>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Harga Produk</a>
                     <ul class="dropdown-menu" style="max-height: 400px;overflow-y: scroll;overflow-x: none">
                        @foreach($KategoriPembelian as $data)
                        <li><a href="{{url('/price/pembelian', $data->slug)}}" class="page-scroll">{{$data->product_name}}</a></li>
                        @endforeach
                        @foreach($KategoriPembayaran as $data)
                        <li><a href="{{url('/price/pembayaran', $data->slug)}}" class="page-scroll">{{$data->product_name}}</a></li>
                        @endforeach
                     </ul>
                  </li>
                  <li class="{{ url('/#contactus') == request()->url() ? 'active' : '' }}"><a href="{{url('/#contactus')}}" class="page-scroll">Kontak Kami</a></li>
                  @if(Auth::check())
                  <li class="member-area"><a href="{{url('/member')}}"><span class="border">Member Area</span></a></li>
                  @else
                  <li class="member-area"><a href="#!" onclick="loginPopup()"><span class="border">Login</span></a></li>
                  <li class="member-area"><a href="{{url('/register')}}"><span class="border">Register</span></a></li>
                  @endif
               </ul>       
            </div><!--/.nav-collapse -->
         </div>   
      </nav>  
      <!-- End Main Menu -->  
   </header>
   <!-- End Header Section --> 
  
   @yield('content')

  
   <!-- Start Footer Section -->
   <footer>
      <div class="container">
         <div class="row">
            <div class="col-sm-8 col-md-6">
               <div class="available-store">
                  <a href="{{ env('PLAYSTORE_APP_URL', '#!') }}" target="_blank" class="btn btn-platform">
                     <span class="fa fa-android"></span>
                     <em> Download di </em> Google Play
                  </a>
                  <a href="{{ env('APPSTORE_APP_URL', '#!') }}" class="btn btn-platform">
                     <span class="fa fa-apple"></span>
                     <em> Download di </em> App Store
                  </a>
               </div>
            </div>
            <div class="col-sm-4 col-md-6">
            </div>
         </div>
         <div class="row">
            <div class="copyright">
               <div class="col-sm-5 col-md-5">
                  <p>&copy; {{date("Y")}} {{ $GeneralSettings->nama_sistem }}</p>
               </div>
               <div class="col-sm-5 text-center">
                  <ul class="inline-menu list-unstyled">
                     <li><a class="inline-menu-item" href="{{url('/about')}}">Tentang Kami</a></li>
                     <li><a class="inline-menu-item" href="{{url('/tos')}}">Terms of Service</a></li>
                     <li><a class="inline-menu-item" href="{{url('/privacy-policy')}}">Kebijakan Privasi</a></li>
                  </ul>
               </div>
               <div class="col-sm-2 col-md-2">
                  <ul class="social-links text-right">
                     <li><a href="{{$GeneralSettings->facebook_url}}" class="ico-facebook"><span class="fa fa-facebook"></span></a></li>
                     <li><a href="{{$GeneralSettings->instagram_url}}" class="ico-instagram"><span class="fa fa-instagram"></span></a></li>
                     <li><a href="{{$GeneralSettings->twitter_url}}" class="ico-twitter"><span class="fa fa-twitter"></span></a></li>
                  </ul>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </footer>
   <!-- /Footer Section -->
   
   @if(!Auth::check())
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="max-width: 340px;margin: auto;top: 120px;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Login</h4>
          </div>
          <div class="modal-body">
            <form action="{{url('/login')}}" method="post">
                {{csrf_field()}}
                <div class="form-group has-feedback {{ isset($errors) ? ($errors->has('phone') ? ' has-error' : '') : '' }}">
                    <input type="number" name="phone" class="form-control" placeholder="Nomor Handphone">
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    {!! isset($errors) ? $errors->first('phone', '<p class="help-block"><small>:message</small></p>') : '' !!}
                </div>
                <div class="form-group has-feedback {{ isset($errors) ? ($errors->has('password') ? ' has-error' : '') : '' }}" style="margin-bottom:0px;">
                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    {!! isset($errors) ? $errors->first('password', '<p class="help-block"><small>:message</small></p>') : '' !!}
                </div>
                <div class="row" style="margin-bottom: 0px;">
                    <div class="col-xs-6">
                        <div class="checkbox icheck" align="left">
                            <label>
                                <input type="checkbox" name="remember" checked> <span style="margin-left:5px;">Ingat Saya</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="checkbox icheck" align="right">
                            <a href="{{ url('/password/reset') }}" style="text-decoration: underline;"><span>Lupa Kata Sandi</span></a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! app('captcha')->renderCaptchaHTML() !!}
                    <button type="submit" class="submit btn btn-primary btn-block btn-flat">Masuk</button>
                </div>
            </form>
          </div>
      </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
   @endif
    
   <!-- Javascript Files -->

   <!-- initialize jQuery Library -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/jquery-2.2.4.min.js"></script>
   <!-- for Bootstrap js -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/bootstrap.min.js"></script>
   <!-- for Morphext js-->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/morphext.min.js"></script>
   <!-- for owl carousel slider js -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/owl.carousel.min.js"></script>
   <!-- for Bootstrap-validator js -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/validator.js"></script>
   <!-- for Ajax Contact js -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/ajax-contact.js"></script>
   <!-- for jQuery easing js -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/jquery.easing.min.js"></script>
   <!-- for twitter plugin -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/twitsFetcher.js"></script>
   <!-- for smooth animatin  -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/wow.min.js"></script>  
   <!-- for video plugin with youtube -->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/video.min.js"></script>
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/youtube.min.js"></script>
   <!-- Custom js-->
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/637e0488/assets/js/custom.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    
    <script>
            function loginPopup(){
                $('#navbar').collapse('hide');
              $('#myModal').modal('show');
            }
    </script>
    
    @yield('js')
   
   </body> 
</html>