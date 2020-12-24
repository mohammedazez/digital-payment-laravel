<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>{{$GeneralSettings->nama_sistem}} | Member</title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{asset('img/')}}">
   @yield('meta')
    @if(isset($logoku[0]))
      @if($logoku[0]->img !='' || $logoku[0]->img !=null)
        <link rel="shortcut icon" type="image/icon" href=" {{asset('img/logo/'.$logoku[0]->img.'')}}" style="width:16px;height: 16px;"/>
      @endif
    @endif
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.min.css">
   <link rel="stylesheet" href="https://cdn.rawgit.com/miselputra/larakost-pulsa/12257429/assets/css/et-line-font.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"> 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-flash.min.css">

   
    <!-- Matrial Design-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">

   <!-- Ico Fonts -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icofont/css/icofont.css')}}">
   
    <style>
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
        
        .awe{
          margin: 0 auto;
          width: 45px;
          /*padding: 3px;*/
          /*border: 3px solid #d2d6de;*/
        }
        
        .img-verif{
            max-width:40px;
            /*opacity: 0.3;*/
        }
    </style>
   <!-- Google Font -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id="></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', '');
    </script>
    <!-- End - Google Analytics -->

   <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
   

   <!-- for Safari on iOS -->
   <meta name="apple-mobile-web-app-capable" content="yes">
   <meta name="apple-mobile-web-app-status-bar-style" content="#006CAA">
   <meta name="apple-mobile-web-app-title" content="{{ $GeneralSettings->nama_sistem }}">
   <link rel="apple-touch-icon" href="/assets/images/icons/logo.png">
   <!-- for windows -->
   <meta name="msapplication-TileImage" content="/assets/images/icons/logo.png">
   <meta name="msapplication-TileColor" content="#2F3BA2">

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
        table.dataTable thead .sorting:after{opacity:0.2;content:""}
        table.dataTable thead .sorting_asc:after{content:""}
        table.dataTable thead .sorting_desc:after{content:""}

        th.sorting_asc::after, th.sorting_desc::after { content:"" !important; }

        div.dataTables_wrapper div.dataTables_paginate{margin-right: 5px;}
   </style>
   
    <!--<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>-->
    <script>
        //var OneSignal = window.OneSignal || [];
        //OneSignal.push(["init", {
            //appId: "936202ff-f758-466b-ab06-7c0a40757c71",
            //autoRegister: true,
            //notifyButton: {
                //enable: false /* Set to false to hide */
            //},
            //welcomeNotification: {
                //"title": "{{$GeneralSettings->nama_sistem}} | {{$GeneralSettings->motto}} {{date('Y')}}",
                //"message": "Terima kasih telah berlangganan!",
                // "url": "" /* Leave commented for the notification to not open a window on Chrome and Firefox (on Safari, it opens to your webpage) */
            //}
        //}]);
    </script>
  
</head>
<body class="hold-transition {{$GeneralSettings->skin}} fixed sidebar-mini">
   <div class="wrapper">

      <header class="main-header">
         <a href="{{url('/member')}}" class="logo custom__bg-greenHover">
            <span class="logo-mini"><b>P</b>S</span>
            @if(isset($logoku[2]))
              @if($logoku[2]->img !='' || $logoku[2]->img !=null)
                  <span class="logo-lg"><img src="{{asset('img/logo/'.$logoku[2]->img.'')}}" style="width:150px;"></span>
              @else
                  <span class="logo-lg"><b>PULSA TERLENGKAP</b></span>
              @endif
            @else
                <span class="logo-lg"><b>PULSA TERLENGKAP</b></span>
            @endif
         </a>
         <nav class="navbar navbar-static-top custom__bg-green" role="navigation">
            <a href="#" class="sidebar-toggle hidden-lg hidden-md hidden-sm" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
                  <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Pembayaran <i class="fa fa-bell-o"></i>
                        @if($countTagihan > 0)
                            <span class="label label-success">{{$countTagihan}}</span>
                        @else
                            <span class="label label-danger">0</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                            <li class="header">Anda Mempunyai {{$countTagihan}} Tagihan Belum Terbayar</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <table class="table table-hover table-condensed">
                                    @foreach($tagihanNonBuy as $tgh)
                                        <li>
                                                <tr>
                                    			  	<td>
                                                        <a href="{{url('/member/tagihan-pembayaran/'.$tgh['id'].'')}}" class="btn-loading" style="color: #464646">
                                            			  	    <div style="font-size: 12px;">#{{isset($tgh['id'])?$tgh['id'] : '-'}}</div>
                                            			  	    <div style="font-size: 14px;font-weight: bold;">{{isset($tgh['product_name'])?substr($tgh['product_name'], 0, 15).(strlen($tgh['product_name']) > 15 ? ' ...' : '') : '-'}}</div>
                                            			  	    <div style="font-size: 12px;">{{isset($tgh['no_pelanggan'])?$tgh['no_pelanggan'] : '-'}}</div>
                                            			  	    <div style="font-size: 12px;">{{isset($tgh['product_name'])?substr($tgh['nama'], 0, 15).(strlen($tgh['nama']) > 15 ? ' ...' : '') : '-'}}</div>
                                            			  	    <div style="font-size: 12px;">{{isset($tgh['periode'])?$tgh['periode'] : '-'}}</div>
                                            			 </a>
                                            			  	    
                                            		</td>
                                            		<td align="right">
                                            		    <a href="{{url('/member/tagihan-pembayaran/'.$tgh['id'].'')}}" class="btn-loading" style="color: #464646">
                                            			  	    <div><small><i class="fa fa-clock-o"></i> {{\Carbon\Carbon::createFromTimeStamp(strtotime($tgh['created_at']))->diffForHumans()}}</small></div>
                                                                <div><span class="label label-warning">{{($tgh['status'] == 0) ? "MENUNGGU" :(($tgh['status'] == 1) ? "PROSES" :(($tgh['status'] == 2) ? "BERHASIL" :"GAGAL"))}}</span></div>
                                                                <div><span class="label label-danger">Rp {{number_format($tgh->jumlah_bayar, 0, '.', '.')}}</span></div>
                                                        </a>
                                                    </td>
                                                </tr>
                                        </li>
                                    @endforeach
                                </table>
                            </ul>
                        </li>
                        <li class="footer"><a href="{{url('/member/tagihan-pembayaran')}}">See All</a></li>
                    </ul>
                  </li>
                  <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        @if($ctmsg > 0)
                            <span class="label label-success">NEW</span>
                        @else
                            <span class="label label-danger">0</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <!--<li class="header">You have {{$ctmsg}} Reply</li>-->
                        @if(empty($detailMessage))
                            <li class="header">You have 0 Reply Unread</li>
                        @endif
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach($detailMessage as $msg)
                                    <li>
                                        <a href="{{url('/member/messages-show/'.$msg['id'].'')}}">
                                            <div class="pull-left">
                                                
                                            @if($msg['image'] != null)
                                              <img src="{{asset('admin-lte/dist/img/avatar/'.$msg['image'])}}" class="img-circle" alt="">
                                            @else
                                              <img src="{{asset('images/avatar.png')}}" class="img-circle" alt="">
                                            @endif
                                            </div>
                                            <h4>
                                                {{isset($msg['subject'])?substr($msg['subject'], 0, 20).(strlen($msg['subject']) > 20 ? ' ...' : '') : '-'}}
                                                <small><i class="fa fa-clock-o"></i> {{\Carbon\Carbon::createFromTimeStamp(strtotime($msg['created_at']))->diffForHumans()}}</small>
                                            </h4>
                                            <p>{{isset($msg['message'])?substr($msg['message'], 0, 25).(strlen($msg['message']) > 25 ? ' ...' : '') : '-'}}</p>
                                            @if($msg['reply_count'] == 0)
                                              <p><span class="label label-danger">{{$msg['reply_count']}} Reply Unread</span></p>
                                            @else
                                              <p><span class="label label-success">{{$msg['reply_count']}} Reply Unread</span></p>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{url('/member/messages')}}">See All Messages</a></li>
                    </ul>
                  </li>
                  <li><a href="{{url('/member/pusat-informasi')}}" class="btn-loading"><i class="fa fa-info-circle"></i></a></li>
               </ul>
            </div>
         </nav>
      </header>

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
         <section class="sidebar">
            <div class="user-panel">
                  <div class="pull-left image">
                    @if($notifValidation == 0)
                          @if(Auth::user()->image != null)
                          <img src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" class="img-circle img-responsive" alt="User Image">
                          @else
                          <img src="{{asset('images/avatar.png')}}" class="img-circle img-responsive" alt="User Image">
                          @endif
                    @else
                        <div class="bungkus">
                          @if(Auth::user()->image != null)
                          <img src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" class="awe img-circle img-responsive img-profile" alt="User Image">
                          @else
                          <img src="{{asset('images/avatar.png')}}" class="awe img-circle img-responsive img-profile" alt="User Image">
                          @endif
                          <!--<div class="center"><i class="fa fa-check" style="font-size:45px;"></i></div>-->
                        <div class="center"><img  class="img-verif" src="{{asset('img/log-verified.png')}}" alt="{{Auth::user()->name}}"></div>
                       </div>
                    @endif
                </div>
               <div class="pull-left info">
                  <p>{{isset(Auth::user()->name)?Auth::user()->name:''}}</p>
                  <span style="text-transform:uppercase;font-size:12px;">{{isset(Auth::user()->roles()->first()->display_name)?Auth::user()->roles()->first()->display_name:''}}</span> 
                  <!--@if(isset(Auth::user()->roles()->first()->name)?Auth::user()->roles()->first()->name == 'member':'')-->
                  <!--<a href="#" style="font-size:12px;margin-left:5px;"><span class="label" style="padding-top:4px;border:2px solid #337ab7;color:#337ab7;">UPGRADE AGENT</span></a>-->
                  <!--@endif-->
               </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
               <li class="{{ url('/member') == request()->url() ? 'active' : '' }}"><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
               <?php
                  $html_string = App\AppModel\MenuSubmenu::rendermenu();
                  echo $html_string;
                ?>
            </ul>
         </section>
      </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
              <div class="loading">
                  @if(!empty($pengumuman))
                      <div id="announcement" style="padding: 20px 30px;background: #FF6E2D;z-index: 999999;font-size: 16px;font-weight: 600;"><a onclick="closeAnnouncement();" class="pull-right" href="javascript:void(0);" data-toggle="tooltip" data-placement="left" title="" style="color: rgb(255, 255, 255); font-size: 20px;" data-original-title="">×</a><a href="{{$pengumuman->link}}" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;">{!!$pengumuman->content!!}</a></div>
                    
                  @endif
                  @yield('content')
              </div>
        </div>

        <style>
            .box__tab{
                display: none;
            }

            @media screen and (max-width: 780px) {
            	.title-footer{
            	    font-size:11px;
            	    text-align:center;
            	}
            }

            @media(max-width: 576px){
                .box__tab{
                    position: fixed !important;
                    bottom: 0 !important;
                    background: #fff;
                    display: block;
                    width: 100%;
                }

                .box__tab ul{
                    align-items: center;
                    justify-content: space-around;
                    display: flex;
                    text-align: center;
                }

                .box__tab ul li a{
                    color: #ACACAC;
                }

                .box__tab ul li a.active{
                    color: #32CD32;
                }

                .box__tab ul li a i{
                   font-size: 24px;
                }

                .box__tab ul li a span{
                   font-size: 12px;
                }

                .box__tab ul li a:hover{
                    color: #ACACAC;
                }

                .box__tab ul li a:focus{
                    color: #ACACAC;
                }

                .paginate_button.active a{
                    background-color: #32CD32 !important;
                    border-color: #32CD32 !important;
                }

                .box__tab .nav li a{
                    padding: 10px 11px;
                }
            }
        </style>

        <!-- Tab Mobile --> 
        <nav class="box__tab">
            <ul class="nav " role="tablist" id="box__tab">
                <li class="nav-item" href="#" onclick="window.location.href=`{{ url('/member/') }}`">
                    <a class="nav-item nav-link {{ Request::is('member') ? 'active' : '' }}" data-toggle="pill" href="#" role="tab" aria-selected="true">
                        <i class="icofont icofont-ui-home"></i>
                        <div>Beranda</div>
                    </a>
                </li>
                <li class="nav-item" href="#" onclick="window.location.href=`{{ url('/member/deposit/') }}`">
                    <a class="nav-item nav-link {{ Request::is('member/deposit') ? 'active' : '' }}" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                        <i class="icofont icofont-plus-circle"></i> <br>
                        <div>Isi Saldo</div>
                    </a>
                </li>
                <li class="nav-item" onclick="window.location.href=`{{ url('/member/riwayat-transaksi/') }}`">
                    <a class="nav-item nav-link {{ Request::is('member/riwayat-transaksi') ? 'active' : '' }}" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                        <i class="icofont icofont-shopping-cart"></i>
                        <div>Pesanan</div>
                    </a>
                </li>
                <li class="nav-item" onclick="window.location.href=`{{ url('/member/tagihan-pembayaran') }}`">
                    <a class="nav-item nav-link {{ Request::is('member/tagihan-pembayaran') ? 'active' : '' }}" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                        <i class="icofont icofont-notification"></i>
                        <div>Notifikasi</div>
                    </a>
                </li>
                <li class="nav-item" target="_blank" onclick="window.open('https://wa.me/628197456456?text=Hallo%20Agen%20Pembayaran%20Online,%20saya%20butuh%20bantuan.%0AMohon%20dibantu...')">
                    <a class="nav-item nav-link" data-toggle="pill" href="#" role="tab" aria-controls="tanggapan-pembeli" aria-selected="false">
                        <i class="icofont icofont-social-whatsapp"></i> 
                        <div>Chat CS</div>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Penutup Tab Mobile --> 

      <footer class="main-footer title-footer">
         <div class="pull-right hidden-xs hidden-sm">
            <b style="font-style: italic;">{{$GeneralSettings->motto}}</b>
         </div>
         <strong>Copyright &copy; <a href="{{$GeneralSettings->website}}" class="custom__text-green">{{$GeneralSettings->nama_sistem}}</a> {{date('Y')}}.</strong>
      </footer>

   </div>
   <!-- ./wrapper -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
   <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.2.1/bloodhound.min.js"></script>  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js"></script>
   <script src="{{asset('admin-lte/dist/js/adminlte.min.js')}}"></script>
   <script src="{{asset('admin-lte/dist/js/demo.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.js"></script>
   <script src="https://cdn.jsdelivr.net/clipboard.js/1.5.12/clipboard.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bignumber.js/4.1.0/bignumber.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bignumber.js/4.1.0/bignumber.js.map"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bignumber.js/4.1.0/bignumber.min.js"></script> -->

   <script>
     toastr.options = {
       "positionClass": "toast-bottom-right",
     }
     @if(Session::has('alert-success'))
         toastr.success("{!! addslashes(Session::get('alert-success')) !!}");
     @endif

     @if(Session::has('alert-info'))
         toastr.info("{!! addslashes(Session::get('alert-info')) !!}");
     @endif

     @if(Session::has('alert-warning'))
         toastr.warning("{!! addslashes(Session::get('alert-warning')) !!}");
     @endif

     @if(Session::has('alert-error'))
         toastr.error("{!! addslashes(Session::get('alert-error')) !!}");
     @endif
   </script>
   <script>
        if (document.documentElement.clientWidth < 780) {
            $('.btn-loading').on('click', function(){
                // $('.loading').html("<div class='hidden-lg' style='text-align:center;'><i class='fa fa-spinner fa-4x faa-spin animated text-primary' style='margin-top:100px;'></i></div>");
                $('.sidebar-mini').removeClass('sidebar-open');
                
            });
            $('.box-penjelasan').addClass('collapsed-box');
            $('.box-minus').removeAttr('style');
            $('.header-profile').removeAttr('style');
        }
        $('.submit').on('click', function(){
           $('.submit').html("<i class='fa fa-spinner faa-spin animated' style='margin-right:5px;'></i> Loading...");
           $('.submit').attr('style', 'cursor:not-allowed;pointer-events: none;');
        });
        
        function closeAnnouncement() {
            $("#announcement").remove();
        }

        function closeAnnouncement() {
            $("#announcement").remove();
        }
         var base_url = function(url){
        
          return $('meta[name="base-url"]').attr('content')+"/"+url;
         }
    </script>
    
    <script>
        function triggerOnline() {
            $.ajax({
                url: "{{ url('/member/trigger-online') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(s) {
                    
                },
                error: function(e) {
                    console.log(e);
                }
            })
        }
        
        $(function() {
            triggerOnline();
            setInterval(triggerOnline, 60 * 1000);
        });
    </script>

   @yield('js')
   
</body>
</html>
