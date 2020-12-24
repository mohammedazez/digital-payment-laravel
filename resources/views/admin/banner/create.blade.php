@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs">
<h1>Kontrol Banner <small>Banner</small></h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Kontrol Banner</a></li>
    <li class="active">Banner</li>
</ol>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-green">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('pembelian-kategori.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah Image</h3>
                </div>

                <form action="{{route('upload-gambar.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label>Banner</label>
                            <input type="file" class="form-control image" name="image_add" required="">
                        </div>
                        <div class="form-group">
                            <label>Nama Banner</label>
                            <input type="text" class="form-control" name="name_img" required="">
                        </div>
                        <div class="form-group">
                            <label>Type Gambar : </label>
                            <select name="type" class="form-control" required="">
                                <option value="slider">--Pilih--</option>
                                <option value="slider member">Slider Member</option>
                                <option value="slider home">Slider Home</option>
                                <option value="background home">Background Home</option>
                                <option value="banner">Banner</option>
                            </select>
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