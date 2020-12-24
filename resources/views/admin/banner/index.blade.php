@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs">
<h1>Kontrol Banner <small>Banner</small></h1>
<ol class="breadcrumb">
 	<li><a href="#"><i class="fa fa-dashboard"></i> Kontrol Banner</a></li>
 	<li class="active">Banner</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">SLIDER</h3>
               
                <a href="{{route('banner.menu.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Banner" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
               <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <table class="table table-striped" id="table-banner">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th>ID</th>
                          <th>Nama Image</th>
                          <th>Image </th>
                          <th>Type</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                     <tbody>
                        <?php $no=1; ?>
                        @foreach($databanner as $banner)
                        <tr style="font-size: 14px;">
                            <td>{{$no++}}</td>
                            <td>{{$banner->id}}</td>
                            <td>{{strtoupper($banner->name_img)}}</td>
                            <!-- <td><img src="{{public_path().$banner->img_path}}" alt="..."></td> -->
                            <!-- <td><img src="{{public_path().$banner->img_path}}" alt="..."></td> -->
                            <!-- <img src="{{ asset('uploads/joew.png') }}" /> -->
                            <td class="text-center"><img src="{{asset($banner->img_path)}}" height="20px"></td>
                            <!-- <td>{{$banner->img_path}}</td> -->
                            <td>{{strtoupper($banner->type_img)}}</td>
                            <td>
                                <form method="POST" action="{{ route('delete.banner', $banner->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{url('admin/banner/edit-banner/'.$banner->id )}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <!-- <a href="{{url('/edit-banner/'.$banner->type_img.'/'.$banner->id )}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a> -->
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
               </table>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
   </div>
</section>
@endsection
@section('js')
<script>
   $(function () {
      $('#table-banner').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "iDisplayLength": 50,
        "searching": true,
        "lengthChange": false,
        "info": false
      });
   });

  function nonaktifkanMenu($id)
  {
    console.log('nonaktifkan:',$id);
      var id = $id;
        $.ajax({
            url: "{{ route('menu.kontrol.nonaktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                  window.setTimeout(function(){
                     location.href="{{route('kontrol.menu.index')}}";
                  } ,2000);

                // tableMenu = $('#table-menu').DataTable();
                // tableMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

  function aktifkanMenu($id)
  {
    console.log('aktifkan:',$id);
        var id = $id;
        $.ajax({
            url: "{{ route('menu.kontrol.aktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                  window.setTimeout(function(){
                     location.href="{{route('kontrol.menu.index')}}";
                  } ,2000);

                // tableMenu = $('#table-menu').DataTable();
                // tableMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

  function nonaktifkanSubMenu($id)
  {
    console.log('nonaktifkan:',$id);
      var id = $id;
        $.ajax({
            url: "{{ route('sub.menu.kontrol.nonaktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                  window.setTimeout(function(){
                     location.href="{{route('kontrol.menu.index')}}";
                  } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

  function aktifkanSubMenu($id)
  {
    console.log('aktifkan:',$id);
        var id = $id;
        $.ajax({
            url: "{{ route('sub.menu.kontrol.aktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                  window.setTimeout(function(){
                     location.href="{{route('kontrol.menu.index')}}";
                  } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }
</script>

@endsection