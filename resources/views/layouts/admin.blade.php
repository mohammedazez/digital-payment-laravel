<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>{{$GeneralSettings->nama_sistem}} | Administrator</title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   @yield('meta')
    @if(isset($logoku[0]))
      @if($logoku[0]->img !='' || $logoku[0]->img !=null)
        <link rel="shortcut icon" type="image/icon" href=" {{asset('img/logo/'.$logoku[0]->img.'')}}" style="width:16px;height: 16px;"/>
      @endif
    @endif
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
   <link rel="stylesheet" href="https://cdn.rawgit.com/miselputra/larakost-pulsa/0e8ec4f9/bootstrap3-wysihtml5.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.min.css">
   <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-flash.min.css">
   <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">-->
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"> 
   
   <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
   <!--Switchery-->
   <link href="{{ asset('switchery/switchery.min.css')}}" rel="stylesheet">
   <!-- Google Font -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
   <link rel="stylesheet" href="{{asset('css/custom.css')}}">
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
        div.dataTables_wrapper div.dataTables_filter{margin-right: 5px;}
   </style>

   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->

   @yield('style')
</head>
<body class="hold-transition {{$GeneralSettings->skin}} fixed sidebar-mini">
   <div class="wrapper">

      <header class="main-header">
         <a href="{{url('/admin')}}" class="logo custom__bg-greenHover">
            <span class="logo-mini"><b>L</b>P</span>
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
         <nav class="navbar navbar-static-top custom__bg-green">
            <a href="#" class="sidebar-toggle hidden-lg" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
                  <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        @if($ctmsg > 0)
                            <span class="label label-success">NEW</span>
                        @else
                            <span class="label label-danger">0</span>
                        @endif
                        <!--@if($ctmsg > 0)-->
                        <!--    <span class="label label-success">{{$ctmsg}}</span>-->
                        <!--@else-->
                        <!--    <span class="label label-danger">{{$ctmsg}}</span>-->
                        <!--@endif-->
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
                                        <a href="{{url('/admin/messages/show/'.$msg['id'].'')}}">
                                            <div class="pull-left">
                                                
                                            @if($msg['image'] != null)
                                              <img src="{{asset('admin-lte/dist/img/avatar/'.$msg['image'])}}" class="img-circle" alt="">
                                            @else
                                              <img src="{{asset('/ibh/images/default-avatar.svg')}}" class="img-circle" alt="">
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
                  <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->image != null)
                        <img src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" class="user-image" alt="User Image">
                        @else
                        <img src="{{asset('/images/avatar.png')}}" class="user-image" alt="User Image">
                        @endif
                        <span class="hidden-xs">{{Auth::user()->name}}</span>
                     </a>
                     <ul class="dropdown-menu">
                        <li class="user-header">
                           @if(Auth::user()->image != null)
                           <img src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" class="img-circle" alt="User Image">
                           @else
                           <img src="{{asset('/images/avatar.png')}}" class="img-circle" alt="User Image">
                           @endif
                           <p>
                              {{Auth::user()->name}}
                              <small>Member sejak {{date("d M Y H:i:s", strtotime(Auth::user()->created_at))}}</small>
                           </p>
                        </li>
                        <li class="user-footer">
                           <div class="pull-left">
                              <a href="{{url('/member')}}" class="btn-loading btn btn-default btn-flat"><i class="fa fa-home" style="margin-right:5px;"></i> MEMBER</a>
                           </div>
                           <div class="pull-right">
                                <a href="{{ url('/logout') }}" class="btn-loading btn btn-default btn-flat"><i class="fa fa-power-off" style="margin-right:5px;"></i> KELUAR</a>
                           </div>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
      </header>

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
         <section class="sidebar">
            <div class="user-panel">
               <div class="pull-left image">
                  @if(Auth::user()->image != null)
                  <img src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}" class="img-circle" alt="User Image">
                  @else
                  <img src="{{asset('/images/avatar.png')}}" class="img-circle" alt="User Image">
                  @endif
               </div>
               <div class="pull-left info">
                  <p>{{Auth::user()->name}}</p>
                  <a href="#" style="text-transform: uppercase;"><i class="fa fa-circle text-success"></i> {{Auth::user()->roles->first()->display_name}}</a>
               </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
               <li class="{{ url('/admin') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
               <li class="header">Pengaturan Produk</li>
               <li class="treeview">
                  <a href="#">
                     <i class="fa fa-dropbox"></i> <span>Produk (Pembelian)</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li class="{{ route('pembelian-kategori.index') == request()->url() ? 'active' : '' }}"><a href="{{route('pembelian-kategori.index')}}" class="btn-loading"><i class="fa fa-tags" style="text-align: center;"></i> Kategori</a></li>
                     <li class="{{ route('pembelian-operator.index') == request()->url() ? 'active' : '' }}"><a href="{{route('pembelian-operator.index')}}" class="btn-loading"><i class="fa fa-tag" style="text-align: center;"></i> Operator</a></li>
                     <li class="treeview">
                         <a href="#"><i class="fa fa-tag" style="text-align: center;"></i> Produk
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                        <ul class="treeview-menu">
                            <li class="{{ url('/admin/pembelian-produk/markup/role-personal') == request()->url() ? 'active' : '' }}"><a href="{{ url('/admin/pembelian-produk/markup/role-personal')}}" class="btn-loading"><i class="fa fa-users" style="text-align: center;"></i>Level Personal</a></li>
                            <li class="{{ url('/admin/pembelian-produk/markup/role-agen') == request()->url() ? 'active' : '' }}"><a href="{{ url('/admin/pembelian-produk/markup/role-agen')}}" class="btn-loading"><i class="fa fa-users" style="text-align: center;"></i>Level Agen</a></li>
                            <li class="{{ url('/admin/pembelian-produk/markup/role-enterprise') == request()->url() ? 'active' : '' }}"><a href="{{ url('/admin/pembelian-produk/markup/role-enterprise')}}" class="btn-loading"><i class="fa fa-users" style="text-align: center;"></i>Level enterprise</a></li>
                         </ul>
                     </li>
                  </ul>
               </li>
               
               
               <li class="treeview">
                  <a href="#">
                     <i class="fa fa-dropbox"></i> <span>Produk (Pembayaran)</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li class="{{ route('pembayaran-kategori.index') == request()->url() ? 'active' : '' }}"><a href="{{route('pembayaran-kategori.index')}}" class="btn-loading"><i class="fa fa-tags" style="text-align: center;"></i> Kategori</a></li>
                     <li class="{{ route('pembayaran-operator.index') == request()->url() ? 'active' : '' }}"><a href="{{route('pembayaran-operator.index')}}" class="btn-loading"><i class="fa fa-tag" style="text-align: center;"></i> Operator</a></li>
                     <li class="{{ url('/admin/pembayaran-produk') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/pembayaran-produk')}}" class="btn-loading"><i class="fa fa-dropbox" style="text-align: center;"></i> Produk</a></li>
                  </ul>
               </li>
               <li class="header">Data Transaksi</li>
               <li class="{{ url('/admin/transaksi/antrian') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/antrian')}}" class="btn-loading"><i class="fa fa-hourglass" style="text-align: center;"></i> Antrian Transaksi</a></li>
               <li class="{{ url('/admin/transaksi/tagihan') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/tagihan')}}" class="btn-loading"><i class="fa fa-credit-card" style="text-align: center;"></i> Tagihan Pembayaran</a></li>
               <li class="{{ url('/admin/transaksi/produk') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/produk')}}" class="btn-loading"><i class="fa fa-dropbox" style="text-align: center;"></i> Transaksi Produk</a></li>
               <li class="{{ url('/admin/transaksi/deposit') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/deposit')}}" class="btn-loading"><i class="fa fa-money" style="text-align: center;"></i> Transaksi Deposit</a></li>
               <li class="{{ url('/admin/transaksi/transfer-bank') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/transfer-bank')}}" class="btn-loading"><i class="fa fa-random" style="text-align: center;"></i> Transaksi Transfer Bank</a></li>
               <li class="{{ url('/admin/transaksi/paypal') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/paypal')}}" class="btn-loading"><i class="fa fa-paypal" style="text-align: center;"></i> Transaksi Saldo PayPal</a></li>
               <li class="{{ url('/admin/transaksi/redeem') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/transaksi/redeem')}}" class="btn-loading"><i class="fa fa-gift" style="text-align: center;"></i> Reedem Voucher</a></li>
               
               <li class="header">Data Lainnya</li>
               <li class="{{ route('users.index') == request()->url() ? 'active' : '' }}"><a href="{{route('users.index')}}" class="btn-loading"><i class="fa fa-users"></i> <span>Data Users</span></a></li>
               <li class="{{ route('messages.index') == request()->url() ? 'active' : '' }}">
                    <a href="{{route('messages.index')}}" class="btn-loading">
                        <i class="fa fa-inbox"></i> <span>Pesan Masuk</span>
                        @if($notifMessage > 0)
                        <span class="pull-right-container">
                            <small class="label pull-right bg-green">new</small>
                        </span>
                        @endif
                    </a>
               </li>
                <li class="{{ route('admin.blokir.telephone.index') == request()->url() ? 'active' : '' }}"><a href="{{route('admin.blokir.telephone.index')}}" class="btn-loading"><i class="fa fa-ban" style="text-align: center;"></i> Data Blokir Telephone</a></li>
               <li class="{{ route('data.validasi-users.index') == request()->url() ? 'active' : '' }}"><a href="{{route('data.validasi-users.index')}}" class="btn-loading"><i class="fa fa-calendar-check-o" style="text-align: center;"></i> Data Validasi Users</a></li> 
               <li class="{{ route('data.validasi-upgrade.index') == request()->url() ? 'active' : '' }}"><a href="{{route('data.validasi-upgrade.index')}}" class="btn-loading"><i class="fa fa-calendar-check-o" style="text-align: center;"></i> Data Validasi Membership</a></li>
               <li class="{{ route('voucher.index') == request()->url() ? 'active' : '' }}"><a href="{{route('voucher.index')}}" class="btn-loading"><i class="fa fa-ticket" style="text-align: center;"></i> Voucher</a></li>
               <li class="{{ route('testimonial.index') == request()->url() ? 'active' : '' }}"><a href="{{route('testimonial.index')}}" class="btn-loading"><i class="fa fa-trophy" style="text-align: center;"></i> Testimonial</a></li>

               <li class="header">Broadcast</li>
               <li class="{{ url('/admin/broadcast-sms') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/broadcast-sms')}}" class="btn-loading"><i class="fa fa-commenting-o" style="text-align: center;"></i> SMS Massal</a></li>
               <li class="{{ url('/admin/broadcast-email') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/broadcast-email')}}" class="btn-loading"><i class="fa fa-envelope-o" style="text-align: center;"></i> Email Massal</a></li>
               
               <li class="header">SMS Gateway</li>
               <li class="{{ url('/admin/sms-gateway/setting') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/sms-gateway/setting')}}" class="btn-loading"><i class="fa fa-gear" style="text-align: center;"></i> Pengaturan</a></li>
               <li class="{{ url('/admin/sms-gateway/outbox') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/sms-gateway/outbox')}}" class="btn-loading"><i class="fa fa-envelope-o" style="text-align: center;"></i> Kotak Keluar</a></li>
              
                <li class="header">Pengaturan</li>

                <li class="treeview">
                   <a href="javascript:void(0);">
                      <i class="fa fa-gear"></i> <span>Setting-setting</span>
                      <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                      </span>
                   </a>
                   <ul class="treeview-menu">
                     <li class="{{ url('admin/logo') == request()->url() ? 'active' : '' }}"><a href="{{ url('admin/logo')}}" class="btn-loading"><i class="fa fa-picture-o" style="text-align: center;"></i> Setting Logo</a></li>
                     <li class="{{ url('admin/ovo-transfer') == request()->url() ? 'active' : '' }}"><a href="{{ url('admin/ovo-transfer')}}" class="btn-loading"><i class="fa fa-bullseye" style="text-align: center;"></i> Setting OVO Transfer</a></li>
                     <li class="{{ url('admin/setting-trx-paypal') == request()->url() ? 'active' : '' }}"><a href="{{ url('admin/setting-trx-paypal')}}" class="btn-loading"><i class="fa fa-paypal" style="text-align: center;"></i> Setting Pembelian PayPal</a></li>
                     <li class="{{ url('admin/banner') == request()->url() ? 'active' : '' }}"><a href="{{route('banner.menu.index')}}" class="btn-loading"><i class="fa fa-flag" style="text-align: center;"></i>Banner</a></li>
                     <li class="{{ url('admin/setting-kurs') == request()->url() ? 'active' : '' }}"><a href="{{url('admin/setting-kurs')}}" class="btn-loading"><i class="fa fa-money" style="text-align: center;"></i>Rate</a></li>
                     <li class="{{ url('admin/setting-deposit') == request()->url() ? 'active' : '' }}"><a href="{{route('setting.deposit.index')}}" class="btn-loading"><i class="fa fa-money" style="text-align: center;"></i>Minimal Deposit & Fee Deposit</a></li>
                     <li class="{{ url('admin/setting-bonus') == request()->url() ? 'active' : '' }}"><a href="{{route('setting.bonus.index')}}" class="btn-loading"><i class="fa fa-money" style="text-align: center;"></i>Bonus Trx & Referreal</a></li>
                     <li class="{{ route('bank.index') == request()->url() ? 'active' : '' }}"><a href="{{route('bank.index')}}" class="btn-loading"><i class="fa fa-university" style="text-align: center;"></i> Data Bank</a></li>
                     <li class="{{ url('admin/setting-layanan-bantuan') == request()->url() ? 'active' : '' }}"><a href="{{url('admin/setting-layanan-bantuan')}}" class="btn-loading"><i class="fa fa-question-circle" style="text-align: center;"></i>  Layanan Bantuan</a></li>
                     <li class="{{ url('admin/kontrol-menu') == request()->url() ? 'active' : '' }}"><a href="{{route('kontrol.menu.index')}}" class="btn-loading"><i class="fa fa-bars" style="text-align: center;"></i> Kontrol Menu</a></li>
                     <li class="{{ url('/faq') == request()->url() ? 'active' : '' }}"><a href="{{route('faqs.index')}}" class="btn-loading"><i class="fa fa-question-circle" style="text-align: center;"></i>FAQ</a></li>
                     <li class="{{ url('/admin/static-page/about') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/static-page/about')}}" class="btn-loading"><i class="fa fa-question-circle" style="text-align: center;"></i>Tentang Layanan</a></li>
                     <li class="{{ url('/admin/static-page/tos') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/static-page/tos')}}" class="btn-loading"><i class="fa fa-question-circle" style="text-align: center;"></i>Syarat & Ketentuan</a></li>
                     <li class="{{ url('/admin/static-page/privacy-policy') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/static-page/privacy-policy')}}" class="btn-loading"><i class="fa fa-question-circle" style="text-align: center;"></i>Kebijakan Privasi</a></li>
                     <li class="{{ url('admin/setting/security') == request()->url() ? 'active' : '' }}"><a href="{{ url('admin/setting/security') }}" class="btn-loading"><i class="fa fa-lock" style="text-align: center;"></i>Keamanan</a></li>
                     <li class="{{ url('/admin/setting') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/setting')}}" class="btn-loading"><i class="fa fa-server" style="text-align: center;"></i>Sistem</a></li>
                   </ul>
                </li>

                <li class="treeview">
                   <a href="javascript:void(0);">
                      <i class="fa fa-info-circle"></i> <span>Info-info</span>
                      <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                      </span>
                   </a>
                   <ul class="treeview-menu">
                      <li class="{{ url('admin/pengumuman') == request()->url() ? 'active' : '' }}"><a href="{{ url('admin/pengumuman') }}" class="btn-loading"><i class="fa fa-info-circle" style="text-align: center;"></i> Pengumuman</a></li>
                      <li class="{{ route('pusat-informasi.index') == request()->url() ? 'active' : '' }}"><a href="{{route('pusat-informasi.index')}}" class="btn-loading"><i class="fa fa-info-circle" style="text-align: center;"></i> Pusat Informasi</a></li>
                   </ul>
                </li>
                <li class="{{ url('/admin/log-viewer-laravel') == request()->url() ? 'active' : '' }}"><a href="{{url('/admin/log-viewer-laravel')}}" class="btn-loading"><i class="fa fa-warning" style="text-align: center;"></i> Log Viewer</a></li>
            
            </ul>
         </section>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
            <div class="loading">
                @yield('content')
            </div>
      </div>
        <style>
            @media screen and (max-width: 780px) {
            	.title-footer{
            	    font-size:11px;
            	    text-align:center;
            	}
            }
        </style>
      <footer class="main-footer title-footer">
         <div class="pull-right hidden-xs">
            <b style="font-style: italic;">{{$GeneralSettings->motto}}</b>
         </div>
         <strong>Copyright &copy; <a href="{{$GeneralSettings->website}}" class="custom__text-green">{{$GeneralSettings->nama_sistem}}</a> {{date('Y')}}.</strong>
      </footer>

   </div>
   <!-- ./wrapper -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js"></script>
   <script src="{{asset('admin-lte/dist/js/adminlte.min.js')}}"></script>
   <script src="{{asset('admin-lte/dist/js/demo.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   <script src="https://cdn.rawgit.com/miselputra/larakost-pulsa/aa5b609b/bootstrap3-wysihtml5.all.min.js"></script>
   <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
   <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.min.js"></script>-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
  <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/bignumber.js/4.1.0/bignumber.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bignumber.js/4.1.0/bignumber.js.map"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bignumber.js/4.1.0/bignumber.min.js"></script> -->
   
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script src="{{asset('switchery/switchery.min.js')}}"></script>
    
 
   <script>
     toastr.options = {
       "positionClass": "toast-bottom-right",
     }
     @if(Session::has('alert-success'))
         toastr.success("{{ Session::get('alert-success') }}");
     @endif

     @if(Session::has('alert-info'))
         toastr.info("{{ Session::get('alert-info') }}");
     @endif

     @if(Session::has('alert-warning'))
         toastr.warning("{{ Session::get('alert-warning') }}");
     @endif

     @if(Session::has('alert-error'))
         toastr.error("{{ Session::get('alert-error') }}");
     @endif
   </script>
   
    <!--Switchery-->
    <script>
      var elems = Array.prototype.slice.call(document.querySelectorAll('input[data-plugin=switchery]'));
      elems.forEach(function(html) {

          var switchery = new Switchery(html,{className: "switchery switchery-small"});
      });
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
      
    </script>

   @yield('js')
</body>
</html>
