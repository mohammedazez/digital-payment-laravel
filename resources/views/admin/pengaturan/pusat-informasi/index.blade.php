@extends('layouts.admin')

@section('content')
<section class="content-header">
	<h1>Pengaturan <small>Pusat Informasi</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="Javascript:;">Pengaturan</a></li>
    	<li class="active">Pusat Informasi</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Informasi</h3>
                    <a href="{{route('pusat-informasi.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Informasi" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="DataTable" class="table table-hover">
                        <thead>
                            <tr class="custom__text-green">
                                <th>No</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Isi Informasi</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; ?>
                        @if($info->count() > 0)
                        @foreach($info as $data)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$data->title}}</td>
                            <td>{{$data->type}}</td>
                            <td>{!! strip_tags(substr($data->isi_informasi, 0, 50)) !!}...</td>
                            <td>{{$data->created_at}}</td>
                            <td>
                                <form method="POST" action="{{ route('pusat-informasi.destroy', $data->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{route('pusat-informasi.edit', $data->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
$(function () {
   $('#DataTable').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
     "iDisplayLength": 50,
     "searching": false,
     "lengthChange": false,
     "info": false,
     "order": [[ 0, "asc" ]]
   });
});
</script>
@endsection