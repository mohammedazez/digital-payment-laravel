@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Pengaturan <small>Pusat Informasi</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pengaturan</a></li>
        <li><a href="{{route('pusat-informasi.index')}}" class="btn-loading"> Pusat Informasi</a></li>
    	<li class="active">Ubah Informasi</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('pusat-informasi.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Ubah Informasi</h3>
                </div>
                <form role="form" action="{{route('pusat-informasi.update', $info->id)}}" method="post">
                <input name="_method" type="hidden" value="PATCH">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label>Title : </label>
                            <input type="text" class="form-control" name="title" value="{{$info->title}}"  placeholder="Masukkan Title Informasi">
                            {!! $errors->first('title', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label>Type Informasi : </label>
                            <select name="type" class="form-control">
                                <option value="INFO" {{ $info->type == 'INFO' ? 'selected' : '' }}>INFO</option>
                                <option value="PROMO" {{ $info->type == 'PROMO' ? 'selected' : '' }}>PROMO</option>
                                <option value="MAINTENANCE" {{ $info->type == 'MAINTENANCE' ? 'selected' : '' }}>MAINTENANCE</option>
                            </select>
                            {!! $errors->first('type', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('isi_informasi') ? ' has-error' : '' }}">
                            <label>Isi Informasi : </label>
                            <textarea class="textarea" name="isi_informasi"  placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$info->isi_informasi}}</textarea>
                            {!! $errors->first('isi_informasi', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    $(function () {
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
    });
</script>
@endsection