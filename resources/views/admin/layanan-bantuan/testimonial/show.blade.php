@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Pengaturan <small>Testimonial</small></h1>
   <ol class="breadcrumb">
    	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="Javascript:;">Pengaturan</a></li>
      <li><a href="{{route('testimonial.index')}}" class="btn-loading">Testimonial</a></li>
      <li class="active">Detail Testimonial</li>
   </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title"><a href="{{route('testimonial.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Detail Testmonial</h3>
               </div>
                <div class="box-body">
                    <table class="table" style="font-size:14px;">
                        <tr>
                            <td width="30%">Nama</td>
                            <td width="5%">:</td>
                            <td>{{$testimonials->user->name}}</td>
                        </tr>
                        <tr>
                            <td>Review</td>
                            <td>:</td>
                            <td>{{$testimonials->review}}</td>
                        </tr>
                        <tr>
                            <td>Penilaian/Rate</td>
                            <td>:</td>
                            <td>
                                <?php
                                    for($i=1;$i<=$testimonials->rate;$i++){
                                ?>
                                        <i class="fa fa-star"></i>
                                <?php
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <form method="POST" action="{{ route('testimonial.update', $testimonials->id) }}" accept-charset="UTF-8">
                        <input name="_method" type="hidden" value="PATCH">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <a href="{{url('/admin/testimonial')}}" class="btn-loading btn btn-default"><i class="fa fa-arrow-circle-left" style="margin-right: 5px;"></i> Kembali</a>
                        @if($testimonials->status == 1)
                        <button class="submit btn btn-danger" onclick="return confirm('Anda yakin akan menon aktifkan testimonials ?');" type="submit"><i class="fa fa-eye-slash"></i> Non Aktifkan</button>
                        @else
                        <button class="submit btn btn-success" onclick="return confirm('Anda yakin akan aktifkan testimonials ?');" type="submit"><i class="fa fa-eye"></i> Aktifkan</button>
                        @endif
                </div>
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