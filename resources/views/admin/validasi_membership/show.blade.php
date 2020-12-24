@extends('layouts.admin')

@section('style')
   <!-- fancy box -->
   <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
   <style type="text/css">
       a.fancybox img {
           border: none;
           box-shadow: 0 1px 7px rgba(0,0,0,0.6);
           -o-transform: scale(1,1); -ms-transform: scale(1,1); -moz-transform: scale(1,1); -webkit-transform: scale(1,1); transform: scale(1,1); -o-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;
       } 
       a.fancybox:hover img {
           position: relative; z-index: 999; -o-transform: scale(1.03,1.03); -ms-transform: scale(1.03,1.03); -moz-transform: scale(1.03,1.03); -webkit-transform: scale(1.03,1.03); transform: scale(1.03,1.03);
       }
   </style>
@endsection
@section('content')
<section class="content-header hidden-xs hidden-sm">
    <h1>Detail <small>Validasi</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/admin/validasi-users')}}" class="btn-loading"> Detail Validasi Users</a></li>
        <li class="active">Detail Validasi #{{$data->id}}</li>
   </ol>
</section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{url('/admin/validasi-users')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Validasi</h3>
               </div>
               <div class="box-body">
                <table class="table" style="font-size:14px;">
                     <tr>
                        <td>ID Validasi</td>
                        <td>:</td>
                        <td>#{{$data->id}}</td>
                     </tr>
                     <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td>{{$data->name}}</td>
                     </tr>
                     <tr>
                        <td>Email User</td>
                        <td>:</td>
                        <td>{{$data->email}}</td>
                     </tr>
                     <tr>
                        <td>Phone</td>
                        <td>:</td>
                        <td>{{$data->phone}}</td>
                     </tr>
                     <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{date("d M Y H:m:s", strtotime($data->created_at))}}</td>
                     </tr>
                     <tr>
                        <td>Dari Level</td>
                        <td>:</td>
                        <td>{{$data->from_role_name}}</td>
                     </tr>
                     <tr>
                        <td>Ke Level</td>
                        <td>:</td>
                        <td>{{$data->to_role_name}}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                         @if($data->status == 0)
                         <td><span class="label label-warning">MENUNGGU</span></td>
                         @elseif($data->status == 1)
                         <td><span class="label label-success">TERVALIDASI</span></td>
                         @elseif($data->status == 2)
                         <td><span class="label label-danger">TIDAK TERVALIDASI</span></td>
                         @endif
                     </tr>
                  </table>
               </div>
               <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom:8px;">
                            <a href="{{url('/admin/membership/approve', $data->id)}}" class="btn-loading btn btn-success btn-sm btn-block" onclick="return confirm('Anda yakin validasi akan di APPROVE ?');"><i class="fa fa-exclamation-circle"></i> APPROVE</a>
                        </div>
                        <div class="col-md-6" style="margin-bottom:8px;">
                            <a href="{{url('/admin/membership/nonapprove', $data->id)}}" class="btn-loading btn btn-danger btn-sm btn-block" onclick="return confirm('Anda yakin validasi akan di CENCEL DAN DIHAPUS ?');"><i class="fa fa-trash"></i> NON APPROVE</a>
                        </div>
                    </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         @if($data->img_siup)
         <div class="col-md-4">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="#" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Foto SIUP / TDP</h3>
               </div>
               <div class="box-body">
                    <img class="fancybox" src="{{ asset('/img/membership/siup/'.$data->img_siup)}}" height="250" width="325;">
               </div>
            </div>
         </div>
         @endif
   </section>

</section>
@endsection
@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $(function($){
       var addToAll = false;
       var gallery = true;
       var titlePosition = 'inside';
       $(addToAll ? 'img' : 'img.fancybox').each(function(){
           var $this = $(this);
           var title = $this.attr('title');
           var src = $this.attr('data-big') || $this.attr('src');
           var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
           $this.wrap(a);
       });
       if (gallery)
           $('a.fancybox').attr('rel', 'fancyboxgallery');
       $('a.fancybox').fancybox({
           titlePosition: titlePosition
       });
   });
   $.noConflict();
});
</script>
@endsection