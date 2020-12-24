@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Pengaturan <small>Testimonial</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="Javascript:;">Pengaturan</a></li>
 	<li class="active">Testimonial</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Testimonial</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
               <table class="table table-hover">
                  <tr class="text-primary">
                     <th>No</th>
                     <th>Nama</th>
                     <th>Review</th>
                     <th>Penilaian</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
                  <?php $no=1; ?>
                  @if($testimonials->count() > 0)
                  @foreach($testimonials as $data)
                  <tr style="font-size: 14px;">
                     <td>{{$no++}}</td>
                     <td>{{$data->user->name}}</td>
                     <td><div style="width:450px"><div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$data->review}}</div></div></td>
                     <td>{{$data->rate}}</td>
                     @if($data->status == 1)
                     <td><label class="label label-success">Aktif</label></td>
                     @else
                     <td><label class="label label-danger">Tidak Aktif</label></td>
                     @endif
                     <td>
                        <form method="POST" action="{{ route('testimonial.destroy', $data->id) }}" accept-charset="UTF-8">
                           <input name="_method" type="hidden" value="DELETE">
                           <input name="_token" type="hidden" value="{{ csrf_token() }}">
                           <a href="{{route('testimonial.show', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-search"></i></a>
                           <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 3px 7px;"><i class="fa fa-trash"></i></button>
                        </form>
                     </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan='7' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
               @include('pagination.default', ['paginator' => $testimonials])
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
