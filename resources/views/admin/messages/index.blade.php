@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Inbox <small>Pesan Masuk</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
 	<li class="active">Pesan Masuk</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Pesan Masuk</h3>
               <div class="box-tools">
                  @include('pagination.default', ['paginator' => $messages])
               </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
               <table class="table table-hover">
                  <tr class="custom__text-green">
                     <th>No</th>
                     <th>Subject</th>
                     <th>Nama</th>
                     <th>Email</th>
                     <th>No HP</th>
                     <th>Status</th>
                     <th>Tanggal Masuk</th>
                     <th>Action</th>
                  </tr>
                  <?php $no=1; ?>
                  @if($messages->count() > 0)
                  @foreach($messages as $data)
                  <tr style="font-size: 14px;">
                     <td>{{$no++}}</td>
                     <td>{{$data->subject}}</td>
                     <td>{{$data->name}}</td>
                     <td>{{$data->email}}</td>
                     <td>{{$data->phone}}</td>
                     @if($data->status == 0)
                     <td><label class="label label-warning">Belum Dibaca</label></td>
                     @else
                     <td><label class="label label-success">Sudah Dibaca</label></td>
                     @endif
                     <!--<td>{{$data->created_at}}</td>-->
                     <td>{{date("d M Y H:i:s", strtotime($data->updated_at))}}</td>
                     <td>
                        <form method="POST" action="{{ route('admin.message.delete', $data->id) }}" accept-charset="UTF-8">
                           <input name="_method" type="hidden" value="DELETE">
                           <input name="_token" type="hidden" value="{{ csrf_token() }}">
                           <a href="{{route('admin.message.show', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;"><i class="fa fa-search"></i></a>
                           <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;"><i class="fa fa-trash"></i></button>
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
               @include('pagination.default', ['paginator' => $messages])
            </div>
         </div>
      </div><!-- /.box -->
   </div>
</section>
@endsection