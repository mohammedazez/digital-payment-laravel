@extends('layouts.admin')

@section('content')
<section class="content-header">
<h1>Pengaturan <small>Terms of Service</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="Javascript:;">Pengaturan</a></li>
 	<li class="active">Terms of Service</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Terms of Service</h3>
               <a href="{{route('tos.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Testimonial" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
               <table class="table table-hover">
                  <tr class="text-primary">
                     <th>No</th>
                     <th>Title</th>
                     <th>content</th>
                     <th>created_at</th>
                     <th>updated_at</th>
                     <th>Action</th>
                  </tr>
                  <?php $no=1; ?>
                  @if($tos->count() > 0)
                  @foreach($tos as $data)
                  <tr style="font-size: 14px;">
                     <td>{{$no++}}</td>
                     <td>{{$data->title}}</td>
                     <td><div style="width:300px"><div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{!! strip_tags(substr($data->content, 0, 400)) !!}</div></div></td>
                     <td>{{$data->created_at}}</td>
                     <td>{{$data->updated_at}}</td>
                     <td>
                        <form method="POST" action="{{ route('tos.destroy', $data->id) }}" accept-charset="UTF-8">
                           <input name="_method" type="hidden" value="DELETE">
                           <input name="_token" type="hidden" value="{{ csrf_token() }}">
                           <a href="{{route('tos.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
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
               @include('pagination.default', ['paginator' => $tos])
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
