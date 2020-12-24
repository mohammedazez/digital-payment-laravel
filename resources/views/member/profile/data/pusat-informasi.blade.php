@if($info->count() > 0)
@foreach($info as $data)
<li>
    @if($data->type == 'INFO')
    <i class="fa fa-info bg-blue"></i>
    @elseif($data->type == 'PROMO')
    <i class="fa fa-tags bg-blue"></i>
    @elseif($data->type == 'MAINTENANCE')
    <i class="fa fa-wrench bg-blue"></i>
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
    <i class="fa fa-exclamation-circle bg-blue"></i>
    <div class="timeline-item">
        <div class="timeline-body" style="padding-top: 5px;padding-bottom: 5px;text-align:center;">
            <h4 style="font-style:italic;">Informasi belum tersedia</h4>
        </div>
    </div>
</li>
@endif