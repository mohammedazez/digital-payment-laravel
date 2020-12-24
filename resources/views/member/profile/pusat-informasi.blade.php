@extends('layouts.member')

@section('content')
<section class="content-header hidden-xs">
<h1>Pusat<small> Informasi</small></h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">Pusat Informasi</li>
</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12">
            <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label"><span class="custom__bg-greenTwo" style="padding-right: 20px;padding-left: 20px;">Pusat Informasi</span></li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                @if($info->count() > 0)
                @foreach($info as $data)
                <li>
                    @if($data->type == 'INFO')
                    <i class="fa fa-info custom__bg-greenTwo"></i>
                    @elseif($data->type == 'PROMO')
                    <i class="fa fa-tags custom__bg-greenTwo"></i>
                    @elseif($data->type == 'MAINTENANCE')
                    <i class="fa fa-wrench custom__bg-greenTwo"></i>
                    @endif
                    <div class="timeline-item">
                        <h3 class="timeline-header" style="font-size:15px;"><a href="#">[{{$data->type}}]</a> {{$data->title}}</h3>
                        <div class="timeline-body">{!! $data->isi_informasi !!}</div>
                        
                        <div class="timeline-footer" style="border-top:1px solid #F2F2F2;padding-top:8px;padding-bottom:8px;">
                            <span class="time" style="font-size:13px;color:#969696;"><i class="fa fa-clock-o"></i> {{date("d M Y H:m:s", strtotime($data->created_at))}}</span>
                        </div>
                    </div>
                </li>
                @endforeach
                @else
                <li>
                    <i class="fa fa-exclamation-circle custom__bg-greenTwo"></i>
                    <div class="timeline-item">
                        <div class="timeline-body" style="padding-top: 5px;padding-bottom: 5px;text-align:center;">
                            <h4 style="font-style:italic;">Informasi belum tersedia</h4>
                        </div>
                    </div>
                </li>
                @endif
                
                <li>
                  <i class="fa fa-clock-o bg-gray"></i>
                </li>
              </ul>
        </div>
    </div>

</section>
@endsection