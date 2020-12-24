@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs">
<h1>Kontrol menu <small>Menu dan sub menu</small></h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Kontrol Menu</a></li>
  <li class="active">Menu dan sub menu</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">MENU</h3>
               <!-- /.box-tools -->
            </div>
            <div class="box-header with-border">
               <button type="button" class="btn btn-sm btn-primary btn-sakelar-menu-aktifkan" onclick="aktifkanAllMenu1()"><i class="fa fa-toggle-on"></i> AKTIFKAN SEMUA</button>
               <button type="button" class="btn btn-sm btn-primary btn-sakelar-menu-nonaktifkan" onclick="nonaktifkanAllMenu1()"><i class="fa fa-power-off"></i> NON AKTIFKAN SEMUA</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 <table class="table table-striped" id="table-menu">
                    <thead>
                      <tr>
                          <!-- <th>No</th> -->
                          <th>ID</th>
                          <th>Nama Menu</th>
                          <th>Icon </th>
                          <th>Permission Menu</th>
                          <th>Status</th>
                          <th>On/Off menu</th>
                          <th>Action</th>
                      </tr>
                    </thead>
                     <tbody>
                        <?php $no=1; ?>
                        @foreach($datamenu as $dt)
                        <tr style="font-size: 14px;">
                            <!-- <td>{{$no++}}</td> -->
                            <td>{{$dt->id}}</td>
                            <td>{{$dt->caption}}</td>
                            <td><i class="fa fa-{{$dt->icon}}"></i></td>
                            <td>{{$dt->display_name}}</td>
                            @if($dt->status == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>
                                <!-- <form method="POST" action="{{ route('pembelian-kategori.destroy', $dt->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{route('pembelian-kategori.edit', $dt->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form> -->

                                  @if($dt->status == 1)
                                     <button type="button" class="btn btn-sm btn-danger btn-sakelar-menu-nonaktifkan" style="padding: 2px 5px;font-size: 10px;" onclick="nonaktifkanMenu({{$dt->id}})">NON AKTIFKAN</button>
                                  @else
                                     <button type="button" class="btn btn-sm btn-success btn-sakelar-menu-aktifkan" style="padding: 2px 5px;font-size: 10px;" onclick="aktifkanMenu({{$dt->id}})">AKTIFKAN</button>
                                  @endif
                            </td>
                            <td>
                                <a href="{{url('/admin/kontrol-menu/edit-menu', $dt->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size: 10px;"><i class="fa fa-pencil-square-o fa-fw"></i>Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
               </table>
            </div>
            <!-- /.box-body -->
         </div>
      </div>


      <div class="col-md-12">
         <div class="box box-green">
            <div class="box-header with-border">
               <h3 class="box-title" style="font-size: 13px;font-weight: bold;">SUB MENU</h3>
               <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-header with-border">
               <button type="button" class="btn btn-sm btn-primary btn-sakelar-menu-aktifkan" onclick="aktifkanAllMenu2()"><i class="fa fa-toggle-on"></i> AKTIFKAN SEMUA</button>
               <button type="button" class="btn btn-sm btn-primary btn-sakelar-menu-nonaktifkan" onclick="nonaktifkanAllMenu2()"><i class="fa fa-power-off"></i> NON AKTIFKAN SEMUA</button>
            </div>
            <div class="box-body">
                 <table class="table tabdle-stripe" id="table-submenu" style="width:100%;">
                    <thead>
                      <tr>
                        <!-- <th>No</th> -->
                        <th>ID</th>
                        <th>Menu Parent</th>
                        <th>Nama Sub menu </th>
                        <th>Icon</th>
                        <th>URL</th>
                        <th>Permission Menu</th>
                        <th>Status</th>
                        <th>On/Off menu</th>
                        <th>Action</th>
                      </tr>
                    </thead> 
                    <tbody>
                        <?php $no=1; ?>
                        @foreach($datasubmenu as $sub)
                        <tr style="font-size: 14px;">
                            <!-- <td>{{$no++}}</td> -->
                            <td>{{$sub->id}}</td>
                            <td>{{strtoupper($sub->caption)}}</td>
                            <td>{{$sub->caption_sub}}</td>
                            <td><i class="fa fa-{{$sub->icon_sub}}"></i></td>
                            <td>{{$sub->url}}</td> 
                            <td>{{$sub->display_name}}</td>
                            @if($sub->status_sub == 1)
                            <td><label class="label label-success">AKTIF</label></td>
                            @else
                            <td><label class="label label-danger">TIDAK AKTIF</label></td>
                            @endif
                            <td>
                               <!--  <form method="POST" action="{{ route('pembelian-kategori.destroy', $sub->id) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <a href="{{route('pembelian-kategori.edit', $dt->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger btn-sm" style="padding: 3px 7px;" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit"><i class="fa fa-trash"></i></button>
                                </form> -->

                                  @if($sub->status_sub == 1)
                                     <button type="button" class="btn btn-sm btn-danger btn-sakelar-submenu-nonaktifkan" style="padding: 2px 5px;font-size: 10px;" onclick="nonaktifkanSubMenu({{$sub->id}})">NON AKTIFKAN</button>
                                  @else
                                     <button type="button" class="btn btn-sm btn-success btn-sakelar-submenu-aktifkan" style="padding: 2px 5px;font-size: 10px;" onclick="aktifkanSubMenu({{$sub->id}})">AKTIFKAN</button>
                                  @endif
                            </td>
                            <td>
                                <a href="{{url('/admin/kontrol-menu/edit-submenu', $sub->id)}}" class="btn-loading btn btn-primary btn-sm" style="padding: 2px 5px;font-size: 10px;"><i class="fa fa-pencil-square-o fa-fw"></i>Edit</a>
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
      $('#table-menu').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "iDisplayLength": 50,
        "searching": true,
        "lengthChange": false,
        "info": false
      });
   });

      $(function () {
      $('#table-submenu').DataTable({
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
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('menu.kontrol.nonaktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                $.unblockUI();
              location.reload();
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

      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('menu.kontrol.aktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

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

      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('sub.menu.kontrol.nonaktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

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

      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('sub.menu.kontrol.aktifkan') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",id:id},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

  //ALL AKTIF & NONAKTIF
  
  function aktifkanAllMenu1()
  {
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('all.menu.aktifkan.menu1') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}"},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

    function nonaktifkanAllMenu1()
  {
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('all.menu.nonaktifkan.menu1') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}"},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

    function aktifkanAllMenu2()
  {
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('all.menu.aktifkan.menu2') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}"},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

    function nonaktifkanAllMenu2()
  {
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('all.menu.nonaktifkan.menu2') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}"},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

    function aktifkanAllMenu3()
  {
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('all.menu.aktifkan.menu3') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}"},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

                // tableSubMenu = $('#table-submenu').DataTable();
                // tableSubMenu.ajax.reload( null, false );
            },
            error: function(response){
                console.log(response.responseText);
            }
        });
  }

    function nonaktifkanAllMenu3()
  {
      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
        $.ajax({
            url: "{{ route('all.menu.nonaktifkan.menu3') }}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}"},
            success: function(response){
                $.unblockUI();
              location.reload();
                  // window.setTimeout(function(){
                  //    location.href="{{route('kontrol.menu.index')}}";
                  // } ,2000);

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