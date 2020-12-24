@extends('layouts.admin')
@section('style')
<link href="{{ asset('/admin-lte/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
	<h1>Halaman <small><a href="{{ url($page->slug) }}" class="custom__text-green" target="_blank">{{ $page->title }}</a></small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Halaman Statis</a></li>
    	<li class="active">{{ $page->title }}</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-green">
                <div class="box-header">
                    <h3 class="box-title">{{ $page->title }}</h3><br/>
                    <a href="{{ url($page->slug) }}" class="custom__text-green" target="_blank">{{ url($page->slug) }}</a>
                </div>
                <form role="form" action="" method="POST">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label>Judul : </label>
                            <input type="text" class="form-control" name="title" placeholder="" style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" value="{{ $page->title }}" required>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Isi Konten : </label>
                            <textarea class="textarea" name="content" placeholder="" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ html_entity_decode($page->content, ENT_QUOTES) }}</textarea>
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
<script src="{{ asset('/admin-lte/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script>
    $(function() {
        $('textarea[name=content]').wysihtml5();
    });
</script>
@endsection