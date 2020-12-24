@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Pengaturan <small>Terms of Service</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="{{route('tos.index')}}" class="btn-loading">Terms of Service</a></li>
      <li class="active">Tambah Terms of Service</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-7">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('tos.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah Terms of Service</h3>
               </div>
               <form role="form" action="{{route('tos.store')}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label>Title : </label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}"  placeholder="Masukkan Title">
                        {!! $errors->first('title', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                        <label>Isi TOS/Content : </label>
                        <textarea class="textarea" name="content" placeholder="Masukkan Content atau isi TOS" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('content') }}</textarea>
                         {!! $errors->first('content', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" class="submit btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-5">
            <div class="box box-solid box-penjelasan">
               <div class="box-header with-border">
                    <i class="fa fa-text-width"></i>
                    <h3 class="box-title">Penjelasan Form</h3>
                    <div class="box-tools pull-right box-minus" style="display:none;">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
               </div><!-- /.box-header -->
               <div class="box-body">
                  <dl>
                     <dt>Nama</dt>
                     <dd style="font-size: 12px;">Isi dengan Nama Pemberi Testimoni.</dd>
                     <dt>Pekerjaan</dt>
                     <dd style="font-size: 12px;">Isi dengan Pekerjaan/Profesi Pemberi Testimoni.</dd>
                     <dt>Review/Isi Testimoni</dt>
                     <dd style="font-size: 12px;">Isi dengan Hasil Review/Isi Testimonia dari Pemberi Testimoni.</dd>
                     <dt>Penilaian</dt>
                     <dd style="font-size: 12px;">Pilih Jumlah Penilaian terhadap aplikasi ini.</dd>
                     <dt>Avatar/Foto</dt>
                     <dd style="font-size: 12px;">Foto/Avatar dari pemberi review/testimoni.</dd>
                  </dl>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection
@section('js')
<script>
   $(function () {
      $(".textarea").wysihtml5({
         toolbar: {
          "font-styles": true, // Font styling, e.g. h1, h2, etc.
          "emphasis": true, // Italics, bold, etc.
          "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
          "html": false, // Button which allows you to edit the generated HTML.
          "link": true, // Button to insert a link.
          "image": false, // Button to insert an image.
          "color": false, // Button to change color of font
          "blockquote": true, // Blockquote
          "size": 10 // options are xs, sm, lg
        }
      });
   });
</script>
@endsection