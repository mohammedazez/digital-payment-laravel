@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Pengaturan <small>Pengumuman</small></h1>
    <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pengaturan</a></li>
    	<li class="active">Pengumuman</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{ url('/admin/pengumuman') }}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Pengumuman</h3>
                </div>
                <form role="form" action="{{ url('/admin/pengumuman') }}" method="POST">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label>Isi Pengumuman : </label>
                            <textarea class="textarea" name="content" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ html_entity_decode($p->content, ENT_QUOTES) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Link </label>
                            <input class="form-control" name="link" placeholder="" value="{{$p->link}}" >
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