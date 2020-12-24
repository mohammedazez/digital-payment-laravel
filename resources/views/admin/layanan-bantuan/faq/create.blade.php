@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Pengaturan <small>FAQ</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="{{route('faqs.index')}}" class="btn-loading">FAQ</a></li>
      <li class="active">Tambah FAQ</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('faqs.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah FAQ</h3>
               </div>
               <form role="form" action="{{route('faqs.store')}}" method="post">
               {{csrf_field()}}
                  <div class="box-body">
                     <div class="form-group{{ $errors->has('pertanyaan') ? ' has-error' : '' }}">
                        <label>Pertanyaan : </label>
                        <input type="text" class="form-control" name="pertanyaan" value="{{ old('pertanyaan') }}"  placeholder="Masukkan Pertanyaan">
                        {!! $errors->first('pertanyaan', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                     <div class="form-group{{ $errors->has('jawaban') ? ' has-error' : '' }}">
                        <label>Jawaban : </label>
                        <textarea name="jawaban" class="form-control" rows="5" placeholder="Masukkan Jawaban">{{ old('jawaban') }}</textarea>
                         {!! $errors->first('jawaban', '<p class="help-block"><small>:message</small></p>') !!}
                     </div>
                  </div>

                  <div class="box-footer">
                     <button type="reset" class="btn btn-default">Reset</button>
                     <button type="submit" class="submit btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
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
                     <dt>Pertanyaan</dt>
                     <dd style="font-size: 12px;">Isi dengan Judul Pertanyaan.</dd>
                     <dt>Jawaban</dt>
                     <dd style="font-size: 12px;">Isi dengan Jawaban dari pertanyaan tersebut.</dd>
                  </dl>
               </div><!-- /.box-body -->
            </div><!-- /.box -->
         </div>
      </div>
   </section>

</section>
@endsection