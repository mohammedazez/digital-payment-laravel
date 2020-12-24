@extends('layouts.admin')

@section('content')
<section class="content-header">
<h1>Pengaturan <small>Data Bank</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="Javascript:;">Pengaturan</a></li>
 	<li class="active">Data Bank</li>
</ol>
</section>
<section class="content"> 
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Data Bank</h3>
               <a href="{{route('bank.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Data Bank" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
               <table class="table table-hover">
                  <tr class="text-primary">
                     <th>No</th>
                     <th>Bank ID</th>
                     <th>Nama Bank</th>
                     <th>Nama Pemilik</th>
                     <th>No Rekening</th>
                     <th>Image</th>
                     <th>Action</th>
                  </tr>
                  <?php $no=1; ?>
                  @if($banks->count() > 0)
                  @foreach($banks as $data)
                  <tr style="font-size: 14px;">
                     <td>{{$no++}}</td>
                     <td>{{$data->bank_id}}</td>
                     <td>{{$data->nama_bank}}</td>
                     <td>{{$data->atas_nama}}</td>
                     <td>{{$data->no_rek}}</td>
                     <td><img src="{{asset('/img/'.$data->image)}}" height="20px"></td>
                     <td>
                        <form method="POST" action="{{ route('bank.destroy', $data->id) }}" accept-charset="UTF-8">
                           <input name="_method" type="hidden" value="DELETE">
                           <input name="_token" type="hidden" value="{{ csrf_token() }}">
                           <a href="{{route('bank.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;"><i class="fa fa-pencil"></i></a>
                           <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;"><i class="fa fa-trash"></i></button>
                        </form>
                     </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td colspan='6' align='center'><small style='font-style: italic;'>Data tidak ditemukan</small></td>
                  </tr>
                  @endif
               </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
               @include('pagination.default', ['paginator' => $banks])
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('js')
<script>
  $(function () {
      $('#DataTable').DataTable();
   });
</script>
@endsection